<?php
require_once __DIR__ . "/BaseRepository.php";

class PrescriptionRepository extends BaseRepository
{
    public function getAllForAdmin()
    {
        $sql = "
            SELECT 
                p.id,
                p.dosage,
                p.created_at,
                p.doctor_id,
                p.patient_id,
                p.medication_id,
                d.username AS doctor_name,
                pa.username AS patient_name,
                m.name AS medication_name
            FROM prescriptions p
            JOIN users d ON p.doctor_id = d.id
            JOIN users pa ON p.patient_id = pa.id
            JOIN medications m ON p.medication_id = m.id
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM prescriptions WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $medication_id, $dosage)
    {
        $stmt = $this->conn->prepare(
            "UPDATE prescriptions SET medication_id = ?, dosage = ? WHERE id = ?"
        );
        return $stmt->execute([$medication_id, $dosage, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM prescriptions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
