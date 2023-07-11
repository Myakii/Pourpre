<?php 

include_once './include/function_admin_staff.php';
include_once './include/function_task.php';

create_task($pdo, $method);

?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/task.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Création de tâches</title>
</head>
<body>

    <?php include "./pages/header.php"; ?>
   
    <div class="form-container">
        <div class="box">
            <div class="container"> 
                <h3 class="title">Création de tâche</h3>

                <form action="" method="POST" class="">
                    <div class="select"> 
                        <label for="staff_name">Nom de l'employé(e) :</label>
                        <select name="staff_name">
                            <?php 
                                foreach ($select_display_result as $row){
                                $name = $row['name'];
                                echo "<option>{$name}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="appart">
                        <label for="apartment_number">Numéros de l'appartement :</label>
                        <input type="text" name="apartment_number" placeholder="Numéros d'appartement" require>
                    </div>
                    <div class="name">
                        <label for="task_name">Nom de la tâche :</label>
                        <input type="text" name="task_name" placeholder="Nom de la tâche à réaliser" require>
                    </div>

                    <div class="note">
                        <label for="note">Note :</label>
                        <textarea type="text" name="note" placeholder="Note à ajouter" require></textarea>
                    </div>

                    <div class="send_buttonn_div">
                        <button class="send_button" type="submit" name="submit_form">Envoyer</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</html> 