<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;
use PDO;

class RepairDAO extends AbstractDAO
{
    public function fetchAll(): array
    {
        $sql = "SELECT * FROM repairs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchById(int $id): ?array
    {
        $sql = "SELECT * FROM repairs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}