<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Employee\Employee;

/**
 * Rozhraní pro návrhový vzor State.
 * Definuje sjednocené metody pro akce, které lze nad opravou provést v různých fázích jejího životního cyklu.
 */
interface RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void;
    public function markAsRepaired(Repair $repair): void;
    public function createInvoice(Repair $repair): void;
    public function getStatusName(): string;
}