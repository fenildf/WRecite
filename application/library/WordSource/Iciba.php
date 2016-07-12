<?php

class WordSource_Iciba extends WordSource_Abstract {
    public function buildUrl() {
        $url = 'http://www.iciba.com/index.php?a=getWordMean&c=search&list=1&word='.$this->word;

        return $url;
    }

    public function parse($htmlStr) {
        $wordInfo = json_decode($htmlStr, true);
        $this->ukAudio = $wordInfo['baesInfo']['symbols'][0]['ph_en_mp3'];
        $this->usAudio = $wordInfo['baesInfo']['symbols'][0]['ph_am_mp3'];

        $parts = array();
        foreach ($wordInfo['baesInfo']['symbols'][0]['parts'] as $row) {
            $parts[$row['part']] = implode(';', $row['means']);
        }
        $this->interpretation = json_encode($parts);
    }
}