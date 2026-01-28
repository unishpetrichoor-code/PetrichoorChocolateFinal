<head>

<?php
session_start();

// Default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Switch language if button clicked
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if ($lang === 'ar' || $lang === 'en') {
        $_SESSION['lang'] = $lang;
    }
}

// Load CSS based on language
$cssFile = ($_SESSION['lang'] === 'ar') ? 'style_ar.css' : 'style.css';
?>
<link rel="stylesheet" href="/assets/css/<?= $cssFile ?>">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petrichoor Chocolate</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


  <!-- Custom CSS -->
  <link rel="stylesheet" href="/petrichoor/assets/css/style.css">

  <!-- Google Fonts for Marquee -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
