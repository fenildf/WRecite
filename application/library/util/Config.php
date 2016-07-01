<?php

class Util_Config {
    static private $conf = null;
    static public function init() {
        self::$conf = new Yaf_Config_Ini(APP_PATH.'/conf/application.ini');
    }

    static function get($key) {
        $keys = explode('/', trim($key,'/ '));
        $conf = self::$conf->get($keys[0]);
        for ($i=1; $i< count($keys); $i++) {
            $conf = $conf->{$keys[$i]};
        }
        return $conf;
    }

}
Util_Config::init();