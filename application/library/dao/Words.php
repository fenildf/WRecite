<?php

class Dao_Words {
    private $db = null;

    public function __construct() {
        $dbFile = Util_Config::get('words/sqlite3File');
        $this->db = new SQLite3($dbFile);
    }

    public function query($sql) {
        $result = $this->db->query($sql);
        $ret = array();
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ret[] = $row;
        }
        return $ret;
    }

    public function exec($sql) {
        return $this->db->exec($sql);
    }

}