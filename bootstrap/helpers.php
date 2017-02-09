<?php

if (!function_exists('z_debug')) {
    function z_debug($var)
    {
        echo '<div style="direction: ltr !important; text-align: left !important;"><pre>';
        print_r($var);
        echo '</pre></div>';
        exit();
    }
}

if (!function_exists('z_log')) {
    function z_log($content) {
        file_put_contents(__DIR__ . '/../log/log.txt', date('Ymd H:i:s') . "\t" . $content . "\n", FILE_APPEND);
    }
}
