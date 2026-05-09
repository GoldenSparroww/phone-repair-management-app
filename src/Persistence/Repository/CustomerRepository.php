<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Customer\Customer;
use App\Persistence\DAO\CustomerDAO;

class CustomerRepository
{
    public function __construct(
        private CustomerDAO $dao
    ) {}

    public function findByPhone(string $phone): ?Customer
    {
        $row = $this->dao->findByPhone($phone);
        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    public function findById(int $id): ?Customer
    {
        $row = $this->dao->findById($id);
        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    private function mapRowToEntity(array $row): Customer
    {
        $customer = new Customer(
            $row['first_name'],
            $row['last_name'],
            $row['phone'],
            $row['email'],
            $row['city'],
            $row['street'],
            $row['house_no'],
            $row['zip']
        );

        $customer->setId((int)$row['id']);

        return $customer;
    }

    public function save(Customer $customer): void
    {
        if ($customer->getId() === null) {
            $id = $this->dao->insert([
                'first_name' => $customer->getFirstName(),
                'last_name'  => $customer->getLastName(),
                'phone'      => $customer->getPhone(),
                'email'      => $customer->getEmail(),
                'city'       => $customer->getCity(),
                'street'     => $customer->getStreet(),
                'house_no'   => $customer->getHouseNo(),
                'zip'        => $customer->getZip()
            ]);
            $customer->setId($id);
        } else {
            throw new \Exception('Error!');
        }
    }
}