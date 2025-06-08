<?php
require_once __DIR__ . '/../models/Schedule.php';

class ScheduleController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM schedules ORDER BY start_time ASC");
        $schedules = [];
        while ($row = $result->fetch_assoc()) {
            $schedules[] = new Schedule($row['id'], $row['show_name'], $row['start_time']);
        }
        return $schedules;
    }

    public function add($show_name, $start_time) {
        $stmt = $this->db->prepare("INSERT INTO schedules (show_name, start_time) VALUES (?, ?)");
        $stmt->bind_param("ss", $show_name, $start_time);
        $stmt->execute();
    }

    public function update($id, $show_name, $start_time) {
        $stmt = $this->db->prepare("UPDATE schedules SET show_name=?, start_time=? WHERE id=?");
        $stmt->bind_param("ssi", $show_name, $start_time, $id);
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM schedules WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>
