<?php

require_once __DIR__ . '/../Core/BaseModel.php';

abstract class User extends BaseModel {
    protected $id;
    protected $username;
    protected $email;
    protected $password; 

    public function __construct($table) {
        parent::__construct($table);
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    abstract public function getRole();
}
