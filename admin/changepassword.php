<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../includes/db_connect.php'; // adjust path if needed

// Handle forgot password form submission
if (isset($_POST['reset_password'])) {
    $username = trim($_POST['username']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    // Check if username exists
    $stmt = $mysqli->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $error = "Username not found.";
    } elseif ($new !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Update password
        $new_hash = hash('sha256', $new);
        $update = $mysqli->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
        $update->bind_param("ss", $new_hash, $username);
        $update->execute();
        $success = "Password reset successfully! <a href='login.php'>Login here</a>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password | Petrichoor Chocolate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">

<div class="container" style="max-width: 400px;">
  <h4 class="mb-4 text-center">Forgot Password</h4>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php elseif (!empty($success)): ?>
    <div class="alert alert-success text-center"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
    </div>
    <div class="mb-3">
      <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
    </div>
    <div class="mb-3">
      <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
    </div>
    <button type="submit" name="reset_password" class="btn btn-primary w-100">Reset Password</button>
  </form>

  <p class="mt-3 text-center">
    <a href="login.php">Back to Login</a>
  </p>
</div>

</body>
</html>
