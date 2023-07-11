<?php
    require_once './include/function.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/footer.css" rel="stylesheet" />
    <link href="./css/profil.css" rel="stylesheet" />

    <title>Profil <?php $_SESSION['name'] ?></title>
</head>
<body>
    <?php include "./pages/header.php"; ?>
    
    <div class="user_profil">

        <div class="name_profil">
            <h2>Profil de <?= $_SESSION['first_name'] . " " . $_SESSION['name'] ?> </h2>
        </div>
            <?= profil($pdo) ?>
  
        <div class="users_info">
            <h3>Nom : <?= $_SESSION['name'] ?></h3>
            <h3>Prénom : <?= $_SESSION['first_name'] ?></h3>
            <h3>Genre : <?= $_SESSION['gender'] ?></h3>
            <h3>Numéro de téléphone : <?= $_SESSION['phone_number'] ?></h3>
        </div>
        
        <?= edit_profil($pdo) ?>

    </div>
    
    <?php include "./pages/footer.php"; ?>

</body>
<script src="./javascript/header.js"></script>
<script src="./javascript/preview.js"></script>
</html>