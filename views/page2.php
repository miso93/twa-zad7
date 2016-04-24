<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 19.04.2016
 * Time: 23:17
 */

Classes\View::get('template.header');
?>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <td>Key</td>
                    <td>Value</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>IP</td>
                    <td><?php echo getRealIp() ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php

$geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']));

var_dump($geoplugin);

if (is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude'])) {

    $lat = $geoplugin['geoplugin_latitude'];
    $long = $geoplugin['geoplugin_longitude'];
    var_dump($lat);
    var_dump($long);

    //set farenheight for US
    if ($geoplugin['geoplugin_countryCode'] == 'US') {
        $tempScale = 'fahrenheit';
        $tempUnit = '&deg;F';
    } else {
        $tempScale = 'celsius';
        $tempUnit = '&deg;C';
    }
//    require_once('ParseXml.class.php');

//    $xml = new ParseXml();
//    $xml->LoadRemote("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query={$lat},{$long}", 3);
//    $dataArray = $xml->ToArray();
//
//    $html = "<center><h2>Weather forecast for " . $geoplugin['geoplugin_city'];
//    $html .= "</h2><table cellpadding=5 cellspacing=10><tr>";
//
//    foreach ($dataArray['simpleforecast']['forecastday'] as $arr) {
//
//        $html .= "<td align='center'>" . $arr['date']['weekday'] . "<br />";
//        $html .= "<img src='http://icons-pe.wxug.com/i/c/a/" . $arr['icon'] . ".gif' border=0 /><br />";
//        $html .= "<font color='red'>" . $arr['high'][$tempScale] . $tempUnit . " </font>";
//        $html .= "<font color='blue'>" . $arr['low'][$tempScale] . $tempUnit . "</font>";
//        $html .= "</td>";
//
//
//    }
//    $html .= "</tr></table>";

//    echo $html;
}

?>
    ?>


<?php
Classes\View::get('template.footer');