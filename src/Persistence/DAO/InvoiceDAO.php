<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

/**
 * Data Access Object pro tabulku invoices.
 * Zajišťuje přímou komunikaci s databází a provádění SQL dotazů pro záznamy o fakturách.
 */
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