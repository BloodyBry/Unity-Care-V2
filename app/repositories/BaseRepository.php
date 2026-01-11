<?php
require_once __DIR__ . "/../Core/BaseModel.php";
abstract class BaseRepository {
    protected $conn;
    public function __construct($db){
        $this->conn = $db;
    }
}
