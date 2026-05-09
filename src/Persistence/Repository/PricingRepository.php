<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Pricing\Pricing;
use App\Persistence\DAO\PricingDAO;

class PricingRepository
{
    public function __construct(
        private PricingDAO $dao
    ) {}

    public function getAll(): array
    {
        $rows = $this->dao->getAll();
        $pricingList = [];

        foreach ($rows as $row) {
            $pricingList[] = $this->mapRowToEntity($row);
        }

        return $pricingList;
    }

    public function findById(int $id): ?Pricing
    {
        $row = $this->dao->findById($id);

        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    private function mapRowToEntity(array $row): Pricing
    {
        $pricing = new Pricing(
            $row['repair_type'],
            (int)$row['min_price'],
            (int)$row['max_price']
        );

        $pricing->setId((int)$row['id']);

        return $pricing;
    }
}