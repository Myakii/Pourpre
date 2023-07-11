<?php
require_once './include/function_house.php';
// récupérer la liste des locations
$stmt = $pdo->query("SELECT * FROM house");
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$picture = "Image";
$delete = "Supprimer";
$name_loc = "Nom";
$Locat = "Adresse";
$type = "Type";
$room_mumber = "Nombre de chambres";
$description = "description";
$option = "Option premium";
$statut = "Statut";
$actions = "Actions";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/footer.css" rel="stylesheet" />
    <link href="./css/rental.css" rel="stylesheet" />
    <title>Appartements</title>
</head>
<body>
        <?php include "./pages/header.php"; ?>

        <?php house_64($pdo) ?>

        <?php include "./pages/footer.php"; ?>
    
    <script src="./javascript/header.js"></script>

</body>
</html>