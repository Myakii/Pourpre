<?php 

include_once './include/function.php';

$method = $_SERVER["REQUEST_METHOD"];
#Récupérer la première valeur de $task_id via le display_all_task.php
#Permets ainsi de le placer dans un input hidden dans le HTML afin de renvoyer la valeur et ne pas perdre le $_POST['task_id']
#Inutile le isset mais je prèfere pour préciser et en plus tu peux faire des messages d'erreurs au cas ou (CA SERT VRAIMENT A RIEN)
if(isset($_POST['modify'])){

    $task_id = $_POST['task_id'];
}

#Vérifier que la valeur n'est pas vide pour éviter un message d'erreur
if(isset($_POST['submit_form'])) {

    #Executer le code seulement si le bouton du modify est cliqué
    if ($_POST['submit_form']){

        if ($method == "POST") {
            
            $apartment_number = filter_input(INPUT_POST, "apartment_number");
            $task_name = filter_input(INPUT_POST, "task_name");
            $note = filter_input(INPUT_POST, "note");
            $task_id = filter_input(INPUT_POST, "task_id");

            $update_request = $pdo->prepare("
            
            UPDATE task
            SET house_id = :apartment_number, task_name = :task_name, note = :note
            WHERE id = :id
            
            ");
            
            $update_request->execute([
                
                ':id' => $task_id,
                ':apartment_number' => $apartment_number,
                ':task_name' => $task_name,
                ':note' => $note,
            ]);
            
            header("Location: dashboard.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/task_modify.css" rel="stylesheet" />
    <link href="./css/footer_staff.css" rel="stylesheet" />

    <title>Modification de tâche</title>
</head>
<body>
    <?php include "./pages/header.php"; ?>

<div class="form-container">
  
    <div class="box">
    <div class="container">
          <h3 class="title">Modification de tâche</h3>
          
    <form method="POST" class="">
    
  
        <input type="hidden" name="task_id" value='<?php echo $task_id ?>' />

        <div class="appart">
        <label for="apartment_number">Numéros de l'appartement :</label>
        <input type="number" name="apartment_number" placeholder="Numéros d'appartement" require></div>

        <div class="name">
        <label for="task_name">Nom de la tâche :</label>
        <input type="text" name="task_name" placeholder="Nom de la tâche à réaliser" require></div>

        <div class="note">
        <label for="note">Note :</label>
        <textarea type="text" name="note" placeholder="Note à ajouter" require></textarea></div>

        <div class="send_buttonn_div">
        <button class="send_button" type="submit" name="submit_form" value='modify'>Envoyer</button></div>

    </form>
    </div>
    </div>
    </div>

<script src="./javascript/header.js"></script>
</body>
</html>
