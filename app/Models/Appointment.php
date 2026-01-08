<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class Appointment extends BaseModel {
    private $appointment_date;
    private $appointment_time;
    private $doctor_id;
    private $patient_id;
    private $reason;
    private $status;

    public function __construct($db) {
        parent::__construct($db); 
        $this->status = 'scheduled'; 
    }

    public function setAppointmentDate($date) {
        $this->appointment_date = $date;
    }

    public function setAppointmentTime($time) {
        $this->appointment_time = $time;
    }

    public function setDoctorId($id) {
        $this->doctor_id = $id;
    }

    public function setPatientId($id) {
        $this->patient_id = $id;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO appointments (appointment_date, appointment_time, doctor_id, patient_id, reason, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssiiss",
            $this->appointment_date,
            $this->appointment_time,
            $this->doctor_id,
            $this->patient_id,
            $this->reason,
            $this->status
        );
        return $stmt->execute();
    }

    
    public function getAll() {
        $result = $this->db->query("SELECT * FROM appointments");
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }
}
