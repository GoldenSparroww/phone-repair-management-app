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

    public function insert(array $data): int
    {
        $sql = "INSERT INTO customers (first_name, last_name, phone, email, city, street, house_no, zip) 
                VALUES (:first_name, :last_name, :phone, :email, :city, :street, :house_no, :zip)";

        $this->db->prepare($sql)->execute([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'city'       => $data['city'],
            'street'     => $data['street'],
            'house_no'   => $data['house_no'],
            'zip'        => $data['zip']
        ]);

        return (int)$this->db->lastInsertId();
    }
}