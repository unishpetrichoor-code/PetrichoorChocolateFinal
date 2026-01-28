<?php
include '../includes/db_connect.php';

// Handle form submission (Add Product)
if(isset($_POST['add_product'])){
    $title = $_POST['title'];
    $title_ar = $_POST['title_ar'];

    $imageName = $_FILES['image']['name'];
    $targetDir = "../assets/images/";
    $targetFile = $targetDir . basename($imageName);

    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        $sql = "INSERT INTO dashboard_product (title, title_ar, image) VALUES ('$title', '$title_ar', '$imageName')";
        if($mysqli->query($sql)){
            // Redirect to prevent duplicate insert on refresh
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
        } else {
            $msg = "Error: " . $mysqli->error;
        }
    } else {
        $msg = "Image upload failed!";
    }
}

// Handle Delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']); // sanitize input
    $sql = "DELETE FROM dashboard_product WHERE id = $id";
    if($mysqli->query($sql)){
        // Redirect to prevent deletion on refresh
        header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
        exit();
    } else {
        $msg = "Error deleting product: " . $mysqli->error;
    }
}

// Show messages
if(isset($_GET['success'])){
    $msg = "Product added successfully!";
}
if(isset($_GET['deleted'])){
    $msg = "Product deleted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard Products | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">

  <!-- Add Product Form -->
  <div class="card p-4 mb-5">
    <h4>Add New Product</h4>
    <?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-4">
          <input type="text" name="title" class="form-control" placeholder="Title (EN)" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="title_ar" class="form-control" placeholder="Title (AR)" required>
        </div>
        <div class="col-md-4">
          <input type="file" name="image" class="form-control" required>
        </div>
      </div>
      <div class="mt-3 text-end">
        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
      </div>
    </form>
  </div>

  <!-- Existing Products Table -->
  <div class="card p-4">
    <h4>Existing Products</h4>
    <table class="table table-bordered table-striped mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Title</th>
          <th>Title-ar</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM dashboard_product ORDER BY id DESC";
        $result = $mysqli->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><img src="../assets/images/<?= $row['image'] ?>" width="80" alt="<?= $row['title'] ?>"></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['title_ar'] ?></td>
                <td>
                  <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
        <?php }
        } else { ?>
          <tr><td colspan="5" class="text-center">No products found.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</div>

<a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
