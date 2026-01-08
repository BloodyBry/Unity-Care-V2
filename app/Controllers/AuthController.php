<?php
require_once __DIR__ . '/../Models/Admin.php';
require_once __DIR__ . '/../Models/Doctor.php';
require_once __DIR__ . '/../Models/Patient.php';
require_once __DIR__ . '/../Core/Session.php';

class AuthController {

    private $db;

    public function __construct($db) {
        $this->db = $db; 
        Session::start();
    }

    
    public function login($email, $password) {
        $admin = new Admin();
        if ($admin->login($this->db, $email, $password)) {
            $_SESSION['user_id'] = $admin->getId();
            $_SESSION['role'] = $admin->getRole();
            $_SESSION['username'] = $admin->getUsername();
            header("Location: index.php");
            exit;
        }

        $doctor = new Doctor();
        if ($doctor->login($this->db, $email, $password)) {
            $_SESSION['user_id'] = $doctor->getId();
            $_SESSION['role'] = $doctor->getRole();
            $_SESSION['username'] = $doctor->getUsername();
            header("Location: index.php");
            exit;
        }

        
        $patient = new Patient();
        if ($patient->login($this->db, $email, $password)) {
            $_SESSION['user_id'] = $patient->getId();
            $_SESSION['role'] = $patient->getRole();
            $_SESSION['username'] = $patient->getUsername();
            header("Location: index.php");
            exit;
        }


        return "Email or password is incorrect!";
    }

    public function logout() {
        Session::destroy();
        header("Location: login.php");
        exit;
    }

    public static function check() {
        Session::start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }
    }

    public static function checkRole($role) {
        Session::start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            header("Location: index.php");
            exit;
        }
    }
}
