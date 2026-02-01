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
        // Get max sort_order for new product
        $result = $mysqli->query("SELECT MAX(sort_order) as max_order FROM dashboard_product");
        $row = $result->fetch_assoc();
        $sort_order = $row['max_order'] + 1;

        $sql = "INSERT INTO dashboard_product (title, title_ar, image, sort_order) VALUES ('$title', '$title_ar', '$imageName', $sort_order)";
        if($mysqli->query($sql)){
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
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM dashboard_product WHERE id = $id";
    if($mysqli->query($sql)){
        header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
        exit();
    } else {
        $msg = "Error deleting product: " . $mysqli->error;
    }
}

// Handle Edit (AJAX POST)
if(isset($_POST['edit_product'])){
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $title_ar = $_POST['title_ar'];
    $sql = "UPDATE dashboard_product SET title='$title', title_ar='$title_ar' WHERE id=$id";
    if($mysqli->query($sql)){
        echo "success";
    } else {
        echo "error: " . $mysqli->error;
    }
    exit();
}

// Handle AJAX reorder
if(isset($_POST['update_order'])){
    $ids = $_POST['ids']; // comma-separated list of IDs
    $idsArray = explode(',', $ids);
    foreach($idsArray as $index => $id){
        $id = intval($id);
        $order = $index + 1;
        $mysqli->query("UPDATE dashboard_product SET sort_order=$order WHERE id=$id");
    }
    echo "success";
    exit();
}

// Show messages
if(isset($_GET['success'])) $msg = "Product added successfully!";
if(isset($_GET['deleted'])) $msg = "Product deleted successfully!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard Products | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  .sortable-row { cursor: grab; }
  .input-inline { width: 100%; }
</style>
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
    <table class="table table-bordered table-striped mt-3" id="productTable">
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
        $sql = "SELECT * FROM dashboard_product ORDER BY sort_order ASC";
        $result = $mysqli->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ ?>
              <tr class="sortable-row">
                <td><?= $row['id'] ?></td>
                <td><img src="../assets/images/<?= $row['image'] ?>" width="80" alt="<?= $row['title'] ?>"></td>
                <td class="title"><?= htmlspecialchars($row['title']) ?></td>
                <td class="title_ar"><?= htmlspecialchars($row['title_ar']) ?></td>
                <td>
                  <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                  <button class="btn btn-sm btn-secondary move-up">↑</button>
                  <button class="btn btn-sm btn-secondary move-down">↓</button>
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
<script>
document.addEventListener("DOMContentLoaded", function(){

  const tableBody = document.querySelector("#productTable tbody");

  // Edit button functionality
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      const row = btn.closest('tr');
      const id = row.children[0].textContent;
      const titleCell = row.querySelector('.title');
      const titleArCell = row.querySelector('.title_ar');

      if(btn.textContent === 'Save'){
        const newTitle = titleCell.querySelector('input').value;
        const newTitleAr = titleArCell.querySelector('input').value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function(){
          if(xhr.responseText.trim() === "success"){
            titleCell.textContent = newTitle;
            titleArCell.textContent = newTitleAr;
            btn.textContent = 'Edit';
          } else {
            alert("Update failed!");
          }
        };
        xhr.send("edit_product=1&id=" + id + "&title=" + encodeURIComponent(newTitle) + "&title_ar=" + encodeURIComponent(newTitleAr));
      } else {
        titleCell.innerHTML = `<input type="text" class="input-inline" value="${titleCell.textContent}">`;
        titleArCell.innerHTML = `<input type="text" class="input-inline" value="${titleArCell.textContent}">`;
        btn.textContent = 'Save';
      }
    });
  });

  // Move Up / Move Down with persistent order
  function updateOrder() {
    const ids = Array.from(tableBody.querySelectorAll('tr')).map(tr => tr.children[0].textContent).join(',');
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("update_order=1&ids=" + ids);
  }

  document.querySelectorAll('.move-up').forEach(btn => {
    btn.addEventListener('click', function(){
      const row = btn.closest('tr');
      const prev = row.previousElementSibling;
      if(prev){
        tableBody.insertBefore(row, prev);
        updateOrder();
      }
    });
  });

  document.querySelectorAll('.move-down').forEach(btn => {
    btn.addEventListener('click', function(){
      const row = btn.closest('tr');
      const next = row.nextElementSibling;
      if(next){
        tableBody.insertBefore(next, row);
        updateOrder();
      }
    });
  });

});
</script>
</body>
</html>
