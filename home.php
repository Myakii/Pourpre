<?php 

require_once './include/function.php';

$titel = "Page daccueil";
$partner = "Nos partenaires";
$titelHistory = "Notre Histoire";
$ourHistory = "Parler plus en détail de l'histoire du site passant par son idée,sa création, son histoire et mettre en avant l'envie d'un rythmede travail plus humain, être avec des gens de confiance...";
$bestRent = "Meilleures locations";
$bestActivity = "Meilleures activités";

$name_location = array(
  "Appartement Esperenca - Paris XVI",
  "Maison Coupenot - Paris X",
  "Appartement Evolution - Paris V",
);

$i = 0;

$stmt = $pdo->query("SELECT * FROM house");
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);


$houseImages = slide_asc($pdo);

if (!is_array($houseImages)) {
  $houseImages = [];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./css/header.css" rel="stylesheet" />
  <link href="./css/home.css" rel="stylesheet" />
  <link href="./css/footer.css" rel="stylesheet" />
  <link href="./css/slider_worst_building.css" rel="stylesheet" />
  <title><?=$titel; ?></title>
</head>
<body> 

    <?php include "./pages/header.php"; ?>
  <div class="home">

    <div class="slider">
      <?php foreach ($houseImages as $imageData): ?>
        <div class="WorstSlider fade">
          <?php
            if ($imageData !== null) {
              $image = ($imageData); // Convertir les données BLOB en base64
              echo '<img src="' .$image.'" />'; // Afficher l'image avec la balise <img>
            } else {
              echo '<p>Aucune image disponible</p>'; // Si aucune image n'est présente
            }
          ?>
          <h2 class="text"><?=$name_location[$i]; ?></h2>
        </div>


      <?php 
    $i++;
    
    endforeach; ?>
    </div>



    <div class="our_story">
      <h2 class="section_title"><?=$titelHistory; ?></h2>
      <p><?=$ourHistory; ?><?=$ourHistory; ?></p>
    </div>

    <div class="proposition">
      <h2 class="best_location"><button id="best_location"><?=$bestRent; ?></button></h2>
      <h2 class="best_activity"><button id="best_activity"><?=$bestActivity; ?></button></h2>
    </div>

    <div class="activity_img" id="activityImages">
      <a href="https://www.cometoparis.com/fre/catalog/dejeuner-croisiere-bateaux-mouches-9009"><img src="./assets/slider/activity/bateaumouche.jpg" class="activity_section_image"></a>
      <a href="https://www.parisinfo.com/musee-monument-paris/71304/Jardin-des-Tuileries"><img src="./assets/slider/activity/jardin_des_tuilerie.jpg" class="activity_section_image"></a>
    </div>

    <div class="location_img" id="locationImages">
      <a href="loc1.php"><img src="./assets/slider/activity/apartdeluxe.jpg" class="location_section_image"></a>
      <a href="loc2.php"><img src="./assets/slider/activity/location.jpg" class="location_section_image"></a>
    </div>
      
    <div class="partner_section">
      <h2 class="partner_title"><?=$partner; ?></h2> 
      
      <div class="partner_logo">
        <a href="https://www.pierreherme.com/"><img
        src="./assets/logo/ph.svg"
        class="choco_logo"
        /></a>
        <a href="https://www.caves-legrand.com/"><img
        src="./assets/logo/vin-de-riche.svg"
        class="vin_logo"
        /></a>
        <a href="https://www.restaurants-toureiffel.com/fr/restaurant-jules-verne.html"><img
        src="./assets/logo/jule_verne.svg"
        class="resto_logo1"
        /></a>
        <a href="https://www.alainducasse-plazaathenee.com/"><img
        src="./assets/logo/alain-ducasse.svg"
        class="resto_logo2"
        /></a>
      </div>
    </div>
  </div>
  <footer>
      <?php include "./pages/footer.php"; ?>
  </footer>
  <script src="./javascript/slider_worst_building.js"></script>
  <script src="./javascript/proposition.js"></script>
  <script src="./javascript/header.js"></script>
  <script src="./javascript/blank.js"></script>

</body>

</html>
