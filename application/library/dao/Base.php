<?php

class Dao_Base {
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

    public function execByValues($sql) {
        $args = func_get_args();
        array_shift($args);
        $sth = $this->db->prepare($sql);
        foreach ($args as $key => $arg) {
            $sth->bindValue($key+1, $arg);
        }

        $sth->execute();
    }

}
