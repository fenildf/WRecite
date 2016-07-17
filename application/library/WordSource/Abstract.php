<?php

abstract class WordSource_Abstract {

    protected $word = '';
    protected $ukAudio = null;
    protected $usAudio = null;

    protected $phEn = null;
    protected $phAm = null;

    protected $interpretation = null;
    protected $daoWords = null;

    public function __construct($word) {
        $this->word = $word;
        $this->daoWords = new Dao_Words();
    }

    public function import() {

        // 基础解析
        $url = $this->buildUrl();
        $htmlStr = $this->getHtml($url);
        $this->parse($htmlStr);

        // 下载
        $audioBasePath = Util_Config::get('words/audioPath');
        $usAudioFilePath = $audioBasePath.'/us/'.substr($this->word,0,2).'/'.$this->word.'.mp3';
        $ukAudioFilePath = $audioBasePath.'/uk/'.substr($this->word,0,2).'/'.$this->word.'.mp3';

        $this->downloadAudio($this->usAudio, $usAudioFilePath);
        $this->downloadAudio($this->ukAudio, $ukAudioFilePath);

        // 存数据库
        $time = date('Y-m-d H:i:s');
        $rows = $this->daoWords->query("select * from words where word='{$this->word}'");
        if (count($rows)>0) {
            $sql = "update words set interpretation='{$this->interpretation}', ph_en='{$this->phEn}', ph_am='{$this->phAm}' where word='{$this->word}'";
            $this->daoWords->exec($sql);
        } else {
            $sql = "insert into words values('{$this->word}', '{$time}', '{$this->interpretation}', '{$this->phEn}', '{$this->phAm}')";
            $this->daoWords->exec($sql);
        }
    }

    abstract public function buildUrl();

    abstract public function parse($html);


    private function downloadAudio($url, $path) {
        $dirname = dirname($path);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }
        $cmd = "wget $url  --output-document=$path > /dev/null 2>&1";
        exec($cmd);
    }

    private function getHtml($url) {
        return Util_Curl::get($url);
    }
}