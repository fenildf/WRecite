<?php

class Util_Curl {
    static function get($url, $timeout=3) {
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_URL, $url);
        // curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $conf['connect_timeout']);
        curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ci, CURLOPT_HEADER, false);

        $response = curl_exec($ci);
        $ret = curl_exec($ci);

        if ($ret==false) {
            var_dump(curl_error($ci));
            var_dump(curl_errno($ci));
        }
        return $ret;
    }
}
