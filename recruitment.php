<?php
require_once './include/function.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/recruitment.css">
    <title>Recruitement - Pourpre</title>
</head>
<body>

    <?php include './pages/header.php' ?>

    <div class="picture_house">
        <img src="./assets/house/home_house_3.jpg"/>
    </div>
    <div class="tilte_recruitment">
        <h2> Nos offres </h2>
        <h3>Agent d'entretien :</h3> <p> En tant qu'agent d'entretien, vous serez responsable du nettoyage et de l'entretien des maisons et/ou appartements, du réapprovisionnement des produits dans nos bars et frigo. Votre rôle consistera à veiller à ce que les lieux soient propres, accueillants et bien entretenus avant l'arrivé des clients.</p>

        <h3>Agent de propreté :</h3> <p> En rejoignant le métier d'agent de propreté, vous serez chargé de l'entretien et de la désinfection des surfaces, du dépoussiérage, du lavage des sols, de la gestion des déchets et de l'approvisionnement en produits d'entretien. Votre mission consistera à maintenir des espaces propres, hygiéniques et agréables.</p>

        <h3>Technicien de maintenance :</h3> <p> En tant que technicien de maintenance, vous assurerez la maintenance préventive et corrective des équipements, des installations électriques, des systèmes de ventilation et de climatisation. Vous serez également amené à intervenir sur des travaux de plomberie pour garantir le bon fonctionnement des infrastructures.</p>

        <h3>Employé(e) de chambre :</h3> <p> Travaillant dans l'hôtellerie, vous serez chargé du nettoyage des chambres, du changement des draps, du réapprovisionnement des produits de salle de bains et de l'entretien des parties communes. Votre rôle sera de garantir un séjour confortable et agréable pour les clients en maintenant les chambres et les espaces communs impeccables.</p>
    </div>
    <a href="identification_staff.php">
        <button type="button" id="recruitment"> Postulez </button>
    </a>

    <?php include './pages/footer.php' ?>
</body>
</html>