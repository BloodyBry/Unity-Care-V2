<?php
class Prescription {
    public $id;
    public $doctor_id;
    public $patient_id;
    public $medication_id;
    public $dosage;

    public function __construct($id, $doctor_id, $patient_id, $medication_id, $dosage){
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->patient_id = $patient_id;
        $this->medication_id = $medication_id;
        $this->dosage = $dosage;
    }
}
