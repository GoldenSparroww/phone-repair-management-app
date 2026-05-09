<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

class DeviceDAO extends AbstractDAO
{
    public function findBySerial(string $serial): ?array
    {
        $sql = "SELECT * FROM devices WHERE serial = :serial LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['serial' => $serial]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM devices WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function insert(array $data): int
    {
        $sql = "INSERT INTO devices (brand, model, serial, customer_id) 
                VALUES (:brand, :model, :serial, :customer_id)";

        $this->db->prepare($sql)->execute([
            'brand' => $data['brand'],
            'model' => $data['model'],
            'serial' => $data['serial'],
            'customer_id' => $data['customer_id']
        ]);

        return (int)$this->db->lastInsertId();
    }
}