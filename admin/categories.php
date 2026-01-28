<?php
include '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h2>Manage Categories</h2>
<form method="post" class="my-3">
  <div class="row g-2" style="max-width:600px;">
    <div class="col">
      <input type="text" name="name" class="form-control" placeholder="Category Name (English)" required>
    </div>
    <div class="col">
      <input type="text" name="name_ar" class="form-control" placeholder="Category Name (Arabic)" required>
    </div>
    <div class="col-auto">
      <button type="submit" name="add" class="btn btn-primary">Add</button>
    </div>
  </div>
</form>

<?php
// Add Category
if(isset($_POST['add'])) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $name_ar = $mysqli->real_escape_string($_POST['name_ar']);
    $mysqli->query("INSERT INTO categories (name, name_ar) VALUES ('$name', '$name_ar')");
    header("Location: categories.php");
}

// Delete Category
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $mysqli->query("DELETE FROM categories WHERE id = $id");
    header("Location: categories.php");
}

$result = $mysqli->query("SELECT * FROM categories ORDER BY id DESC");
?>

<table class="table table-bordered" style="max-width:600px;">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name (English)</th>
      <th>Name (Arabic)</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['name_ar']) ?></td>
      <td>
        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

</body>
</html>
