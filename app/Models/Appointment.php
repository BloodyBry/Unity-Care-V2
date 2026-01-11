<?php
class Appointment {
    public $id;
    public $appointment_date;
    public $appointment_time;
    public $reason;
    public $status;
    public $doctor_id;
    public $patient_id;

    public function __construct($id, $date, $time, $reason, $status, $doctor_id, $patient_id){
        $this->id = $id;
        $this->appointment_date = $date;
        $this->appointment_time = $time;
        $this->reason = $reason;
        $this->status = $status;
        $this->doctor_id = $doctor_id;
        $this->patient_id = $patient_id;
    }
}
