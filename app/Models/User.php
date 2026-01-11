<?php
abstract class User {
    public $id;
    public $email;
    public $username;
    public $password;
    public $role;

    public function __construct($id, $email, $username, $password, $role) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }
}
