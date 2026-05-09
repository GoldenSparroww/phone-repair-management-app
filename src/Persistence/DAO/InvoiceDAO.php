<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

class InvoiceDAO extends AbstractDAO
{
    public function insert(array $data): int
    {
        $sql = "INSERT INTO invoices (issued, due, method, customer_id) 
                VALUES (:issued, :due, :method, :customer_id)";
        $this->db->prepare($sql)->execute($data);
        return (int)$this->db->lastInsertId();
    }
}