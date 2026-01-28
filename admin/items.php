<?php
include __DIR__ . '/../includes/db_connect.php'; // Make sure this path is correct

$uploadDir = __DIR__ . '/../assets/images/uploads/';
$webPath = '/petrichoor/assets/images/uploads/';

// Handle Add Product
if (isset($_POST['add'])) {
    $cat_id = (int)$_POST['category_id'];
    $name = $mysqli->real_escape_string($_POST['name']);
    $name_ar = $mysqli->real_escape_string($_POST['name_ar']);

    if (isset($_FILES['image_files']) && !empty($_FILES['image_files']['name'][0])) {
        $fileCount = count($_FILES['image_files']['name']);
        $uploadedImages = [];

        for ($i = 0; $i < $fileCount; $i++) {
            $tmpName = $_FILES['image_files']['tmp_name'][$i];
            $fileName = basename($_FILES['image_files']['name'][$i]);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedImages[] = $webPath . $fileName;
            }
        }

        if (!empty($uploadedImages)) {
            $mainImage = $uploadedImages[0];
            $mysqli->query("INSERT INTO products (category_id, name, name_ar, image, sort_order) VALUES ($cat_id, '$name', '$name_ar', '$mainImage', 0)");
            $product_id = $mysqli->insert_id;

            foreach ($uploadedImages as $img) {
                $mysqli->query("INSERT INTO product_images (product_id, image_url) VALUES ($product_id, '$img')");
            }

            header("Location: products.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Failed to upload images.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Please select at least one image.</div>';
    }
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $item = $mysqli->query("SELECT image FROM products WHERE id = $id")->fetch_assoc();
    if ($item && file_exists(__DIR__ . '/../' . ltrim($item['image'], '/'))) {
        unlink(__DIR__ . '/../' . ltrim($item['image'], '/'));
    }

    $extraImages = $mysqli->query("SELECT image_url FROM product_images WHERE product_id = $id");
    while ($img = $extraImages->fetch_assoc()) {
        if (file_exists(__DIR__ . '/../' . ltrim($img['image_url'], '/'))) {
            unlink(__DIR__ . '/../' . ltrim($img['image_url'], '/'));
        }
    }

    $mysqli->query("DELETE FROM product_images WHERE product_id = $id");
    $mysqli->query("DELETE FROM products WHERE id = $id");

    header("Location: products.php");
    exit;
}

// Fetch products with category name
$result = $mysqli->query("SELECT p.*, c.name AS category_name FROM products p 
                          JOIN categories c ON p.category_id = c.id 
                          ORDER BY p.sort_order ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="p-4">

<h2>Manage Products</h2>

<form method="post" enctype="multipart/form-data" class="mb-4">
  <div class="row g-2 align-items-center">
    <div class="col-auto">
      <select name="category_id" class="form-select" required>
        <option value="">Select Category</option>
        <?php
        $cats = $mysqli->query("SELECT * FROM categories ORDER BY name ASC");
        if ($cats && $cats->num_rows > 0) {
            while ($c = $cats->fetch_assoc()) {
                echo '<option value="' . $c['id'] . '">' . htmlspecialchars($c['name']) . '</option>';
            }
        } else {
            echo '<option value="">No categories found</option>';
        }
        ?>
      </select>
    </div>
    <div class="col-auto">
      <input type="text" name="name" class="form-control" placeholder="Item Name (English)" required>
    </div>
    <div class="col-auto">
      <input type="text" name="name_ar" class="form-control" placeholder="Item Name (Arabic)" required>
    </div>
    <div class="col-auto">
      <input type="file" name="image_files[]" class="form-control" accept="image/*" multiple required>
    </div>
    <div class="col-auto">
      <button type="submit" name="add" class="btn btn-success">Add Product</button>
    </div>
  </div>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th style="width:40px;"></th>
      <th>ID</th>
      <th>Category</th>
      <th>Name (English)</th>
      <th>Name (Arabic)</th>
      <th>Images</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="sortableProducts">
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr id="item_<?= $row['id'] ?>">
      <td class="drag-handle"><span class="bi bi-list"></span></td>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['category_name']) ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['name_ar']) ?></td>
      <td>
        <img src="<?= htmlspecialchars($row['image']) ?>" style="height:50px;">
      </td>
      <td>
        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

<!-- Saved Alert -->
<div id="saveAlert" class="alert alert-success position-fixed" 
     style="top:20px; right:20px; display:none; z-index:9999;">
    Saved!
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function () {

    $("#sortableProducts").sortable({
        handle: ".drag-handle",
        placeholder: "ui-state-highlight",
        update: function () {
            var order = $("#sortableProducts").sortable("toArray");

            $.post("update_order.php", { order: order }, function (data) {
                $("#saveAlert").fadeIn(200);
                setTimeout(function () {
                    $("#saveAlert").fadeOut(300);
                }, 1200);
            });
        }
    });

    $("#sortableProducts").disableSelection();

});
</script>

<style>
.drag-handle {
    cursor: grab;
    font-size: 22px;
    text-align: center;
    color: #555;
}
.drag-handle:hover {
    color: #000;
}
.ui-state-highlight {
    height: 55px;
    background: #fff3cd;
    border: 2px dashed #ffca2c;
}
</style>

</body>
</html>
