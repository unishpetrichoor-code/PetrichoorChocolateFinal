<?php 
include __DIR__ . '/includes/head.php'; 
include __DIR__ . '/includes/header.php'; 
include __DIR__ . '/includes/db_connect.php';
?>

<div class="container mt-5">
  <div class="text-center py-5">
    <h1>Our Menu</h1>
    <p class="lead">Discover our range of handcrafted chocolates.</p>
    <a href="https://petrichoorchocolate.com/odine/" class="btn btn-order-online btn-lg mt-3">Order Online</a>
  </div>

<?php
// Fetch all categories
$categoriesResult = $mysqli->query("SELECT * FROM categories ORDER BY name ASC");

if ($categoriesResult->num_rows > 0) {
    while ($category = $categoriesResult->fetch_assoc()) {
        echo "<h2 class='mt-5 mb-3'>" . htmlspecialchars($category['name']) . "</h2>";
        echo "<div class='row g-3'>";

        // Fetch all products in this category
        $stmt = $mysqli->prepare("SELECT id, name, image FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $category['id']);
        $stmt->execute();
        $productsResult = $stmt->get_result();

        if ($productsResult->num_rows > 0) {
            while ($product = $productsResult->fetch_assoc()) {
                // Fetch additional images from product_images table
                $imgStmt = $mysqli->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
                $imgStmt->bind_param("i", $product['id']);
                $imgStmt->execute();
                $imgResult = $imgStmt->get_result();

                $images = [$product['image']]; // first image is main image
                while ($rowImg = $imgResult->fetch_assoc()) {
                    $images[] = $rowImg['image_url'];
                }

                $carouselId = "carousel_" . md5($product['name'] . $product['id']);

                echo '
                <div class="col-md-2 col-6">
                  <div class="card shadow-sm">
                    <div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">';

                $active = 'active';
                foreach ($images as $img) {
                    echo '
                        <div class="carousel-item ' . $active . '">
                          <img src="' . htmlspecialchars($img) . '" class="d-block w-100" alt="' . htmlspecialchars($product['name']) . '">
                        </div>';
                    $active = '';
                }

                echo '</div>';

                if(count($images) > 1) {
                    echo '
                      <button class="carousel-control-prev" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>';
                }

                echo '
                    </div>
                    <div class="card-body text-center">
                      <h6 class="card-title">' . htmlspecialchars($product['name']) . '</h6>
                    </div>
                  </div>
                </div>';
            }
        } else {
            echo '<p class="text-muted">No products available in this category yet.</p>';
        }

        echo "</div>"; // end row
    }
} else {
    echo "<p class='text-muted'>No categories available yet.</p>";
}
?>
</div>

<!-- Scroll to Top Button -->
<button onclick="scrollToTop()" id="scrollTopBtn" title="Go to top">↑</button>

<?php include __DIR__ . '/includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
