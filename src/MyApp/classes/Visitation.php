<?php
use Carbon\Carbon;
use Classes\Model;

/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 24.04.2016
 * Time: 23:05
 */
class Visitation extends Model
{

    protected static $table = "visitations";

    public $IP;
    public $country_code;
    public $date;
    public $city;
    public $country_name;

    public function __construct($id)
    {
        $result = dibi::query('SELECT * FROM ' . self::$table . ' WHERE id = ?', $id);
        $fetch = $result->fetch();
        if ($fetch) {
            $this->IP = $fetch->IP;
            $this->country_code = $fetch->country_code;
            $this->date = $fetch->date;
            $this->city = $fetch->city;
            $this->country_name = $fetch->country_name;

        }
    }

    public static function fetchAllByCountryCode($country_code)
    {
        try {
            $result = dibi::query('SELECT * FROM ' . self::$table . ' WHERE country_code = ?', $country_code);

            $objects = static::toCollection($result->fetchAll());
            return $objects;
            
        } catch (\Dibi\Exception $e) {
            print $e->getSql();
        }

        return null;
    }

    public static function triggerVisit($location, $IP, $country_code, $city, $countryFullName)
    {
        $client = new \GuzzleHttp\Client();
        list($lat, $long) = explode(',', $location);

        $url = "http://api.timezonedb.com/?lat=".$lat."&lng=".$long."&key=8FLKHGJ4LBH2&format=json";
        $res = $client->request('GET', $url);
        $timezoneObj = json_decode($res->getBody());

        $arr = [
            'IP'           => $IP,
            'country_code' => $country_code,
            'date'         => Carbon::now()->setTimezone($timezoneObj->zoneName),
            'city'         => $city,
            'country_name' => $countryFullName,
            'page_id' => \Classes\ViewData::get('page_id')
        ];

        $result = dibi::query('SELECT COUNT(*) as count FROM ' . self::$table . ' WHERE IP=? AND date=?', $arr['IP'], $arr['date']);
        if ($result->fetchAll()[0]->count == 0) {
            dibi::query('INSERT INTO ' . self::$table, $arr);
        }

    }


}