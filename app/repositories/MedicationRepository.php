<?php
require_once __DIR__ . "/BaseRepository.php";

class MedicationRepository extends BaseRepository {

    public function all() {
        $stmt = $this->conn->query("SELECT * FROM medications ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM medications WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description) {
        $stmt = $this->conn->prepare(
            "INSERT INTO medications (name, description) VALUES (?, ?)"
        );
        return $stmt->execute([$name, $description]);
    }

    public function update($id, $name, $description) {
        $stmt = $this->conn->prepare(
            "UPDATE medications SET name = ?, description = ? WHERE id = ?"
        );
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM medications WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
