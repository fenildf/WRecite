<?php

class Util_Format {

    static function interpretation($interpretation) {
        if (!$interpretation) {
            return '';
        }
        $interpretation = json_decode($interpretation, true);
        $s = array();
        foreach ($interpretation as $key => $val) {
            $s[] = $key.' : '.$val;
        }
        return implode("<br />\n", $s);
    }
}