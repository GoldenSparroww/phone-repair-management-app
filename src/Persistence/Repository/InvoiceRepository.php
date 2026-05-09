<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Invoice\Invoice;
use App\Persistence\DAO\InvoiceDAO;

class InvoiceRepository
{
    public function __construct(
        private InvoiceDAO $dao
    )
    {
    }

    /**
     * Uloží entitu Invoice do databáze a vrátí vygenerované ID.
     */
    public function save(Invoice $invoice): int
    {
        // Příprava dat pro DAO na základě vlastností entity
        $data = [
            'issued' => $invoice->getIssued(),
            'due' => $invoice->getDue(),
            'method' => $invoice->getMethod(),
            'customer_id' => $invoice->getCustomerId()
        ];

        // Pokud faktura nemá ID, jde o nový záznam
        if ($invoice->getId() === null) {
            $id = $this->dao->insert($data);
            $invoice->setId($id);
            return $id;
        }

        // Zde by případně následoval update, pokud by to bylo vyžadováno
        return $invoice->getId();
    }
}