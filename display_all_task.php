<?php 

include_once './include/function.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord des tâches</title>
</head>
<body>
    <form action="dashboard.php" method="POST">
        <button type ="submit">Retour à l'acccuel</button>
    </form>
    
    <h2>Tableau de bord</h2>

    <?php if(isset($_POST['delete_task'])){

        echo "La tâche a bién été supprimée";

        delete_task($pdo);
    }
    
    display_all_task($pdo); 

    
    ?>

</body>
</html>