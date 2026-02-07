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

  <link rel="icon" type="image/png" href="assets/images/fav.png">


</head>
