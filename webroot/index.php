<?php
define("APP_PATH", '/Users/wutianfang/work/WRecite/');
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
