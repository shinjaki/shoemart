<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeMart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/design.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="css/styles.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;
0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400
..900;1,400..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<style>
  body {
      font-family: 'Roboto', sans-serif;
      background: #F4F4F4;
      color: black;
  }

  .navbar{
      padding: 10px 20px;
  
  }

  .navbar a, .footer a {
      color: white;
      text-decoration: none;
  }

  .navbar a:hover, .footer a:hover {
      color: black;
  }
</style>
</head>
<body> 
    
<section id="main">

    <?php include('navbar.php'); ?>

    <?php include('menu.php'); ?>

</section>

    
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>

</body>
</html>