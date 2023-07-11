<?php 

require_once './include/function.php';

function display_resa_notice($pdo){


    if ($_SERVER['REQUEST_METHOD'] = 'POST'){

        $req_display_notice = $pdo->prepare("
        
            SELECT * 
            FROM notice
        
        ");

        $req_display_notice->execute();


        $display_notice = $req_display_notice->fetchAll(PDO::FETCH_ASSOC);

        foreach ($display_notice as $row){

            $house_id = $row['house_id'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $post_date = $row['post_date'];

            echo "{$post_date} Confirmation de votre réservation de l'appartement numéro {$house_id}, du {$start_date} au {$end_date}";

        }
    }
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='home.php' method='POST'>
        <button type='submit'>Retour</button>
    </form>
    <div>
        <h1>Notification</h1>
        <?php display_resa_notice($pdo); ?>
    </div>
</body>
</html>