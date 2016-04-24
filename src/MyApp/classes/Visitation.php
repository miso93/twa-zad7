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

    public static function triggerVisit($IP, $country_code, $city, $countryFullName)
    {
        $arr = [
            'IP'           => $IP,
            'country_code' => $country_code,
            'date'         => Carbon::now()->format('Y-m-d'),
            'city'         => $city,
            'country_name' => $countryFullName
        ];
        $result = dibi::query('SELECT COUNT(*) as count FROM ' . self::$table . ' WHERE IP=? AND date=?', $arr['IP'], $arr['date']);
        if ($result->fetchAll()[0]->count == 0) {
            dibi::query('INSERT INTO ' . self::$table, $arr);
        }

    }


}