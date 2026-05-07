<?php

namespace App\Domain\Entity;

class Repair
{
    public function __construct(
        private int $id,
        private string $deviceName,
        private string $status
    ) {}

    public function getId(): int { return $this->id; }
    public function getDeviceName(): string { return $this->deviceName; }
    public function getStatus(): string { return $this->status; }
}