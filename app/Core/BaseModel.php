<?php

require_once __DIR__ . '/Database.php';

class BaseModel {
    protected $db;       
    protected $table;    

    public function __construct($table) {
        $database = new Database();    
        $this->db = $database->getConnection(); 
        $this->table = $table;        
    }

    
    public function all() {
        $result = $this->db->query("SELECT * FROM {$this->table}");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
