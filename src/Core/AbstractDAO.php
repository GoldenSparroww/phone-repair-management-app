<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class AbstractDAO
{
    public function __construct(
        protected PDO $db
    )
    {
    }
}