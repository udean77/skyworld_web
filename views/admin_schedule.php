<?php
// ...existing code for authentication, etc...
require_once __DIR__ . '/../controllers/ScheduleController.php';
$scheduleController = new ScheduleController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $scheduleController->add($_POST['show_name'], $_POST['start_time']);
    } elseif (isset($_POST['edit'])) {
        $scheduleController->update($_POST['id'], $_POST['show_name'], $_POST['start_time']);
    } elseif (isset($_POST['delete'])) {
        $scheduleController->delete($_POST['id']);
    }
}

$schedules = $scheduleController->getAll();
?>
<h2>Jadwal Pertunjukan</h2>
<table border="1">
    <tr>
        <th>Nama Pertunjukan</th>
        <th>Jam Mulai</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($schedules as $schedule): ?>
    <tr>
        <form method="post">
            <td><input type="text" name="show_name" value="<?= htmlspecialchars($schedule->show_name) ?>"></td>
            <td><input type="time" name="start_time" value="<?= htmlspecialchars($schedule->start_time) ?>"></td>
            <td>
                <input type="hidden" name="id" value="<?= $schedule->id ?>">
                <button type="submit" name="edit">Ubah</button>
                <button type="submit" name="delete" onclick="return confirm('Hapus jadwal?')">Hapus</button>
            </td>
        </form>
    </tr>
    <?php endforeach; ?>
    <tr>
        <form method="post">
            <td><input type="text" name="show_name" placeholder="Nama Pertunjukan"></td>
            <td><input type="time" name="start_time"></td>
            <td><button type="submit" name="add">Tambah</button></td>
        </form>
    </tr>
</table>
