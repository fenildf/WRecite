<?php

class Bootstrap extends Yaf_Bootstrap_Abstract{
    public function _initView($dispatcher) {
        $dispatcher->autoRender(false);
    }

    public function _initConst() {
        define('VIEW_PATH', APP_PATH.'application/views/');
        define('BASE_HOST', 'http://'.$_SERVER['HTTP_HOST'].'/WRecite/');
    }
}
