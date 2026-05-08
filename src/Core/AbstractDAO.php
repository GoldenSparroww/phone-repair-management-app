<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class AbstractDAO
{
    protected PDO $db;

    public function __construct()
    {
        $db_type = EnvHandler::get('DB_TYPE');
        $db_charset = EnvHandler::get('DB_CHARSET');
        $db_host = EnvHandler::get('DB_HOST');
        $db_name = EnvHandler::get('DB_NAME');
        $db_user = EnvHandler::get('DB_USER');
        $db_pass = EnvHandler::get('DB_PASS');

        try {
            $this->db = new PDO("$db_type:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user, $db_pass);
        } catch (PDOException $e) {
            throw new PDOException("There was an error connecting to the database. Try again later. ".$e->getMessage());
        }
    }
}