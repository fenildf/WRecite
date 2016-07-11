<?php

class WordSource_Iciba extends WordSource_Abstract {
    public function buildUrl() {
        $url = 'http://www.iciba.com/'.$this->word;

        return $url;
    }

    public function parse($htmlStr) {
        $this->interpretation = json_encode($this->paraseDesc($htmlStr));
        $audioUrls = $this->parseMp3Url($htmlStr);
        $this->ukAudio = $audioUrls[0];
        $this->usAudio = $audioUrls[1];
    }

    private function parseMp3Url($html) {
        $pattern = '/<i class=\'new-speak-step\'(.*?)>/';
        $retCount = preg_match_all($pattern, $html, $matches);
        if ($retCount!=2) {
            throw new Exception('页面解析错误');
        }
        $pattern = '/http:\/\/(.*?)\.mp3/';
        $ret = array();
        foreach ($matches[1] as $row) {
            preg_match($pattern, $row, $match);
            if (strlen($match[0])>10) {
                $ret[] = $match[0];
            }
        }
        return $ret;
    }

    private function paraseDesc($html) {
        $pattern = "/<ul class='base\-list switch_part' >(.*?)<\/ul>/s";
        $retCount = preg_match_all($pattern, $html, $matches);
        $html = str_replace(array(" ","\n","\r", "\t"), '', $matches[1][0]);

        $pattern = "/<spanclass(.*?)>(.*?)<\/span><p>(.*?)<\/p>/s";
        $retCount = preg_match_all($pattern, $html, $matches);
        $ret = array();
        for ($i=0; $i< $retCount; $i++) {
            $ret[$matches[2][$i]] = $matches[3][$i];
        }
        return $ret;
    }
}