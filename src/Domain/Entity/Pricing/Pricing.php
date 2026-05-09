<?php
namespace App\Domain\Entity\Pricing;

class Pricing
{
    private ?int $id = null;
    private string $repairType;
    private int $minPrice;
    private int $maxPrice;

    public function __construct(string $repairType, int $minPrice, int $maxPrice)
    {
        $this->repairType = $repairType;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): ?int { return $this->id; }
    public function getRepairType(): string { return $this->repairType; }
    public function getMinPrice(): int { return $this->minPrice; }
    public function getMaxPrice(): int { return $this->maxPrice; }
}