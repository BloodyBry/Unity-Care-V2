<?php

require_once 'User.php';

class Doctor extends User {
    public function __construct() {
        parent::__construct('users');
    }

    public function getRole() {
        return 'doctor';
    }
}
