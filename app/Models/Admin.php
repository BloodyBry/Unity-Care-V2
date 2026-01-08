<?php
require_once 'User.php';

class Admin extends User {
    public function login($db, $email, $password) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res && password_verify($password, $res['password'])) {
            $this->id = $res['id'];
            $this->email = $res['email'];
            $this->username = $res['username'];
            $this->role = $res['role'];
            return true;
        }
        return false;
    }
}
