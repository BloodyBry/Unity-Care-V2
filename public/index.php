<?php
require_once __DIR__ . "/../app/Core/Session.php";

Session::start();

if (!Session::isLoggedIn() || Session::get('role') !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a>Unity Care Clinic - Dashboard</a>
        </div>

        <!-- <ul class="top-links">
            <li><a>Departments</a></li>
            <li><a>Doctors</a></li>
            <li><a>Patients</a></li>
            <li><a>Appointments</a></li>
        </ul> -->

        <div class="user-section">
            <span class="username">Admin</span>
        </div>
    </nav>
</header>

<div class="container">
    <h1>Admin Dashboard</h1>
    <p class="subtitle">Unity Care Clinic – Administration Panel</p>

    <div class="cards">
        <a href="appointments.php" class="card">
            <h3>Appointments</h3>
            <p>View & manage all appointments</p>
        </a>

        <a href="prescriptions.php" class="card">
            <h3>Prescriptions</h3>
            <p>View all prescriptions</p>
        </a>

        <a href="medications.php" class="card">
            <h3>Medications</h3>
            <p>Manage medication catalog</p>
        </a>

        <a href="logout.php" class="card logout">
            <h3>Logout</h3>
            <p>End session</p>
        </a>
    </div>
</div>

<footer class="dashboard-footer">
    <div class="container">
        &copy; <?= date("Y") ?> Unity Care Clinic. All rights reserved.
    </div>
</footer>

</body>


</html>
