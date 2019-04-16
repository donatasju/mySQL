<?php

namespace Core;

use PDO;

class Connection extends Database\Abstracts\Connection {

    public function __construct($creds) {
        try {
            $this->pdo = new PDO(
                    "mysql:host=$this->host", $this->user, $this->pass
            );

            if (DEBUG) {
                $this->pdo->setAttribute(PDO::ATTR_EMULATE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            }
        } catch (\PDOException $ex) {
            throw new Exception('Could not connect to database');
        }
    }

    public function connect() {
        
    }

}
