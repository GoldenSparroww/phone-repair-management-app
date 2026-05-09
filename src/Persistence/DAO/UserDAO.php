<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

/**
 * Data Access Object pro tabulku uživatelů.
 * Zajišťuje přímou komunikaci s databází a provádění SQL dotazů nutných pro autentizaci.
 */
class UserDAO extends AbstractDAO
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT id, email, role, hash FROM employees WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}