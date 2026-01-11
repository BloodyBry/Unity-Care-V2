<?php
require_once __DIR__ . '/../../config/database.php';

class AppointmentRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM appointments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($patient_id, $doctor_id, $date, $time, $reason)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason, status)
            VALUES (:patient_id, :doctor_id, :date, :time, :reason, 'scheduled')
        ");
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':reason', $reason);
        $stmt->execute();
    }

    public function update($id, $patient_id, $doctor_id, $date, $time, $reason, $status)
    {
        $stmt = $this->conn->prepare("
            UPDATE appointments
            SET patient_id = :patient_id,
                doctor_id = :doctor_id,
                appointment_date = :date,
                appointment_time = :time,
                reason = :reason,
                status = :status
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM appointments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
