<?php
class ForgetController extends Yaf_Controller_Abstract {

    private $daoWords = null;
    public function init() {
        $this->daoWords = new Dao_Words();
    }

    public function addAction() {
        $word = $_GET['word'];
        if (!$word) {
            echo json_encode(array('code'=>2));
            die();
        }
        $sql = "select * from forget_word where word='${word}' and is_remember=0";
        $wordRows = $this->daoWords->query($sql);
        if (count($wordRows)>0) {
            echo json_encode(array('code'=>1));
            die();
        }

        $sql = "insert into forget_word(word) values('${word}')";
        $this->daoWords->exec($sql);

        $ret = array('code'=>0);
        echo json_encode($ret);
    }

    public function removeAction() {
        $word = $_GET['word'];
        if (!$word) {
            echo json_encode(array('code'=>2));
            die();
        }

        //$sql = "update forget_word set is_remember=1 where word='$word'";
        $sql = "delete from forget_word where word='$word'";
        $this->daoWords->exec($sql);

        $ret = array('code'=>0);
        echo json_encode($ret);
    }

    public function listAction() {
        $sql = 'select w.word, w.interpretation, w.ph_en, w.ph_am from forget_word as f join words as w on w.word=f.word where f.is_remember=0';
        $rows = $this->daoWords->query($sql);
        foreach ($rows as $rKey => $row) {
            $rows[$rKey]['interpretation'] = Util_Format::interpretation($row['interpretation']);
        }

        $data = array(
            'words' => $rows,
        );

        $this->getView()->display('forget/list.php', $data);
    }
}