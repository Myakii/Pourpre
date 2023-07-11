<?php
require_once './include/function_staff.php';
require_once './include/function_task.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/dashboard_staff.css" rel="stylesheet" />
    <link href="./css/footer.css" rel="stylesheet" />
    <title>Tableau de bord - Staff</title>
</head>
<body>
    <?php include "./pages/header.php"; ?>

    <div class="bar_session">
        <h2>Bienvenue <?= $_SESSION['name'] ." " . $_SESSION['first_name'] ?>, bon courage pour la journée ! </h2>
    </div>

    <div class="list_task">
        <h3>Voici vos tâches à faire :</h3>

        <div class='task_information'>
            <?php display_task($pdo, $user_id); ?>
        </div>
    </div>


    <?php include "./pages/footer.php"; ?>

    <script src="./javascript/header.js"></script>
</body>
</html>