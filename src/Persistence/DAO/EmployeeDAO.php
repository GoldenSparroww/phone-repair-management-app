<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

/**
 * Data Access Object pro tabulku employees.
 * Zajišťuje přímou komunikaci s databází a provádění SQL dotazů pro záznamy o zaměstnancích.
 */
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

    public function getAllTechnicians(): array
    {
        $sql = "SELECT * FROM employees WHERE role = 'service technician'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}