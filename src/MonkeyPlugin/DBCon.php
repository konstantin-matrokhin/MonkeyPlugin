<?php

namespace MonkeyPlugin;

use Exception;
use mysqli;

class DBCon {

    private $host = 'localhost';
    private $user = 'root';
    private $password = '****';
    private $db = 'monkeycraft';

    public function connect() {
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
        $mysqli->set_charset('utf8');
        if ($mysqli->connect_error) throw new Exception($mysqli->connect_error);
        return $mysqli;
    }

    public function query($q) {
        return $this->connect()->query($q);
    }

}

?>