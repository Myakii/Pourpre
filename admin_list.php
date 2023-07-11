<?php
require_once './include/function_messaging.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/name_list.css">
    <title>Liste des Admins</title>
</head>
<body>
    <?php require_once './pages/header.php' ?>
    <div class="list_name">
        <h3>Liste des admins</h3>
        <?php display_admin_list($pdo); ?>
    </div>
    <?php require_once './pages/footer.php' ?>
</body>
<script src="./javascript/header.js"></script>

</html>