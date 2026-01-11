<?php
require_once __DIR__ . "/../app/Core/Session.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/repositories/PrescriptionRepository.php";
require_once __DIR__ . "/../app/repositories/MedicationRepository.php";

Session::start();

if (!Session::isLoggedIn() || Session::get('role') !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = Database::getConnection();
$repo = new PrescriptionRepository($db);
$medRepo = new MedicationRepository($db);

/* UPDATE */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $repo->update(
        $_POST['id'],
        $_POST['medication_id'],
        $_POST['dosage']
    );
    header("Location: prescriptions.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $repo->delete($_POST['id']);
    header("Location: prescriptions.php");
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = $repo->find($_GET['edit']);
}

$prescriptions = $repo->getAllForAdmin();
$medications = $medRepo->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescriptions | Admin</title>
    <link rel="stylesheet" href="assets/css/appointments.css">
</head>
<body>

<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a>Unity Care Clinic - Prescriptions</a>
        </div>
        <div class="user-section">
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>

<div class="container">

    <div class="top-bar">
        <h1>Prescriptions</h1>
        <!-- <a href="index.php" class="btn secondary">← Dashboard</a> -->
        <a href="index.php" class="back">← Back to dashboard</a>
    </div>


    <?php if ($edit): ?>
        <div class="card">
            <h2>Edit Prescription</h2>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">

                <label>Medication</label>
                <select name="medication_id" required>
                    <?php foreach ($medications as $m): ?>
                        <option value="<?= $m['id'] ?>"
                            <?= $edit['medication_id'] == $m['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Dosage</label>
                <input type="text"
                       name="dosage"
                       value="<?= htmlspecialchars($edit['dosage']) ?>"
                       required>

                <button type="submit" name="update" class="btn">
                    Update Prescription
                </button>

                <a href="prescriptions.php" class="btn secondary">
                    Cancel
                </a>
            </form>
        </div>
    <?php endif; ?>


    <div class="card table-card">
        <h2>All Prescriptions</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Medication</th>
                        <th>Dosage</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($prescriptions)): ?>
                    <tr>
                        <td colspan="7">No prescriptions found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($prescriptions as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['patient_name']) ?></td>
                            <td><?= htmlspecialchars($p['doctor_name']) ?></td>
                            <td><?= htmlspecialchars($p['medication_name']) ?></td>
                            <td><?= htmlspecialchars($p['dosage']) ?></td>
                            <td><?= date('Y-m-d', strtotime($p['created_at'])) ?></td>
                            <td class="actions">
                                <a href="?edit=<?= $p['id'] ?>"
                                   class="btn small edit">
                                   Edit
                                </a>

                                <form method="POST"
                                      onsubmit="return confirm('Delete this prescription?');">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit"
                                            name="delete"
                                            class="btn small danger">
                                        Delete
                                    </button>
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
