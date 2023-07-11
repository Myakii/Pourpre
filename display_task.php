<?php 

include_once './include/function.php';


$get_id_request = $pdo->prepare("
    SELECT id, name, first_name
    FROM users_staff
    WHERE email = :login
");

$get_id_request->execute([
    ':login' => $_SESSION['login']
]);

$result_get_id = $get_id_request->fetch(PDO::FETCH_ASSOC);

$user_id = $result_get_id['id'];
$user_name = $result_get_id['name'];
$user_first_name = $result_get_id['first_name'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâche à faire</title>
</head>
<body>

    <form action ="dashboardStaff.php" method="POST">
        <button type="submit">Retour accueil</button>
    </form>


    <h2>Bonjour <?=$user_first_name . ' ' . $user_name?></h2>

    <h3>Voici vos tâches à faire :</h3>


    <div class='task_information'>
        <?php 

            display_task($pdo, $user_id);

        ?>
    </div>

</body>
</html>









