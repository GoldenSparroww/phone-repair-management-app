<?php

namespace App\Persistence\DAO;

use App\Core\AbstractDAO;

class RepairDAO extends AbstractDAO
{
    public function getAllRepairs(): array
    {
        $sql = "SELECT * FROM repairs ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM repairs WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        }
        return $result;
    }

    public function insert(array $data): int
    {
        $sql = "INSERT INTO repairs (started, expected_end, description, device_id, status, employee_id) 
                VALUES (:started, :expected_end, :description, :device_id, :status, :employee_id)";

        $this->db->prepare($sql)->execute([
            'started' => $data['started'],
            'expected_end' => $data['expected_end'],
            'description' => $data['description'],
            'device_id' => $data['device_id'],
            'status' => $data['status'],
            'employee_id' => $data['employee_id']
        ]);

        return (int)$this->db->lastInsertId();
    }

    // src/Persistence/DAO/RepairDAO.php

    public function update(int $id, array $data): void
    {
        $sql = "UPDATE repairs 
                SET started = :started,
                    expected_end = :expected_end,
                    description = :description,
                    device_id = :device_id,
                    status = :status, 
                    employee_id = :employee_id, 
                    notes = :notes,
                    price_id = :price_id
                WHERE id = :id";

        $this->db->prepare($sql)->execute([
            'id' => $id,
            'started' => $data['started'],
            'expected_end' => $data['expected_end'],
            'description' => $data['description'],
            'device_id' => $data['device_id'],
            'status' => $data['status'],
            'employee_id' => $data['employee_id'],
            'notes' => $data['notes'] ?? null,
            'price_id' => $data['price_id'] ?? null
        ]);
    }

    public function getUnassignedRepairs(): array
    {
        $sql = "SELECT * FROM repairs WHERE status = 'Nepřiřazená' ORDER BY started ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function findByTechnicianAndStatus(int $technicianId, string $status): array
    {
        $sql = "SELECT * FROM repairs 
                WHERE employee_id = :employee_id 
                AND status = :status 
                ORDER BY started ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'employee_id' => $technicianId,
            'status'      => $status
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function linkInvoice(int $repairId, int $invoiceId): void
    {
        $sql = "UPDATE repairs SET invoice_id = :invoice_id WHERE id = :id";

        $this->db->prepare($sql)->execute([
            'invoice_id' => $invoiceId,
            'id'         => $repairId
        ]);
    }

    public function findByStatus(string $status): array
    {
        $sql = "SELECT * FROM repairs WHERE status = :status ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['status' => $status]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getCountSince(string $date): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM repairs WHERE started >= :date");
        $stmt->execute(['date' => $date]);
        return (int)$stmt->fetchColumn();
    }
}