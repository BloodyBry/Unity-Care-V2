<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class Medication extends BaseModel {
    private $name;
    private $description;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO medications (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->name, $this->description);
        return $stmt->execute();
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM medications");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM medications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }
}
