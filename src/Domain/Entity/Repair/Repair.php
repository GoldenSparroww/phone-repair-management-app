<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Device\Device;
use App\Domain\Entity\Employee\Employee;

class Repair
{
    private ?int $id = null;
    private RepairStateInterface $state;
    private ?Employee $technician = null;
    private Device $device;
    private string $startDate = '';
    private string $estimatedEndDate = '';
    private string $description = '';

    public function __construct()
    {
        $this->state = new UnassignedState();
    }

    public function setTechnician(Employee $technician): void
    {
        $this->technician = $technician;
    }

    public function getTechnician(): ?Employee
    {
        return $this->technician;
    }

    // Delegace stavových operací na objekt stavu
    public function assignTechnician(Employee $technician): void
    {
        $this->state->assignTechnician($this, $technician);
    }

    public function markAsRepaired(): void
    {
        $this->state->markAsRepaired($this);
    }

    public function createInvoice(): void
    {
        $this->state->createInvoice($this);
    }

    public function setState(RepairStateInterface $state): void { $this->state = $state; }
    public function getState(): RepairStateInterface { return $this->state; }

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): ?int { return $this->id; }

    public function setDevice(Device $device): void { $this->device = $device; }
    public function getDevice(): Device { return $this->device; }

    public function setDates(string $start, string $end): void {
        $this->startDate = $start;
        $this->estimatedEndDate = $end;
    }
    public function getStartDate(): string { return $this->startDate; }
    public function getEstimatedEndDate(): string { return $this->estimatedEndDate; }

    public function setDescription(string $description): void { $this->description = $description; }
    public function getDescription(): string { return $this->description; }
}