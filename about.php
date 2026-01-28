<?php include __DIR__.'/includes/head.php'; ?>
<?php include __DIR__.'/includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Petrichoor Chocolate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #e8f0e4, #f8f8f8);
      color: #333;
    }
    .section-title {
      font-family: 'Pacifico', cursive;
      font-size: 3rem;
      color: #436b4b;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .highlight {
      color: #ff6600;
      font-weight: 600;
    }
    .content-box {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      padding: 2rem;
      margin-bottom: 2rem;
    }
    .section-dark {
      background-color: #1f3b2f;
      color: #fff;
      border-radius: 15px;
    }
    h5 {
      color: #ff6600;
      font-weight: 600;
      margin-top: 1rem;
    }
    .image-left {
      border-radius: 15px;
      width: 100%;
      height: auto;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    @media (max-width: 768px) {
      .about-row {
        flex-direction: column;
      }
      .image-left {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <h1 class="section-title">Who Are We?</h1>

    <!-- About Section with Image on Left -->
    <div class="row align-items-center about-row mb-5">
      <div class="col-lg-3 mb-4 mb-lg-0">
        <img src="/petrichoor/assets/images/aboutpetrichoor.jpg" 
             alt="Luxury artisan chocolate with natural elements" class="image-left">
      </div>
      <div class="col-lg-7">
        <div class="content-box">
          <h5>Unique Positioning:</h5>
          <p>This brand stands out due to its diversity and inclusivity, appealing to a wide segment of characters and occasions.</p>

          <p><span class="highlight">Friendly yet Luxurious:</span> The brand strikes a balance between being approachable and carrying a subtle touch of luxury that shines across various collections.</p>

          <p><span class="highlight">Versatility for All Occasions:</span> Suitable for all times and occasions, whether it’s a grand celebration or a simple gesture of love between two people.</p>

          <p><span class="highlight">Ethical and Eco-Friendly:</span> The brand is committed to ethical practices and eco-friendliness, offering a healthier version of chocolate without compromising on taste.</p>
        </div>
      </div>
    </div>

    <!-- Targeting All Ages -->
    <div class="content-box section-dark">
      <h5>Targeting All Ages:</h5>
      <p>Designed to appeal to all ages, from kids who love the taste to parents who trust in the quality and healthier options provided.</p>

      <h5>Luxurious Offerings:</h5>
      <p>For those moments when only the finest will do, the brand offers luxurious options that show sincere care and thoughtfulness.</p>

      <h5>Health-Conscious Choices:</h5>
      <p>Catering to customers who prioritize health and fitness, Petrichoor offers jaw-dropping products that stand out in the wellness space.</p>

      <h5>Innovative Creations:</h5>
      <p>Founded by a young, visionary creator with a supportive mother and big dreams, the brand delivers unique chocolate creations through inventive fillings and <em>avant-garde</em> flavors.</p>

      <h5>Constant Innovation:</h5>
      <p>A new flavor is introduced regularly, keeping the brand at the cutting edge of the chocolate world with bold and exciting choices.</p>

      <h5>Visual Identity:</h5>
      <p>The brand’s colors and artwork reflect its core values: authenticity, luxury, a natural earthy touch, feminine elegance, groundbreaking ideas, and outlandish flavors.</p>

      <h5>Fun and Excitement:</h5>
      <p>An anti-boredom brand that’s fun, exciting, and offers something for everyone — allowing each customer to see their best reflection in it.</p>
    </div>
  </div>

<?php include __DIR__.'/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
