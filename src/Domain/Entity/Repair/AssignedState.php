<?php
namespace App\Domain\Entity\Repair;

use Exception;
use App\Domain\Entity\Employee\Employee;

class AssignedState implements RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void
    {
        $repair->setTechnician($technician);
    }

    public function markAsRepaired(Repair $repair): void
    {
        $repair->setState(new RepairedState());
    }

    public function createInvoice(Repair $repair): void
    {
        throw new Exception("Nelze vyfakturovat zařízení, které ještě není opraveno.");
    }

    public function getStatusName(): string
    {
        return 'Přiřazená';
    }
}