<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Employee\Employee;
use Exception;

/**
 * Konkrétní implementace návrhového vzoru State.
 * Reprezentuje nově vytvořenou opravu, která čeká na přiřazení technikovi.
 */
class UnassignedState implements RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void
    {
        $repair->setTechnician($technician);
        $repair->setState(new AssignedState());
    }

    public function markAsRepaired(Repair $repair): void
    {
        throw new Exception("Oprava nemůže být dokončena, dokud není přiřazena technikovi.");
    }

    public function createInvoice(Repair $repair): void
    {
        throw new Exception("Nelze vyfakturovat neopravené zařízení.");
    }

    public function getStatusName(): string
    {
        return 'Nepřiřazená';
    }
}