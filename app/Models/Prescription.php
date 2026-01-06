<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class Prescription extends BaseModel {

    private $doctor_id;
    private $patient_id;
    private $medication_id;
    private $dosage;

    public function __construct($db) {
        parent::__construct($db);
    }


    public function setDoctorId($doctor_id) {
        $this->doctor_id = $doctor_id;
    }

    public function setPatientId($patient_id) {
        $this->patient_id = $patient_id;
    }

    public function setMedicationId($medication_id) {
        $this->medication_id = $medication_id;
    }

    public function setDosage($dosage) {
        $this->dosage = $dosage;
    }


    public function save() {
        $stmt = $this->db->prepare(
            "INSERT INTO prescriptions (doctor_id, patient_id, medication_id, dosage)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiis",
            $this->doctor_id,
            $this->patient_id,
            $this->medication_id,
            $this->dosage
        );

        return $stmt->execute();
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM prescriptions");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
