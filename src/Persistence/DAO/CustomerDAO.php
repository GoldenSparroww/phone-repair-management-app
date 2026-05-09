<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

class CustomerDAO extends AbstractDAO
{
    public function findByPhone(string $phone): ?array
    {
        $sql = "SELECT * FROM customers WHERE phone = :phone LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['phone' => $phone]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM customers WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }
}