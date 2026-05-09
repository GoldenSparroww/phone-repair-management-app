<?php

namespace App\Domain\Entity\Device;


use App\Domain\Entity\Customer\Customer;

/**
 * Doménová entita reprezentující zařízení zákazníka.
 * Uchovává informace o hardwaru (značka, model, sériové číslo) a odkazuje na svého vlastníka (Customer).
 */
class Device
{
    private ?int $id = null;
    private string $brand;
    private string $model;
    private string $serial;
    private Customer $customer;

    public function __construct(string $brand, string $model, string $serial, Customer $customer)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->serial = $serial;
        $this->customer = $customer;
    }

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): ?int { return $this->id; }
    public function getBrand(): string { return $this->brand; }
    public function getModel(): string { return $this->model; }
    public function getSerial(): string { return $this->serial; }
    public function getCustomer(): Customer { return $this->customer; }
}