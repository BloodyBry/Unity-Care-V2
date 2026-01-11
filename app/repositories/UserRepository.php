<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../Models/User.php";
require_once __DIR__ . "/../Models/Admin.php";
require_once __DIR__ . "/../Models/Doctor.php";
require_once __DIR__ . "/../Models/Patient.php";

class UserRepository extends BaseRepository {
    public function findByEmail($email){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;
        switch($row['role']){
            case 'admin': return new Admin($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
            case 'doctor': return new Doctor($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
            case 'patient': return new Patient($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
        }
    }

    public function findById($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;
        switch($row['role']){
            case 'admin': return new Admin($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
            case 'doctor': return new Doctor($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
            case 'patient': return new Patient($row['id'],$row['email'],$row['username'],$row['password'],$row['role']);
        }
    }
}
