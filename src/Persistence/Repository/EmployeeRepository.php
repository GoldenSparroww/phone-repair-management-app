<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\Employee\Employee;
use App\Persistence\DAO\EmployeeDAO;

/**
 * Repozitář pro entitu Employee.
 * Převádí relační data z EmployeeDAO na doménové objekty zaměstnanců.
 */
class EmployeeRepository
{
    public function __construct(
        private EmployeeDAO $dao
    ) {}

    public function findById(int $id): ?Employee
    {
        $row = $this->dao->findById($id);
        if (!$row) {
            return null;
        }

        $employee = new Employee(
            $row['first_name'],
            $row['last_name'],
            $row['role']
        );

        $employee->setId((int)$row['id']);

        return $employee;
    }

    public function getAllTechnicians(): array
    {
        $rows = $this->dao->getAllTechnicians();
        $technicians = [];

        foreach ($rows as $row) {
            $employee = new Employee(
                $row['first_name'],
                $row['last_name'],
                $row['role']
            );
            $employee->setId((int)$row['id']);
            $technicians[] = $employee;
        }

        return $technicians;
    }
}