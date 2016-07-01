<?php

class Bootstrap extends Yaf_Bootstrap_Abstract{
    public function _initView($dispatcher) {
        $dispatcher->autoRender(false);
    }
}
