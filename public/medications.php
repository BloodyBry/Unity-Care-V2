<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Core/Session.php";
require_once __DIR__ . "/../app/repositories/MedicationRepository.php";

Session::start();

if (!Session::isLoggedIn() || Session::get('role') !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = (new Database())->getConnection();
$repo = new MedicationRepository($db);

if (isset($_POST['add'])) {
    $repo->create($_POST['name'], $_POST['description']);
    header("Location: medications.php");
    exit;
}

if (isset($_POST['update'])) {
    $repo->update($_POST['id'], $_POST['name'], $_POST['description']);
    header("Location: medications.php");
    exit;
}

if (isset($_GET['delete'])) {
    $repo->delete($_GET['delete']);
    header("Location: medications.php");
    exit;
}

$editMedication = null;
if (isset($_GET['edit'])) {
    $editMedication = $repo->find($_GET['edit']);
}

$medications = $repo->all();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Medications</title>
    <link rel="stylesheet" href="assets/css/medications.css">
</head>
<body>

<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a>Unity Care Clinic - Medications</a>
        </div>
        <div class="user-section">
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>

<div class="container">

    <div class="top-bar">
        <h1>Medications</h1>
        <!-- <a href="index.php" class="btn secondary">← Back</a> -->
        <a href="index.php" class="back">← Back to dashboard</a>
    </div>

    <div class="card">
        <h2><?= $editMedication ? "Edit Medication" : "Add Medication" ?></h2>

        <form method="post">
            <?php if ($editMedication): ?>
                <input type="hidden" name="id" value="<?= $editMedication['id'] ?>">
            <?php endif; ?>

            <input type="text" name="name" placeholder="Medication name"
                   value="<?= $editMedication['name'] ?? '' ?>" required>

            <input type="text" name="description" placeholder="Description"
                   value="<?= $editMedication['description'] ?? '' ?>">

            <button type="submit" class="btn"
                name="<?= $editMedication ? 'update' : 'add' ?>">
                <?= $editMedication ? 'Update Medication' : 'Add Medication' ?>
            </button>

            <?php if ($editMedication): ?>
                <a href="medications.php" class="btn secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card table-card">
        <h2>Medication List</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($medications as $m): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['description']) ?></td>
                        <td class="actions">
                            <a href="medications.php?edit=<?= $m['id'] ?>" class="btn small edit">Edit</a>
                            <a href="medications.php?delete=<?= $m['id'] ?>"
                               class="btn small danger"
                               onclick="return confirm('Delete this medication?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
