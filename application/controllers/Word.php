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
        if (count($rows)==0) {
            echo "name 错误！";
            die();
        }
        $taginfo = $rows[0];
        $tagid = $rows[0]['id'];

        if ($word) {
            $wordSource = new WordSource_Iciba($word);
            $wordSource->import();
            $sql = "insert or ignore into tag_words(tag_id, word) values($tagid, '${word}')";
            $this->daoWords->exec($sql);

            $urls = parse_url($_SERVER['REQUEST_URI']);
            $url = 'http://'.$_SERVER['HTTP_HOST'].$urls['path'].'?'.$urls['query'];
            header("Location: $url");
            die();
        }
        $desc = ' desc';
        if (isset($_GET['sort']) && $_GET['sort']=='asc') {
            $desc = ' asc';
        }
        $sql = "select w.word,w.interpretation,w.ph_en, w.ph_am from tag_words as t join words as w on w.word=t.word where t.tag_id=$tagid order by t.id".$desc;
        $rows = $this->daoWords->query($sql);

        foreach ($rows as $rKey => $row) {
            $rows[$rKey]['interpretation'] = Util_Format::interpretation($row['interpretation']);
        }

        $data = array('words'=>$rows, 'taginfo'=>$taginfo,);
        $this->getView()->display('word/tag.php', $data);
    }

    public function listAction() {
        $sql = 'select * from words order by create_time desc;';
        $rows = $this->daoWords->query($sql);
        $baseUrl = Util_Config::get('words/audioBashUrl');

        $data = array(
            'rows' => $rows,
        );
        $this->getView()->display('word/list.php', $data);
    }

    public function addAction() {
        $word = $this->getRequest()->getQuery('w');

        $wordSource = new WordSource_Youdao($word);
        $wordSource->import();


        $ret = array(
            'code' => 0,
            'message' => '',
            'data' => array(),
        );
        echo json_encode($ret);
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
