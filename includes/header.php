<?php
// Detect the current page to handle language switching
$currentPage = basename($_SERVER['PHP_SELF']);

// Define Arabic mode
$isArabic = in_array($currentPage, ['index-ar.php', 'careers-ar.php', 'contact-ar.php']);
?>
<!DOCTYPE html>
<html lang="<?= $isArabic ? 'ar' : 'en' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Petrichoor Chocolate</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body <?= $isArabic ? 'dir="rtl" lang="ar"' : '' ?>>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
  <div class="container-fluid px-4">
    <!-- Logo -->
    <a class="navbar-brand" href="<?= $isArabic ? '/index-ar.php' : '/index.php' ?>">
      <img src="/assets/images/logo.png" alt="Petrichoor Chocolate" class="navbar-logo" style="height:40px;">
    </a>

    <!-- Custom Image Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <img src="/assets/images/pj.png" alt="menu" style="width:30px; height:30px; border-radius:50%;">
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="<?= $isArabic ? '/index-ar.php' : '/index.php' ?>">
            <?= $isArabic ? 'الرئيسية' : 'Home' ?>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= $isArabic ? '/careers-ar.php' : '/careers.php' ?>">
            <?= $isArabic ? 'إنضم لفريقنا' : 'Careers' ?>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= $isArabic ? '/contact-ar.php' : '/contact.php' ?>">
            <?= $isArabic ? 'تواصل معنا' : 'Contact' ?>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= $isArabic ? '/index.php' : '/index-ar.php' ?>">
            <?= $isArabic ? 'English' : 'عربي' ?>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Google Translate -->
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
