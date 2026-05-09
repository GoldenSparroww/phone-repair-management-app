<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Repair\Repair;
use App\Domain\Entity\Repair\AssignedState;
use App\Domain\Entity\Repair\InvoicedState;
use App\Domain\Entity\Repair\RepairBuilder;
use App\Domain\Entity\Repair\RepairedState;
use App\Domain\Entity\Repair\RepairStateInterface;
use App\Domain\Entity\Repair\UnassignedState;
use App\Persistence\DAO\RepairDAO;

/**
 * Repozitář pro entitu Repair.
 * Komplexně sestavuje doménové objekty oprav z databáze a ukládá je. Využívá RepairBuilder a začleňuje související entity.
 */
class RepairRepository
{
    public function __construct(
        private RepairDAO $dao,
        private RepairBuilder $builder,
        private DeviceRepository $deviceRepository,
        private EmployeeRepository $employeeRepository,
        private PricingRepository $pricingRepository
    ) {}

    public function getAllRepairs(): array
    {
        $rows = $this->dao->getAllRepairs();
        $repairs = [];

        foreach ($rows as $row) {
            $repairs[] = $this->mapRowToEntity($row);
        }

        return $repairs;
    }

    public function findById(int $id): ?Repair
    {
        $row = $this->dao->findById($id);
        if (!$row) return null;

        return $this->mapRowToEntity($row);
    }

    public function save(Repair $repair): void
    {
        $technician = $repair->getTechnician();
        $pricing = $repair->getPricing();

        $data = [
            'started'      => $repair->getStartDate(),
            'expected_end' => $repair->getEstimatedEndDate(),
            'description'  => $repair->getDescription(),
            'device_id'    => $repair->getDevice()->getId(),
            'status'       => $repair->getState()->getStatusName(),
            'employee_id'  => $technician !== null ? $technician->getId() : null,
            'notes'        => $repair->getNotes(),
            'price_id'     => $pricing !== null ? $pricing->getId() : null
        ];

        if ($repair->getId() === null) {
            $id = $this->dao->insert($data);
            $repair->setId($id);
        } else {
            $this->dao->update($repair->getId(), $data);
        }
    }

    private function mapRowToEntity(array $row): Repair
    {
        // Získání zařízení
        $device = $this->deviceRepository->findById((int)$row['device_id']);

        // Sestavení opravy
        $repair = $this->builder
            ->setDevice($device)
            ->setDates($row['started'], $row['expected_end'])
            ->setDescription($row['description'])
            ->build();

        // Nastavení ID a stavu
        $repair->setId((int)$row['id']);
        $repair->setState($this->mapStatusToState($row['status']));

        // Nastavení poznámek technika, pokud existují
        if (isset($row['notes'])) {
            $repair->setNotes($row['notes']);
        }

        // přiřazení technika
        if (!empty($row['employee_id'])) {
            $technician = $this->employeeRepository->findById((int)$row['employee_id']);
            if ($technician) {
                $repair->setTechnician($technician);
            }
        }

        // Načtení a přiřazení úkonu z ceníku
        if (!empty($row['price_id'])) {
            $pricing = $this->pricingRepository->findById((int)$row['price_id']);
            if ($pricing) {
                $repair->setPricing($pricing);
            }
        }

        return $repair;
    }

    private function mapStatusToState(string $statusName): RepairStateInterface
    {
        return match($statusName) {
            'Nepřiřazená' => new UnassignedState(),
            'Přiřazená' => new AssignedState(),
            'Opravena' => new RepairedState(),
            'Vyfakturována' => new InvoicedState(),
        };
    }

    public function getUnassignedRepairs(): array
    {
        $rows = $this->dao->getUnassignedRepairs();
        $repairs = [];

        foreach ($rows as $row) {
            $repairs[] = $this->mapRowToEntity($row);
        }

        return $repairs;
    }

    public function findByTechnicianAndStatus(int $technicianId, string $status): array
    {
        $rows = $this->dao->findByTechnicianAndStatus($technicianId, $status);
        $repairs = [];

        foreach ($rows as $row) {
            $repairs[] = $this->mapRowToEntity($row);
        }

        return $repairs;
    }

    public function linkInvoice(int $repairId, int $invoiceId): void
    {
        $this->dao->linkInvoice($repairId, $invoiceId);
    }

    public function findByStatus(string $status): array
    {
        $rows = $this->dao->findByStatus($status);
        $repairs = [];

        foreach ($rows as $row) {
            $repairs[] = $this->mapRowToEntity($row);
        }

        return $repairs;
    }

    public function getCountSince(string $date): int {
        return $this->dao->getCountSince($date);
    }
}