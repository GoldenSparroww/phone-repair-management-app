<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;
use PDO;

class PricingDAO extends AbstractDAO
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM pricing ORDER BY repair_type ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM pricing WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }
}