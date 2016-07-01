<?php

class Dao_Iciba {
    public function __construct() {

    }

    public function getWordHtml($word) {
        $url = 'http://www.iciba.com/'.$word;
        $html = Util_Curl::get($url);
        return $html;
    }

}