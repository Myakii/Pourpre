<?php
require_once './include/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['house_id'], $_POST['start_date'], $_POST['end_date'])) {
        $house_id = $_POST['house_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // realiser l'operation de reservation
        if (update_house_reservation($pdo, $house_id, $start_date, $end_date)) {
            echo "La reservation a été effectuée avec succès.";
        } else {
            echo "La reservation a echoué. Veuillez reessayer ultérieurement.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire de réservation.";
    }
} else {
    echo "Accès invalide à la page de réservation.";
}

// execution de la mise à jour de la table house pour les reservations
function update_house_reservation($pdo, $house_id, $start_date, $end_date) {
    $query = "UPDATE house SET start_date = :start_date, end_date = :end_date, number_reservation = number_reservation + 1 WHERE id = :house_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':house_id', $house_id);
    $statement->bindParam(':start_date', $start_date);
    $statement->bindParam(':end_date', $end_date);

    $notice_resa_req = $pdo->prepare("
            
        INSERT INTO notice (house_id, start_date, end_date)
        VALUES (:house_id, :start_date, :end_date)
        
    ");

    $notice_resa_req->execute([

        ':house_id' => $house_id,
        ':start_date' => $start_date,
        ':end_date' => $end_date,

    ]);
    
    if ($statement->execute()) {
        // verifier si la date de reservation est la même que la periode de reservation passee
        $today = date('Y-m-d');
        if ($today >= $start_date && $today <= $end_date) {
            $query = "UPDATE house SET status = 'Indisponible' WHERE id = :house_id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':house_id', $house_id);
            $statement->execute();
        }

        // la mise à jour a ete effectuee avec succes
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./css/bac_button.css" rel="stylesheet" />
    <title>Confirmation de reservation</title>
</head>
<body>
    <a href="rental.php"><button type="submit" class="bac_button">Retour</button></a>
</body>
</html> 