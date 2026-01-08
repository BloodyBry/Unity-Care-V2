<?php
require_once __DIR__ . '/../config/database.php';          
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth = new AuthController($conn);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = $auth->login($email, $password); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Care Cliniv</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
    <h2>Login</h2>

    <?php if(!empty($error)) : ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
