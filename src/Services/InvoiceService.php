<?php

namespace App\Services;

use App\Domain\Entity\Invoice\Invoice;
use App\Domain\Entity\Repair\InvoicedState;
use App\Persistence\Repository\InvoiceRepository;
use App\Persistence\Repository\RepairRepository;
use Exception;

class InvoiceService
{
    public function __construct(
        private RepairRepository $repairRepository,
        private InvoiceRepository $invoiceRepository
    ) {}

    public function getRepairedRepairs(): array
    {
        return $this->repairRepository->findByStatus('Opravena');
    }

    public function createInvoiceForRepair(int $repairId, string $method): int
    {
        $repair = $this->repairRepository->findById($repairId);
        if (!$repair) throw new Exception("Oprava nenalezena.");

        // 1. Vytvoření záznamu faktury
        $issued = date('Y-m-d');
        $due = date('Y-m-d', strtotime('+14 days'));
        $invoice = new Invoice($issued, $due, $method, $repair->getDevice()->getCustomer()->getId());

        $invoiceId = $this->invoiceRepository->save($invoice);

        // Aktualizace opravy (Propojení a změna stavu)
        $repair->setState(new InvoicedState());
        // Do RepairRepository/DAO musíme přidat možnost uložit invoice_id
        $this->repairRepository->linkInvoice($repairId, $invoiceId);
        $this->repairRepository->save($repair);

        return $invoiceId;
    }

    public function getRepairById(int $id)
    {
        return $this->repairRepository->findById($id);
    }
}