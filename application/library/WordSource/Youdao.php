<?php

class WordSource_Youdao extends WordSource_Abstract {
    public function buildUrl() {
        //$url = 'http://www.iciba.com/index.php?a=getWordMean&c=search&list=1&word='.$this->word;
        $url = 'http://dict.youdao.com/w/'.$this->word;
        return $url;
    }

    public function parse($htmlStr) {

        $this->ukAudio = "http://dict.youdao.com/dictvoice?audio={$this->word}&type=1";
        $this->usAudio = "http://dict.youdao.com/dictvoice?audio={$this->word}&type=2";
        $pattern = '/<\/h2>\s+<div class="trans\-container">(.*?)<\/div>/s';
        $ret = preg_match_all($pattern, $htmlStr, $matches);

        if ($ret!=1) {
            throw new Exception("解析错误", 1);
        }
        $ret = preg_match_all('/<li>(\w+)\.\s+(.*?)<\/li>/', $matches[1][0], $matches);
        $interpretation = array();
        foreach ($matches[1] as $key => $val) {
            $interpretation[$val] = trim($matches[2][$key]);
        }
        $this->interpretation = json_encode($interpretation);

        $this->phEn = $wordInfo['baesInfo']['symbols'][0]['ph_en'];
        $this->phAm = $wordInfo['baesInfo']['symbols'][0]['ph_am'];

        $parts = array();
        foreach ($wordInfo['baesInfo']['symbols'][0]['parts'] as $row) {
            $parts[$row['part']] = implode(';', $row['means']);
        }
        $this->interpretation = json_encode($parts);
    }
}