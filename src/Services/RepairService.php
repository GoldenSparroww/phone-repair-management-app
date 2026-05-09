<?php

namespace App\Services;

use App\Domain\Entity\Repair\RepairBuilder;
use App\DTO\NewRepairDTO;
use App\Persistence\Repository\CustomerRepository;
use App\Persistence\Repository\DeviceRepository;
use App\Persistence\Repository\EmployeeRepository;
use App\Persistence\Repository\RepairRepository;
use Exception;

class RepairService
{
    public function __construct(
        private RepairRepository $repairRepository,
        private CustomerRepository $customerRepository,
        private DeviceRepository $deviceRepository,
        private EmployeeRepository $employeeRepository
    ) {}

    public function getAllRepairs(): array
    {
        return $this->repairRepository->getAllRepairs();
    }

    public function createNewRepair(NewRepairDTO $dto): void
    {
        // 1. Získání existujícího zákazníka podle telefonu
        $customer = $this->customerRepository->findByPhone($dto->customerPhone);
        if (!$customer) {
            throw new Exception("Zákazník s telefonním číslem {$dto->customerPhone} nebyl nalezen.");
        }

        // 2. Získání existujícího zařízení podle sériového čísla
        $device = $this->deviceRepository->findBySerial($dto->serial);
        if (!$device) {
            throw new Exception("Zařízení se sériovým číslem {$dto->serial} nebylo nalezeno.");
        }

        // Kontrola, zda nalezené zařízení opravdu patří nalezenému zákazníkovi
        if ($device->getCustomer()->getId() !== $customer->getId()) {
            throw new Exception("Toto zařízení nepatří zadanému zákazníkovi.");
        }

        // 3. Sestavení opravy
        $builder = new RepairBuilder();
        $repair = $builder
            ->setDevice($device)
            ->setDates($dto->startDate, $dto->expectedEndDate)
            ->setDescription($dto->description)
            ->build();

        // 4. Uložení opravy
        $this->repairRepository->save($repair);
    }

    public function assignTechnicianToRepair(int $repairId, int $employeeId): void
    {
        $repair = $this->repairRepository->findById($repairId);
        if (!$repair) {
            throw new Exception("Oprava nebyla nalezena.");
        }

        $technician = $this->employeeRepository->findById($employeeId);
        if (!$technician) {
            throw new Exception("Technik nebyl nalezen.");
        }

        $repair->assignTechnician($technician);
        $this->repairRepository->save($repair);
    }
}