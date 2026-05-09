<?php

namespace App\Services;

use App\Domain\Entity\Device\Device;
use App\Domain\Entity\Repair\Repair;
use App\Domain\Entity\Repair\RepairBuilder;
use App\DTO\NewRepairDTO;
use App\Persistence\Repository\CustomerRepository;
use App\Persistence\Repository\DeviceRepository;
use App\Persistence\Repository\EmployeeRepository;
use App\Persistence\Repository\PricingRepository;
use App\Persistence\Repository\RepairRepository;
use Exception;

/**
 * Hlavní služba pro správu oprav (Fasáda).
 * Orchetruje procesy vytváření, přiřazování a dokončování oprav prostřednictvím doménových entit a příslušných repozitářů.
 */
class RepairService
{
    public function __construct(
        private RepairRepository $repairRepository,
        private CustomerRepository $customerRepository,
        private DeviceRepository $deviceRepository,
        private EmployeeRepository $employeeRepository,
        private PricingRepository $pricingRepository
    ) {}

    public function getAllRepairs(): array
    {
        return $this->repairRepository->getAllRepairs();
    }

    public function getRepairById(int $id): ?Repair
    {
        return $this->repairRepository->findById($id);
    }

    public function createNewRepair(NewRepairDTO $dto): void
    {
        // Získání existujícího zákazníka podle telefonu
        $customer = $this->customerRepository->findByPhone($dto->customerPhone);
        if (!$customer) {
            throw new Exception("Zákazník s telefonním číslem {$dto->customerPhone} nebyl nalezen.");
        }

        // Získání existujícího zařízení podle sériového čísla
        $device = $this->deviceRepository->findBySerial($dto->serial);
        if (!$device) {
            // Zařízení neexistuje -> vytvoříme ho
            $device = new Device($dto->brand, $dto->model, $dto->serial, $customer);
            // Uložení do DB (tím se vygeneruje a do objektu zapíše ID)
            $this->deviceRepository->save($device);
        } else {
            // Zařízení existuje -> zkontrolujeme, zda patří tomuto zákazníkovi
            if ($device->getCustomer()->getId() !== $customer->getId()) {
                throw new Exception("Zařízení se {$dto->serial} je již evidováno u jiného zákazníka.");
            }
        }

        //Sestavení opravy
        $builder = new RepairBuilder();
        $repair = $builder
            ->setDevice($device)
            ->setDates($dto->startDate, $dto->expectedEndDate)
            ->setDescription($dto->description)
            ->build();

        // Uložení opravy
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

    public function getAllTechnicians(): array
    {
        return $this->employeeRepository->getAllTechnicians();
    }

    public function getUnassignedRepairs(): array
    {
        return $this->repairRepository->getUnassignedRepairs();
    }

    public function getRepairsForTechnician(int $technicianId): array
    {
        return $this->repairRepository->findByTechnicianAndStatus($technicianId, 'Přiřazená');
    }

    public function submitServiceAction(int $repairId, string $notes, int $pricingId): void
    {
        $repair = $this->repairRepository->findById($repairId);
        $pricing = $this->pricingRepository->findById($pricingId);

        if (!$repair || !$pricing) {
            throw new \Exception("Oprava nebo položka ceníku nenalezena.");
        }

        // Provedení business logiky (změna stavu na 'Opravena' přes State Pattern)
        $repair->finishWork($notes, $pricing);

        // Uložení (včetně notes a price_id do DB)
        $this->repairRepository->save($repair);
    }

    public function getAllPricingItems(): array
    {
        return $this->pricingRepository->getAll();
    }

    public function getRepairsCountSince(string $date): int {
        return $this->repairRepository->getCountSince($date);
    }
}