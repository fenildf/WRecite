<?php

class Dao_Words {
    private $db = null;

    public function __construct() {
        $dbFile = Util_Config::get('words/sqlite3File');
        $this->db = new SQLite3($dbFile);
    }

    public function query($sql) {
        $result = $this->db->query($sql);
        if (!$result instanceof SQLite3Result) {
            return $result;
        }
        $ret = array();
        if ($result)
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ret[] = $row;
        }
        return $ret;
    }

}