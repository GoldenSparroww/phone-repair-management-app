<?php

namespace App\Services;

use App\Domain\Entity\Customer\Customer;
use App\Persistence\Repository\CustomerRepository;
use Exception;

class CustomerService
{
    public function __construct(
        private CustomerRepository $customerRepository
    ) {}

    public function createNewCustomer(
        string $firstName, string $lastName, string $phone, string $email,
        string $city, ?string $street, int $houseNo, int $zip
    ): void {
        // Kontrola, zda zákazník s tímto telefonem již neexistuje
        $existingCustomer = $this->customerRepository->findByPhone($phone);
        if ($existingCustomer) {
            throw new Exception("Zákazník s telefonním číslem {$phone} již v databázi existuje.");
        }

        $customer = new Customer(
            $firstName, $lastName, $phone, $email, $city, $street, $houseNo, $zip
        );

        $this->customerRepository->save($customer);
    }
}