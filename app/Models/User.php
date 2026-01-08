<?php
abstract class User {
    protected $id;
    protected $email;
    protected $username;
    protected $password;
    protected $role;

    public function __construct($id = null, $email = null, $username = null, $password = null, $role = null) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRole() {
        return $this->role;
    }

    abstract public function login($db, $email, $password);
}
