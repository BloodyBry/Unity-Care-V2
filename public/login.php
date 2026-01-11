<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Core/Session.php";
require_once __DIR__ . "/../app/repositories/UserRepository.php";

Session::start();

if (Session::isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = (new Database())->getConnection();
    $userRepo = new UserRepository($db);
    $user = $userRepo->findByEmail($email);

    if ($user && password_verify($password, $user->password)) {
        Session::set('user_id', $user->id);
        Session::set('role', $user->role);
        header("Location: index.php");
        exit;
    } else {
        $error = "Email or password incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Unity Care Clinic</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<div class="login-page">

    <div class="login-card">
        <div class="login-header">
            <h1>Unity Care Clinic</h1>
            <p>Admin & Staff Login</p>
        </div>

        <?php if ($error): ?>
            <div class="error-box">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Your email here" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

        <div class="login-footer">
            <span>© <?= date("Y") ?> Unity Care Clinic</span>
        </div>
    </div>

</div>

</body>
</html>
