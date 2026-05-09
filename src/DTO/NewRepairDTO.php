<?php

namespace App\DTO;

class NewRepairDTO
{
    public function __construct(
        public readonly string $customerPhone,
        public readonly string $brand,
        public readonly string $model,
        public readonly string $serial,
        public readonly string $startDate,
        public readonly string $expectedEndDate,
        public readonly string $description
    ) {}
}