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

class RepairRepository
{
    public function __construct(
        private RepairDAO $dao,
        private RepairBuilder $builder,
        private DeviceRepository $deviceRepository,
        private EmployeeRepository $employeeRepository
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

    // src/Persistence/Repository/RepairRepository.php

    public function save(Repair $repair): void
    {
        $technician = $repair->getTechnician();
        // Přidání načtení ceníku
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
        // 1. Získání objektu zařízení (které v sobě již má objekt zákazníka)
        $device = $this->deviceRepository->findById((int)$row['device_id']);

        // 2. Sestavení opravy
        $repair = $this->builder
            ->setDevice($device)
            ->setDates($row['started'], $row['expected_end'])
            ->setDescription($row['description'])
            ->build();

        // 3. Nastavení ID a stavu
        $repair->setId((int)$row['id']);
        $repair->setState($this->mapStatusToState($row['status']));

        // 4. Přiřazení technika, pokud existuje
        if (!empty($row['employee_id'])) {
            $technician = $this->employeeRepository->findById((int)$row['employee_id']);
            if ($technician) {
                $repair->setTechnician($technician);
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

    /**
     * Vrátí pole objektů Repair pro daného technika a stav.
     * @return Repair[]
     */
    public function findByTechnicianAndStatus(int $technicianId, string $status): array
    {
        $rows = $this->dao->findByTechnicianAndStatus($technicianId, $status);
        $repairs = [];

        foreach ($rows as $row) {
            // mapRowToEntity zajistí sestavení objektu včetně Device a Customer
            $repairs[] = $this->mapRowToEntity($row);
        }

        return $repairs;
    }
}