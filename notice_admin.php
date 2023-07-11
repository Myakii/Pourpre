<?php 
require_once './include/function_admin.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/notice_admin.css">
    <title>Noticiations - Admin</title>
</head>
<body>
    
    <?php include './pages/header.php' ?>
    <div class="info_notice">
        <h1>Notification</h1>
        <?php notice($pdo);
        new_resa_notice($pdo) ?>
    </div>
    
</body>
<script src="./javascript/header.js"></script>

</html>
