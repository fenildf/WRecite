<?php

class TagsController extends Yaf_Controller_Abstract {

    private $daoWords = null;
    public function init() {
        $this->baseDao = new Dao_Base();
    }

    public function listAction() {

        if (!empty($_POST['name'])) {
            $sql = 'insert into tags(name) values("'.$_POST['name'].'")';
            $this->baseDao->exec($sql);
            $urls = parse_url($_SERVER['REQUEST_URI']);
            $url = 'http://'.$_SERVER['HTTP_HOST'].$urls['path'];
            header("Location: $url");
            die();
        }

        $sql = 'select * from tags order by id desc';
        $tags = $this->baseDao->query($sql);


        $data = array('tags'=>$tags);
        $this->getView()->display('tags/list.php', $data);
    }

}