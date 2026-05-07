<?php

namespace App\Persistence\Repository;

use App\Persistence\DAO\RepairDAO;
use App\Domain\Entity\Repair;

class RepairRepository
{
    public function __construct(
        private readonly RepairDAO $dao
    ) {
    }

    /** @return Repair[] */
    public function findAll(): array
    {
        $rawData = $this->dao->fetchAll();
        $entities = [];

        foreach ($rawData as $row) {
            $entities[] = new Repair(
                (int)$row['id'],
                $row['device_name'],
                $row['status']
            );
        }

        return $entities;
    }
}