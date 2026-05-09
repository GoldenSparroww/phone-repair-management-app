<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Employee\Employee;

interface RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void;
    public function markAsRepaired(Repair $repair): void;
    public function createInvoice(Repair $repair): void;
    public function getStatusName(): string;
}