<?php
/**
 * Created by PhpStorm.
 * User: zoco
 * Date: 17/2/4
 * Time: 18:13
 */

namespace App\Models;

/**
 * Class Third
 *
 * @package App\Models
 */
class Weather extends Main {

    public static function get($city)
    {
        $res_str = null;
        $data = array(
            'units' => 'metric',
            'APPID' => 'd6ef0178ef9d6d2c2fae60f4863c7e17',
            'q' => $city,
        );
        $url = "http://api.openweathermap.org/data/2.5/weather?" . http_build_query($data);
        $res = Tool::curl($url);

        if (!isset($res['name'])) {
            $res_str = 'Can\'t get weather from that city.';
        } else {
            $res_str = "The temperature in {$res['name']} ({$res['sys']['country']}) is {$res['main']['temp']} °C" . PHP_EOL;
            $res_str .= "Current conditions are: {$res['weather'][0]['description']} {$res['weather'][0]['main']}";
        }

        return $res_str;
    }
}