<?php

namespace App\Domain\Entity\Repair;

use App\Domain\Entity\Device\Device;

/**
 * Třída implementující návrhový vzor Builder.
 * Slouží ke krokovému a bezpečnému sestavení komplexního objektu Repair včetně jeho závislostí.
 */
class RepairBuilder
{
    private Repair $repair;

    public function __construct()
    {
        $this->repair = new Repair();
    }

    public function setDevice(Device $device): self
    {
        $this->repair->setDevice($device);
        return $this;
    }

    public function setDates(string $startDate, string $estimatedEndDate): self
    {
        $this->repair->setDates($startDate, $estimatedEndDate);
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->repair->setDescription($description);
        return $this;
    }

    public function build(): Repair
    {
        $result = $this->repair;
        $this->repair = new Repair();
        return $result;
    }
}