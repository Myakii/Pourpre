<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

function notice ($pdo){

    $_SERVER['REQUEST_METHOD'] = 'POST';    

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $display_notice_task = $pdo->prepare("
            SELECT *
            FROM notice_admin
        
        ");

        $display_notice_task->execute();

        $notif_admin = $display_notice_task->fetchAll(PDO::FETCH_ASSOC);

        if ($display_notice_task->rowcount() > 0){


            foreach ($notif_admin as $row){

                $task_name = $row['task_name'];
                $house_id = $row['house_id'];
                $date_notice = $row['date'];
                $type_task = $row['type_task'];

                if ($type_task == 1){
                    echo"
                    <div class='notif_one'>{$date_notice} L'intervention de l'apparement numeros {$house_id} ({$task_name}) a été terminé</div>
                    ";
                    } elseif ($type_task == 2){

                        echo"Modication de réservation";

                    } elseif ($type_task == 3){

                        echo"Nouvelle réservation";

                    } else {

                        echo "Aucune nouvelle notification";
                    }
                }
            } 
        } 
    }
}

function new_resa_notice($pdo){

    if ($_SERVER['REQUEST_METHOD'] = 'POST'){

        $display_new_resa_req = $pdo->prepare("
        
            SELECT *
            FROM notice
        
        ");

        $display_new_resa_req->execute();


        $display_new_resa = $display_new_resa_req->fetchAll(PDO::FETCH_ASSOC);

        foreach ($display_new_resa as $row){

            $house_id = $row['house_id'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $post_date = $row['post_date'];

            echo "{$post_date} Nouvelle réservation de l'appartement numéro {$house_id}, du {$start_date} au {$end_date}";

        }
    }

}


?>