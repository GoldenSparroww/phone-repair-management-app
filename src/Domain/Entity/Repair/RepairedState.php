<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Employee\Employee;
use Exception;

class RepairedState implements RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void
    {
        throw new Exception("Oprava je již dokončena, nelze měnit technika.");
    }

    public function markAsRepaired(Repair $repair): void
    {
        throw new Exception("Tato oprava již byla označena jako dokončená.");
    }

    public function createInvoice(Repair $repair): void
    {
        $repair->setState(new InvoicedState());
    }

    public function getStatusName(): string
    {
        return 'Opravena';
    }
}