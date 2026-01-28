<?php 
include __DIR__ . '/includes/head-ar.php'; 
include __DIR__ . '/includes/header-ar.php'; 
include __DIR__ . '/includes/db_connect.php';
?>

<div class="container mt-5" dir="rtl" style="text-align: right;">
  <div class="text-center py-5">
    <h1>قائمة منتجاتنا</h1>
    <p class="lead">اكتشف مجموعتنا من الشوكولاتة المصنوعة يدوياً.</p>
    <a href="https://petrichoorchocolate.com/odine/" class="btn btn-order-online btn-lg mt-3">اطلب الآن</a>
  </div>

<?php
// Fetch all categories with Arabic name
$categoriesResult = $mysqli->query("SELECT * FROM categories ORDER BY name_ar ASC");

if ($categoriesResult->num_rows > 0) {
    while ($category = $categoriesResult->fetch_assoc()) {
        // Display Arabic category name
        echo "<h2 class='mt-5 mb-3'>" . htmlspecialchars($category['name_ar']) . "</h2>";
        echo "<div class='row g-3'>";

        // Fetch all products in this category with Arabic name
        $stmt = $mysqli->prepare("SELECT id, name_ar, image FROM products WHERE category_id = ?");
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

                $carouselId = "carousel_" . md5($product['name_ar'] . $product['id']);

                echo '
                <div class="col-md-2 col-6">
                  <div class="card shadow-sm">
                    <div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">';

                $active = 'active';
                foreach ($images as $img) {
                    echo '
                        <div class="carousel-item ' . $active . '">
                          <img src="' . htmlspecialchars($img) . '" class="d-block w-100" alt="' . htmlspecialchars($product['name_ar']) . '">
                        </div>';
                    $active = '';
                }

                echo '</div>';

                if(count($images) > 1) {
                    echo '
                      <button class="carousel-control-prev" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                      </button>';
                }

                echo '
                    </div>
                    <div class="card-body text-center">
                      <h6 class="card-title">' . htmlspecialchars($product['name_ar']) . '</h6>
                    </div>
                  </div>
                </div>';
            }
        } else {
            echo '<p class="text-muted">لا توجد منتجات في هذه الفئة حالياً.</p>';
        }

        echo "</div>"; // end row
    }
} else {
    echo "<p class='text-muted'>لا توجد فئات متاحة حالياً.</p>";
}
?>
</div>

<!-- Scroll to Top Button -->
<button onclick="scrollToTop()" id="scrollTopBtn" title="الذهاب للأعلى">↑</button>

<?php include __DIR__ . '/includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional: RTL CSS -->
<style>
body[dir="rtl"] {
    direction: rtl;
}
</style>
