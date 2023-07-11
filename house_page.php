<?php

require_once './include/function_house.php';
require_once './include/function.php';

if (isset($_GET['id'])) {
    $house_id = $_GET['id'];
}

$house_details = get_house_details($pdo, $house_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/house_page.css">
    <title><?= $house_details['name'] ?></title>
</head>
<body>
    
    <?php require_once './pages/header.php' ?>
    
    <?php
    // verification de si la location existe
    if ($house_details) {
        $house_id = $house_details['id'];
        $house_name = $house_details['name'];
        $house_img = $house_details['img'];
        $house_address = $house_details['adress'];
        $house_postal_code = $house_details['postal_code'];
        $house_type = $house_details['type'];
        $house_num_room = $house_details['num_room'];
        $house_description = $house_details['description'];
        $house_option_premium = $house_details['option_premium'];
        $house_status = $house_details['status'];
        $house_price = $house_details['price'];

        // affichage des informations de la maison
        echo '<div class="house_info"> 
            <h2>'. $house_name .'</h2>
            <img src="'. $house_img .'">
            <div class="info">
                <h4>Adresse:</h4>
                <p>'. $house_address .'</p>
                <h4>Code postal:</h4>
                <p>'. $house_postal_code .'</p>
                <h4>Type:</h4>
                <p>'. $house_type .'</p>
                <h4>Nombre de chambre:</h4>
                <p>'. $house_num_room .'</p>
                <h4>Description:</h4>
                <p>'. $house_description .'</p>
                <h4>Option premium:</h4>
                <p>'. $house_option_premium .'</p>
                <h4>Status:</h4>
                <p>'. $house_status .'</p>
                <h4>Prix:</h4>
                <p>'. $house_price .'</p>
            </div>
        </div>';
    
        
        // verification de la session client
        if (isset($_SESSION['login']) && ($_SESSION['role'] === 'Client') && ($house_status === 'Disponible')) {
            // formulaire de réservation
            echo '
            <div class="reservation_form">
                <h3>Réserver cette maison</h3>  
                <form method="POST" action="process_reservation.php">
                    <input type="hidden" name="house_id" value="' . $house_id . '">
                    <label for="start_date">Date de début :</label>
                    <input type="date" name="start_date" min="' . date('Y-m-d') . '" required>
                    <label for="end_date">Date de fin :</label>
                    <input type="date" name="end_date" min="' . date('Y-m-d') . '" required>
                    <button type="submit" class="button">Réserver</button>
                </form>
            </div>';

        }elseif($house_status === 'Indisponible' ) {
            echo "
            <div class='not_connect'>
                Le bien a déjà été loué.
            </div>";
        } else {
            echo"
            <div class='not_connect'>
                Vous devez être connecté pour réserver cette location.
            </div>";
        }
    } else {
        echo "La maison avec l'ID '" . $house_id . "' n'existe pas.";
    }
    ?>

    <?php require_once './pages/footer.php' ?>

</body>
<script src="./javascript/preview.js"></script>
<script src="./javascript/header.js"></script>
<script src="./javascript/house_page.js"></script>
</html>
