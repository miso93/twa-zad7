<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 19.04.2016
 * Time: 23:17
 */

Classes\View::get('template.header');

$user_ip = app()->get_user_IP();
app()->init_geo_plugin();

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
                    <td><?php echo $user_ip ?></td>
                </tr>
                <tr>
                    <td>GPS</td>
                    <td><?php echo (($location = app()->parseLocation()) ? "[".$location['lat'].", ".$location['long']. "]" : 'App can\'t get location' ) ?></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><?php echo (($cityName = app()->getCityName()) ? $cityName : "mesto sa nedá lokalizovať alebo sa nachádzate na vidieku")?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td><?php echo (($countryName = app()->getCountryName()) ? $countryName : "stat sa nedá lokalizovať alebo sa nachádzate na vidieku")?></td>
                </tr>
                <tr>
                    <td>Capital city</td>
                    <td><?php echo (($capitalCityName = app()->getCapitalCity()) ? $capitalCityName : "hlavne mesto sa nedá lokalizovať alebo sa nachádzate na vidieku")?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php

?>

<?php
Classes\View::get('template.footer');