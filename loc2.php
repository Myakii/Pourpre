<?php
$bestRent = "Appartement - Penelope 8 - Paris IV";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/footer.css" rel="stylesheet" />
    <title><?=$bestRent ;?></title>
  </head>
  <body>
  <div class="./pages/header">
      <?php include "header.php"; ?>
  </div>

    <h1><?=$bestRent ;?></h1>

<div class="img">
    <img src="./img/slider/activity/location.jpg" class="location_section_image">
</div>
    
    <p><span id="libelle"></span></p>
    <p><span id="description"></span></p>
    <p><span id="prix"></span></p>
    <script src="./javascript/produit.js"></script>
    
    <footer>
    <div class="footer">
      <?php include "./pages/footer.php"; ?>
    </div>
    </footer>
  </body>
</html>