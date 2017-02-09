<?php
/**
 * Created by PhpStorm.
 * User: zoco
 * Date: 17/2/4
 * Time: 18:13
 */

namespace App\Models;

/**
 * Class Tool
 *
 * @package App\Models
 */
class Tool extends Main {

    /**
     * @param        $url
     * @param null   $post
     * @param string $type
     * @return bool|mixed
     */
    static public function curl($url, $post = null, $type = 'json')
    {
        if (empty($url)) {
            $err = 'post error url';
            z_log($err);
            return false;
        }

        $before_time = self::microtime_float();

        $res = '';
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            if (!is_null($post)) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
            }

            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            z_log('Common: url=%s'. $url);
            z_log('Common: data=%s'. print_r($post, true));

            if ($res === false || $info['http_code'] != 200) {
                $err = "post token url={$url} contents=" . print_r($post, true) . ' res=' . print_r($res, true);
                z_log($err);

                return $res;
            }

            if ($type == 'json') {
                $res = json_decode($res, true);
            }

            z_log('Common: res=%s'. print_r($res, true));
            z_log('Common: time=%s'. (self::microtime_float() - $before_time));
        } catch (\Exception $exc) {
            $err = "post token url={$url} contents=" . print_r($post, true) . ' res=' . print_r($res, true);
            z_log($err);
        }

        return $res;
    }

    /**
     * @return float
     */
    public static function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());

        return ((float) $usec + (float) $sec);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function autoLink($str='') {

        if($str=='' or !preg_match('/(http|www\.|@)/i', $str)) { return $str; }

        $lines = explode("\n", $str); $new_text = '';
        while (list($k,$l) = each($lines)) {
            unset($k);
            $l = preg_replace("/([ \t]|^)www\./i", "\\1http://www.", $l);
            $l = preg_replace("/([ \t]|^)ftp\./i", "\\1ftp://ftp.", $l);
            $l = preg_replace("/(http:\/\/[^ )!]+)/i", "<a target=\"_blank\" href=\"\\1\">\\1</a>", $l);
            $l = preg_replace("/(https:\/\/[^ )!]+)/i", "<a target=\"_blank\" href=\"\\1\">\\1</a>", $l);
            $l = preg_replace("/(ftp:\/\/[^ )!]+)/i", "<a target=\"_blank\" href=\"\\1\">\\1</a>", $l);
            $l = preg_replace("/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i", "<a target=\"_blank\" href=\"mailto:\\1\">\\1</a>", $l);

            $new_text .= $l."\n";
        }

        return $new_text;
    }
}