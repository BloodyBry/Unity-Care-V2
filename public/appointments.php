<?php
session_start();

require_once __DIR__ . '/../app/repositories/AppointmentRepository.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$repo = new AppointmentRepository();

$conn = Database::getConnection();
$doctors = $conn->query("SELECT id, username FROM users WHERE role = 'doctor'")->fetchAll(PDO::FETCH_ASSOC);
$patients = $conn->query("SELECT id, username FROM users WHERE role = 'patient'")->fetchAll(PDO::FETCH_ASSOC);

$patientMap = [];
foreach ($patients as $p) {
    $patientMap[$p['id']] = $p['username'];
}

$doctorMap = [];
foreach ($doctors as $d) {
    $doctorMap[$d['id']] = $d['username'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['create'])) {
        $repo->create(
            $_POST['patient_id'],
            $_POST['doctor_id'],
            $_POST['appointment_date'],
            $_POST['appointment_time'],
            $_POST['reason']
        );
        header('Location: appointments.php');
        exit;
    }

    if (isset($_POST['update'])) {
        $repo->update(
            $_POST['id'],
            $_POST['patient_id'],
            $_POST['doctor_id'],
            $_POST['appointment_date'],
            $_POST['appointment_time'],
            $_POST['reason'],
            $_POST['status']
        );
        header('Location: appointments.php');
        exit;
    }

    if (isset($_POST['delete'])) {
        $repo->delete($_POST['id']);
        header('Location: appointments.php');
        exit;
    }
}

$appointments = $repo->getAll();
$edit = null;
if (isset($_GET['edit'])) {
    $edit = $repo->getById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments | Admin</title>
    <link rel="stylesheet" href="assets/css/appointments.css">
</head>
<body>

<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a>Unity Care Clinic - Appointments</a>
        </div>
        <div class="user-section">
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </nav>
</header>

<div class="container">

    <div class="top-bar">
        <h1>Appointments</h1>
        <!-- <a href="index.php" class="btn">← Dashboard</a> -->
        <a href="index.php" class="back">← Back to dashboard</a>
    </div>

    <div class="card form-card">
        <h2><?= $edit ? 'Edit Appointment' : 'Create Appointment' ?></h2>

        <form method="POST">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
            <?php endif; ?>

            <label>Patient:</label>
            <select name="patient_id" required>
                <option value="">-- Select Patient --</option>
                <?php foreach ($patients as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($edit && $edit['patient_id']==$p['id'])?'selected':'' ?>>
                        <?= htmlspecialchars($p['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Doctor:</label>
            <select name="doctor_id" required>
                <option value="">-- Select Doctor --</option>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= $d['id'] ?>" <?= ($edit && $edit['doctor_id']==$d['id'])?'selected':'' ?>>
                        <?= htmlspecialchars($d['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Date:</label>
            <input type="date" name="appointment_date" value="<?= $edit['appointment_date'] ?? '' ?>" required>

            <label>Time:</label>
            <input type="time" name="appointment_time" value="<?= $edit['appointment_time'] ?? '' ?>" required>

            <label>Reason:</label>
            <input type="text" name="reason" placeholder="Reason" value="<?= $edit['reason'] ?? '' ?>">

            <?php if ($edit): ?>
                <label>Status:</label>
                <select name="status" required>
                    <option value="scheduled" <?= $edit['status']==='scheduled'?'selected':'' ?>>Scheduled</option>
                    <option value="done" <?= $edit['status']==='done'?'selected':'' ?>>Done</option>
                    <option value="cancelled" <?= $edit['status']==='cancelled'?'selected':'' ?>>Cancelled</option>
                </select>
            <?php endif; ?>

            <button type="submit" name="<?= $edit ? 'update' : 'create' ?>" class="btn">
                <?= $edit ? 'Update Appointment' : 'Create Appointment' ?>
            </button>

            <?php if ($edit): ?>
                <a href="appointments.php" class="btn secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card table-card">
        <h2>All Appointments</h2>

        <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($appointments)): ?>
                <tr>
                    <td colspan="8">No appointments found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($appointments as $a): ?>
                    <?php
                        $statusClass = match($a['status']) {
                            'scheduled' => 'status-scheduled',
                            'done' => 'status-done',
                            'cancelled' => 'status-cancelled',
                            default => ''
                        };
                    ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td>
                            <?= htmlspecialchars($patientMap[$a['patient_id']] ?? 'Unknown') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($doctorMap[$a['doctor_id']] ?? 'Unknown') ?>
                        </td>
                        <td><?= $a['appointment_date'] ?></td>
                        <td><?= $a['appointment_time'] ?></td>
                        <td><?= htmlspecialchars($a['reason']) ?></td>
                        <td><span class="status-badge <?= $statusClass ?>"><?= $a['status'] ?></span></td>
                        <td class="actions">
                            <a href="?edit=<?= $a['id'] ?>" class="btn small edit">Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete this appointment?');">
                                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                <button type="submit" name="delete" class="btn danger small">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

</div>

<footer class="dashboard-footer">
    <div class="container">
        &copy; <?= date("Y") ?> Unity Care Clinic. All rights reserved.
    </div>
</footer>

</body>
</html>
