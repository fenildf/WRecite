<?php
class WordController extends Yaf_Controller_Abstract {

    private $daoWords = null;
    public function init() {
        $this->daoWords = new Dao_Words();
    }

    public function tagAction() {
        $data = array();
        $name = trim($_GET['name']);
        $word = empty($_POST['word']) ? false : trim($_POST['word']);

        if (!$name) {
            echo "name 错误！";
            die();
        }
        $sql = "select * from tags where name='$name' ";
        $rows = $this->daoWords->query($sql);
        $tagid = $rows[0]['id'];
        if (count($rows)==0) {
            echo "name 错误！";
            die();
        }

        if ($word) {
            $this->loadAudio($word);
            $this->saveDb($word);
            $sql = "insert into tag_words(tag_id, word) values($tagid, '${word}')";
            $this->daoWords->query($sql);
        }
        $sql = "select * from tag_words where tag_id=$tagid order by id";
        $rows = $this->daoWords->query($sql);
        $data = array('rows'=>$rows);
        $this->getView()->display('word/tag.php', $data);
    }


    public function listAction() {
        $sql = 'select * from words;';
        $rows = $this->daoWords->query($sql);
        $baseUrl = Util_Config::get('words/audioBashUrl');

        $data = array(
            'rows' => $rows,
        );
        $this->getView()->display('word/list.php', $data);
    }

    public function addAction() {
        $word = $this->getRequest()->getQuery('w');

        $this->loadAudio($word);
        $this->saveDb($word);

        $ret = array(
            'code' => 0,
            'message' => '',
            'data' => array(),
        );
        echo json_encode($ret);
    }

    private function saveDb($word) {
        $time = date('Y-m-d H:i:s');
        try {
            $rows = $this->daoWords->query("select * from words where word='$word'");
            if (count($rows)>0) {
                return true;
            }
            $ret = $this->daoWords->query("insert into words values('$word', '$time')");
        } catch (Throwable $e) {
            var_dump($e);
        }
        return $ret;
    }

    private function loadAudio($word) {
        $icibaDao = new Dao_Iciba();
        $wordHtml = $icibaDao->getWordHtml($word);
        $audioUrls = $this->parseMp3Url($wordHtml);

        $audioBasePath = Util_Config::get('words/audioPath');

        $this->downloadAudio($audioUrls[0], $audioBasePath.'/uk/'.substr($word,0,2).'/'.$word.'.mp3');
        $this->downloadAudio($audioUrls[1], $audioBasePath.'/us/'.substr($word,0,2).'/'.$word.'.mp3');

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

    private function downloadAudio($url, $path) {
        $dirname = dirname($path);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }
        $cmd = "wget $url  --output-document=$path ";
        exec($cmd);
    }

    public function error_handler() {
        print_r(func_get_args());
    }

    public function testAction() {
        //set_error_handler(array($this, 'error_handler'));
        $list = [3,4,9];
        //var_dump($list);
        try {
            echo $list['adsf'];
            $this->adf();
            $i = 4/0;
        } catch (Throwable $e) {
            //var_dump($e);
            echo 'error';
        }
    }
}
