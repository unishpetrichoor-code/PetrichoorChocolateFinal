<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../includes/db_connect.php'; // adjust path if needed

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Get user from DB
    $stmt = $mysqli->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        $hashed_password = hash('sha256', $password);
        if ($hashed_password === $user['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Petrichoor Chocolate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
<div class="card p-4 shadow" style="width: 350px;">
  <h4 class="text-center mb-4">Admin Login</h4>
  <?php if (!empty($error)) : ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <input type="text" name="username" class="form-control" placeholder="Username" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
  <p class="mt-3 text-center">
    <a href="changepassword.php">Forgot your password?</a>
  </p> 

</form>
</div>
</body>
</html>
