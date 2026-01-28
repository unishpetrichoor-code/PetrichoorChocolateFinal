<?php
include __DIR__ . '/includes/head.php';
?>

<body>

<!-- Loader -->
<div id="loader">
  <div class="loader-content">
    <img src="/assets/images/smalllogo.png" alt="Petrichoor Logo" class="loader-logo">
  </div>
</div>

<!-- Main Content -->
<div id="main-content" style="display:none;">
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<!-- Hero Section -->
<section id="home" class="hero-section py-5 position-relative">
  <div class="hero-overlay">
    <!-- optional overlay content -->
  </div>
  <div class="container position-relative">

    <div class="row justify-content-center align-items-center">

      <!-- Video -->
      <div class="col-md-6 col-10"> <!-- wider column for bigger video -->
        <div class="hero-img-card mx-auto">
          <video class="hero-small-video" autoplay muted loop playsinline>
            <source src="/assets/videos/Ramadan Video.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
      </div>

    </div>

    <!-- Hero Text -->
    <div class="hero-text text-center mt-4">
      <p class="lead text-beige" style="font-family: sans-serif;">Unspoiled Sensation</p>
      <a class="btn btn-order-online btn-lg mt-3" href="https://petrichoorchocolate.com/odine/">Order Online</a>
    </div>
  </div>
</section>



<!-- Add this in the <head> of your HTML to load premium fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

<!-- About Section -->
<section id="about" class="about py-4" style="background-color: #faf9f4;">
  <div class="container">
    <div class="row align-items-center justify-content-between">

      <!-- Text Content -->
      <div class="col-lg-7 col-md-12">
        <div class="about-content" style="max-width: 620px;">
          <h2 class="about-heading mb-3" style="
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            color: #2f3e2f;
            position: relative;
            ">
            About <span class="highlight">Petrichoor Chocolate</span>
          </h2>

          <p class="about-text intro-text" style="
            font-family: 'Inter', sans-serif;
            font-style: italic;
            font-size: 0.98rem;
            color: #5e6a5e;
            line-height: 1.75;
            letter-spacing: 0.2px;
            margin-bottom: 1.2rem;
            ">
            <span class="emphasis" style="font-weight: 500; color: #3b4a3b;">
              From the moment you hear "Petrichoor," you sense a poetic touch and might wonder, "What does this have to do with chocolate?"
            </span>...
          </p>

          <p class="about-text main-story" style="
            font-family: 'Inter', sans-serif;
            font-size: 0.98rem;
            color: #6b7568;
            line-height: 1.75;
            letter-spacing: 0.2px;
            margin-top: 1.6rem;
            margin-bottom: 1.2rem;
            ">
            <span class="emphasis" style="font-weight: 500; color: #3b4a3b;">
              At just 17, a young girl—quiet and gentle like a calm ocean, yet filled with color and bold dreams beneath the surface—was diagnosed with Type 2 diabetes and told to give up sugar forever. What seemed impossible became her purpose: to create sugar-free chocolate that allows everyone, especially diabetics, to enjoy sweetness without compromise.
            </span>
            <span class="emphasis" style="font-weight: 500; color: #3b4a3b;">
              What began in a small room at her home grew into a far greater vision, driven by belief, passion, and the spirit of the UAE—where, inspired by the legacy of Sheikh Zayed, nothing is impossible !
            </span>.
          </p>

          <p class="about-text founding-story" style="
            font-family: 'Inter', sans-serif;
            font-size: 0.98rem;
            color: #6b7568;
            line-height: 1.75;
            letter-spacing: 0.2px;
            margin-top: 1.6rem;
            margin-bottom: 1.2rem;
            ">
            <span class="emphasis" style="font-weight: 500; color: #3b4a3b;">
              Inspired by petrichor, the comforting scent after rain, Petrichoor blends premium ingredients with artisanal craft, shaping —
              where refined details come together to create modern Emirati hospitality and an unforgettable experience.
            </span>
            <br><br>
            <span class="brand-name" style="
              font-family: 'Playfair Display', serif;
              font-size: 1.05rem;
              font-weight: 500;
              color: #2f3e2f;
              letter-spacing: 0.4px;
              display: inline-block;
              ">
              At Petrichoor, we don’t simply craft chocolate
              we curate a complete experience, woven from
              refined details that elevate your lifestyle.
            </span>
          </p>

          <p class="about-text philosophy" style="
            font-family: 'Inter', sans-serif;
            font-size: 0.98rem;
            color: #6b7568;
            line-height: 1.75;
            letter-spacing: 0.2px;
            ">
            <span class="emphasis"></span>
          </p>
        </div>
      </div>

      <!-- Image -->
      <div class="col-lg-5 col-md-12">
        <div class="about-img-wrapper" style="display: flex; justify-content: flex-end;">
          <img
            src="/assets/images/pp.jpg"
            alt="Petrichor Chocolate"
            class="about-img img-fluid"
            style="
              max-width: 420px;
              width: 100%;
              border-radius: 16px;
              box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            "
          >
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Products Section -->
<section id="products" class="featured-products py-5">
  <div class="container text-center">
    <h2 class="text-center mb-4">Collections</h2>
    <div class="d-flex flex-wrap justify-content-center" style="column-gap: 8px; row-gap: 20px;">
      <?php 
      include 'includes/db_connect.php';
      $query = "SELECT * FROM dashboard_product ORDER BY id ASC";
      $result = $mysqli->query($query);
      if($result->num_rows > 0):
          while($prod = $result->fetch_assoc()): ?>
            <div style="flex: 0 0 calc(20% - 8px);">
              <div class="card shadow-sm h-100">
                <img src="/assets/images/<?= $prod['image'] ?>" 
                     class="card-img-top" 
                     alt="<?= $prod['title'] ?>" 
                     style="object-fit: cover; width: 100%; height: 180px;">
                <div class="card-body d-flex flex-column justify-content-between text-center">
                  <h5 class="card-title"><?= $prod['title'] ?></h5>
                  <a href="https://petrichoorchocolate.com/odine/" class="btn btn-beige mt-auto">View</a>
                </div>
              </div>
            </div>
      <?php endwhile; else: ?>
        <p class="text-center">No products available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Join Our Team Section -->
<section id="careers" class="join-team py-5" style="background-color:#F9F7DC;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8 text-md-start text-center mb-3 mb-md-0">
        <h2 class="display-5 fw-bold text-theme">Join Our Team</h2>
        <p class="lead text-dark">
          Passionate about chocolate? 🍫<br>
          Join our family and create delightful experiences for chocolate lovers everywhere.
          Let your creativity and love for quality shine!
        </p>
      </div>
      <div class="send-cv">
        <a class="button" href="/contact.php">Send Your CV</a>
      </div>
    </div>
  </div>
</section>

<!-- Contact Us Section -->
<section class="contact-us py-5">
  <h2>Contact Us</h2>
  <div class="contact-cards">
    <div class="card">
      <i class="bi bi-envelope-fill"></i>
      <a href="mailto:b2b@petrichoorchocolate.com" class="email">b2b@petrichoorchocolate.com</a>
    </div>
    <div class="card">
      <i class="bi bi-telephone-fill"></i>
      <a href="tel:+97152257993">+971 58 679 9389</a>
    </div>
    <div class="card">
      <i class="bi bi-geo-alt-fill"></i>
      <a href="/contact.php">Ajman, Al Jerf 2, UAE</a>
    </div>
    <div class="card">
      <i class="bi bi-instagram"></i>
      <a href="https://www.instagram.com/petrichoor.ae/" target="_blank">@petrichoor.ae</a>
    </div>
  </div>
  <a class="button" href="/contact.php">Contact Us</a>
</section>

<!-- WhatsApp Chat Widget -->
<a href="https://wa.me/971586799389" class="whatsapp-float" target="_blank">
  <img src="/assets/images/hl.png" alt="Chat with us">
  <span class="chat-text">Chat with us</span>
</a>
<script>
function hideGetButton(){
  const el = document.querySelector('.wh-widget-send-button') || document.querySelector('[id^="getbutton"]');
  if(el) el.style.display = 'none';
}
hideGetButton();
setTimeout(hideGetButton,1000);
setTimeout(hideGetButton,3000);
</script>

<!-- Footer -->
<?php include __DIR__.'/includes/footer.php'; ?>
</div> <!-- end main-content -->

<!-- Loader CSS -->
<style>
#loader {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 100%;
  background: linear-gradient(135deg,#8B4513,#A0522D);
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  z-index: 9999;
}
.loader-logo {
  width: 120px;
  animation: rotate 2s linear infinite;
  margin-bottom: 20px;
}
.loader-text {
  font-family: Arial, sans-serif;
  font-weight: bold;
  font-size: 18px;
  color: #FFD700;
}
@keyframes rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<!-- Loader JS -->
<script>
window.addEventListener("load", function() {
  const loader = document.getElementById("loader");
  const mainContent = document.getElementById("main-content");
  // Keep loader for 2.5s then fade out
  setTimeout(() => {
    loader.style.opacity = "0";
    loader.style.transition = "opacity 0.8s ease-out";
    setTimeout(() => {
      loader.style.display = "none";
      mainContent.style.display = "block";
    }, 800);
  }, 1000); // loader visible for 2.5s
});
</script>
