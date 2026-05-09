<?php

namespace App\DTO;

/**
 * Datový přenosový objekt (DTO) pro vytvoření nebo úpravu opravy.
 * Slouží k bezpečnému předání dat z uživatelského rozhraní do servisní vrstvy bez vazby na HTTP požadavek.
 */
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