<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Device\Device;
use App\Domain\Entity\Repair\Repair;
use App\Persistence\DAO\DeviceDAO;
use Exception;

class DeviceRepository
{
    public function __construct(
        private DeviceDAO $dao,
        private CustomerRepository $customerRepository,
    ) {}

    public function findBySerial(string $serial): ?Device
    {
        $row = $this->dao->findBySerial($serial);
        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    public function findById(int $id): ?Device
    {
        $row = $this->dao->findById($id);
        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    private function mapRowToEntity(array $row): Device
    {
        $customer = $this->customerRepository->findById((int)$row['customer_id']);

        if (!$customer) {
            throw new Exception("Integrita databáze narušena: Zákazník k zařízení nenalezen.");
        }

        $device = new Device(
            $row['brand'],
            $row['model'],
            $row['serial'],
            $customer
        );

        $device->setId((int)$row['id']);

        return $device;
    }

    public function save(Device $device): void
    {
        if ($device->getId() === null) {
            $id = $this->dao->insert([
                'brand' => $device->getBrand(),
                'model' => $device->getModel(),
                'serial' => $device->getSerial(),
                'customer_id' => $device->getCustomer()->getId()
            ]);

            $device->setId($id);
        }
    }
}