<?php
define("APP_PATH", '/Users/wutianfang/work/WRecite/');
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->bootstrap();

$wordsDao = new Dao_Words();

$sql = 'select * from words where interpretation is null';
$rows = $wordsDao->query($sql);
$count = count($rows);
foreach ($rows as $index => $row) {
    // echo $row['word'];
    $source = new WordSource_Iciba($row['word']);
    $source->import();
    echo '['.date('Y-m-d H:i:s')."][$index/$count]\t {$row['word']} done.\n";
    sleep(1);
}