<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 22:07
 */
if (session_id() == "") {
    session_start();
}

require_once "config.php";
require __DIR__ . '/vendor/autoload.php';

dibi::connect([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => Config::get('mysql.user'),
    'password' => Config::get('mysql.pass'),
    'database' => Config::get('mysql.db_name'),
    'charset'  => Config::get('mysql.charset'),
]);

function dd($arr)
{

    ?>
    <pre>
    <?php
    print_r($arr);
    ?>
    </pre>
    <?php
    die();
}

function route($route)
{
    return Config::get('app.base_url') . '/' . $route;
}

class Helper
{

    private static $app = null;

    public static function app()
    {
        if (self::$app == null) {
            self::$app = new App();
        }

        return self::$app;
    }
}

function app()
{
    return Helper::app();
}

class App
{

    private $lat;
    private $long;
    private $tempScale;
    private $tempUnit;
    private $geoplugin_data;
    private $IP;
    private $geocode_location;
    private $country;
    private $countryAbbr;
    private $cityName;
    private $forecast;

    public function get_user_IP()
    {
        if (Config::get('app.env') == "local") {
            $this->IP = "178.40.98.176";

            return $this->IP;
        }
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $this->IP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $this->IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->IP = $_SERVER['REMOTE_ADDR'];
        }

        return $this->IP;
    }

    public function init_geo_plugin()
    {
        $this->geoplugin_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $this->IP));
    }

    public function parseLocation()
    {
        if (is_numeric($this->geoplugin_data['geoplugin_latitude']) && is_numeric($this->geoplugin_data['geoplugin_longitude'])) {
            $this->lat = $this->geoplugin_data['geoplugin_latitude'];
            $this->long = $this->geoplugin_data['geoplugin_longitude'];

            return ['lat' => $this->lat, 'long' => $this->long];
        } else {
            return null;
        }
    }

    public function setTemperatureScaleAndUnit()
    {
        if (is_numeric($this->geoplugin_data['geoplugin_latitude']) && is_numeric($this->geoplugin_data['geoplugin_longitude'])) {
            //set farenheight for US
            if ($this->geoplugin_data['geoplugin_countryCode'] == 'US') {
                $this->tempScale = 'fahrenheit';
                $this->tempUnit = '&deg;F';
            } else {
                $this->tempScale = 'celsius';
                $this->tempUnit = '&deg;C';
            }
        }
    }

    private function initGoogleGeocode()
    {
        $get_API = "http://maps.googleapis.com/maps/api/geocode/json?latlng=";
        $get_API .= round($this->lat, 2) . ",";
        $get_API .= round($this->long, 2);

        $client = new GuzzleHttp\Client();

        $res = $client->request('GET', $get_API . '&sensor=false', [
            'headers' => [
                'Accept-Language' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'sk'
            ]
        ]);

        $this->geocode_location = json_decode($res->getBody());
    }

    public function getCityName()
    {

        if (!$this->geocode_location) {
            $this->initGoogleGeocode();
        }
        if (isset($this->geocode_location->results[1]->address_components[1]->long_name)) {
            $this->cityName = ($this->geocode_location->results[1]->address_components[1]->long_name);

            return $this->cityName;
        } else {
            return null;
        }

    }

    public function getCountryName()
    {
        if (!$this->geocode_location) {
            $this->initGoogleGeocode();
        }

        if (isset($this->geocode_location->results[1]->address_components[3]->long_name)) {
            return ($this->geocode_location->results[1]->address_components[3]->long_name);
        } else {
            return null;
        }
    }

    public function getCapitalCity()
    {
        if (!$this->country) {
            $this->initWorldBankApi();
        }

        if (isset($this->country[1]) && isset($this->country[1][0]) && isset($this->country[1][0]->capitalCity)) {
            return $this->country[1][0]->capitalCity;
        }

        return $this->country;
    }

    public function initWorldBankApi()
    {
        if (!$this->geocode_location) {
            $this->initGoogleGeocode();
        }
        if (isset($this->geocode_location->results[1]->address_components[3]->short_name)) {
            $this->countryAbbr = ($this->geocode_location->results[1]->address_components[3]->short_name);

            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', "http://api.worldbank.org/countries/" . $this->countryAbbr . "?format=json");
            $this->country = json_decode($res->getBody());

        } else {
            return null;
        }
    }

    public function getCountryAbbr()
    {
        if (!$this->countryAbbr) {
            if (!$this->geocode_location) {
                $this->init_geo_plugin();
                $this->parseLocation();
                $this->initGoogleGeocode();
            }
            if (isset($this->geocode_location->results[1]->address_components[3]->short_name)) {
                $this->countryAbbr = ($this->geocode_location->results[1]->address_components[3]->short_name);
            }

        }

        return $this->countryAbbr;
    }

    public function getWeathers()
    {
        if (!$this->lat) {
            $this->init_geo_plugin();
            $this->parseLocation();
        }


        $client = new GuzzleHttp\Client();

        $api_key = "c737a74e126a9266";
        $this->init_geo_plugin();
        $this->parseLocation();
        $this->initGoogleGeocode();
        $this->initWorldBankApi();
        $res = $client->request('GET', "http://api.wunderground.com/api/" . $api_key . "/forecast/q/" . $this->countryAbbr . "/" . $this->getCityName() . ".json");
//        dd($res->getBody()->getContents());
//        $data = simplexml_load_string($res->getBody());
//        dd($data);
        $this->forecast = json_decode($res->getBody());
        $weather_days = [];
//        dd($this->forecast->forecast->txt_forecast->forecastday);
        if (isset($this->forecast->forecast) && isset($this->forecast->forecast->txt_forecast) && isset($this->forecast->forecast->txt_forecast->forecastday)) {
//            var_dump($this->forecast->forecast['forecastday']);
            foreach ($this->forecast->forecast->txt_forecast->forecastday as $arr_data) {
//                dd($arr_data);
                $weather_days[] = WeatherDay::parseFromJSON($arr_data, $this->tempScale, $this->tempUnit);
            }
        }

        return $weather_days;
    }

    public function getVisitationsByCountry()
    {
        $visitations = Visitation::fetchAll();
        $result = [];
        
        foreach($visitations as $visitation){
            if(isset($result[$visitation->country_code])){
                $result[$visitation->country_code]['count'] = $result[$visitation->country_code]['count'] + 1;
            } else {
                $result[$visitation->country_code]['country_name'] = $visitation->country_name;
                $result[$visitation->country_code]['count'] = 1;
            }
        }
        
        return $result;
    }
}

class WeatherDay
{

    public $weekday;
    public $icon;
    public $text;

    public static function parseFromJSON($arr_data, $tempScale, $tempUnit)
    {
//        $arr_data = (array)$arr_data;
        $day = new WeatherDay();

        $day->weekday = (isset($arr_data->title)) ? $arr_data->title : '';
        $day->icon = (isset($arr_data->icon)) ? $arr_data->icon : '';
        if ($tempScale == "celsius") {
            $day->text = (isset($arr_data->fcttext_metric)) ? $arr_data->fcttext_metric : '';
        } else {
            $day->text = (isset($arr_data->fcttext)) ? $arr_data->fcttext : '';
        }

//        $day->high_temperature = (isset($arr_data['high'][$tempScale]) ? $arr_data['high'][$tempScale] . $tempUnit: '');
//        $day->high_temperature = (isset($arr_data['low'][$tempScale]) ? $arr_data['low'][$tempScale] . $tempUnit: '');
        return $day;
    }
}

