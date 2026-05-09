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

    public function save(Invoice $invoice): int
    {
        $data = [
            'issued' => $invoice->getIssued(),
            'due' => $invoice->getDue(),
            'method' => $invoice->getMethod(),
            'customer_id' => $invoice->getCustomerId()
        ];

        if ($invoice->getId() === null) {
            $id = $this->dao->insert($data);
            $invoice->setId($id);
            return $id;
        }

        return $invoice->getId();
    }
}