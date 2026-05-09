<?php
namespace App\Domain\Entity\Customer;

class Customer
{
    private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private string $phone;
    private string $email;
    private string $city;
    private ?string $street;
    private int $houseNo;
    private int $zip;

    public function __construct(
        string $firstName,
        string $lastName,
        string $phone,
        string $email,
        string $city,
        ?string $street,
        int $houseNo,
        int $zip
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->city = $city;
        $this->street = $street;
        $this->houseNo = $houseNo;
        $this->zip = $zip;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getHouseNo(): int
    {
        return $this->houseNo;
    }

    public function setHouseNo(int $houseNo): void
    {
        $this->houseNo = $houseNo;
    }

    public function getZip(): int
    {
        return $this->zip;
    }

    public function setZip(int $zip): void
    {
        $this->zip = $zip;
    }
}