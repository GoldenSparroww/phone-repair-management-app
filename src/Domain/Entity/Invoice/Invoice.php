<?php

namespace App\Domain\Entity\Invoice;

use App\Domain\Entity\Customer\Customer;

class Invoice
{
    private ?int $id = null;
    private string $issued;
    private string $due;
    private string $method;
    private int $customerId;

    public function __construct(string $issued, string $due, string $method, int $customerId)
    {
        $this->issued = $issued;
        $this->due = $due;
        $this->method = $method;
        $this->customerId = $customerId;
    }

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): ?int { return $this->id; }
    public function getIssued(): string { return $this->issued; }
    public function getDue(): string { return $this->due; }
    public function getMethod(): string { return $this->method; }
    public function getCustomerId(): int { return $this->customerId; }
}