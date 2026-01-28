<?php
include '../includes/db_connect.php';

// Handle Add Product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $image = "";

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/images/";
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $imageName;
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, category, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $category, $image);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_products.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: manage_products.php");
    exit();
}

// Handle Edit
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];

    $image = $_POST['existing_image']; // keep old image if no new one

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/images/";
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $imageName;
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $category, $image, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_products.php");
    exit();
}

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY category, name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center">Manage Products</h2>

  <!-- Add Product Form -->
  <div class="card p-4 mb-5">
    <h4>Add New Product</h4>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-4">
          <input type="text" name="name" class="form-control" placeholder="Product Name" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="category" class="form-control" placeholder="Category" required>
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

  <!-- Product List -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark text-center">
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td class="text-center">
            <?php if ($row['image']): ?>
              <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" alt="" width="60">
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td class="text-center">
            <!-- Edit Button triggers modal -->
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
          </td>
        </tr>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="existing_image" value="<?= htmlspecialchars($row['image']) ?>">
                  <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($row['category']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>
                  <?php if ($row['image']): ?>
                    <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" width="100" class="rounded mt-2">
                  <?php endif; ?>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="update_product" class="btn btn-primary">Update</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
