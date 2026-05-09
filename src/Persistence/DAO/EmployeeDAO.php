<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

class EmployeeDAO extends AbstractDAO
{
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM employees WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }
}