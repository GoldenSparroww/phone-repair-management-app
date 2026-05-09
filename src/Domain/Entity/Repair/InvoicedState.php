<?php

namespace App\Domain\Entity\Repair;

use Exception;
use App\Domain\Entity\Employee\Employee;

/**
 * Konkrétní implementace návrhového vzoru State.
 * Reprezentuje finální stav opravy. Zabraňuje jakékoliv další modifikaci zakázky po vystavení faktury.
 */
class InvoicedState implements RepairStateInterface
{
    public function assignTechnician(Repair $repair, Employee $technician): void
    {
        throw new Exception("Nelze modifikovat vyfakturovanou zakázku.");
    }

    public function markAsRepaired(Repair $repair): void
    {
        throw new Exception("Nelze modifikovat vyfakturovanou zakázku.");
    }

    public function createInvoice(Repair $repair): void
    {
        throw new Exception("Tato oprava již byla vyfakturována.");
    }

    public function getStatusName(): string
    {
        return 'Vyfakturována';
    }
}