<?php

namespace App\Services;

use App\Persistence\Repository\RepairRepository;

class RepairService
{
    public function __construct(
        private readonly RepairRepository $repairRepository
    )
    {
    }

    public function getAllRepairs(): array
    {
        return $this->repairRepository->findAll();
    }
}