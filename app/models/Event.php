<?php
namespace App\Models;

use App\Config\Database;
use mysqli;

class Event {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll(string $sort = 'event_date'): array {
        $allowedSorts = ['event_date', 'title', 'price'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'event_date';
        }

        $result = $this->db->query("SELECT * FROM events ORDER BY $sort ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ? $row : null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO events (title, description, event_date, event_type, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssd", $data['title'], $data['description'], $data['event_date'], $data['event_type'], $data['price']);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE events SET title = ?, description = ?, event_date = ?, event_type = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssssdi", $data['title'], $data['description'], $data['event_date'], $data['event_type'], $data['price'], $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}