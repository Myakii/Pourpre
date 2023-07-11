<?php

include_once './include/function_messaging.php';
    $receive_id = $_POST['cuts_id'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/messsages_to_admin.css">
    <title>Messagerie - Admin</title>
</head>
<body>

    <?php require_once './pages/header.php' ?>
    <?php display_admin_list($pdo); ?>
    <div class="messages_to_admin">
        <h3>Messagerie</h3>
        <form class="refresh" method='POST'>
            <input type='text' name='input_message'>
            <input type="hidden" name="cuts_id" id="cuts-id" value='<?php echo $receive_id ?>'>
            <button type='submit'name='btn_send'>Envoyer</button>
        </form>
        <?php messages_to_admin($pdo, $receive_id) ?>
    </div>
    <?php require_once './pages/footer.php' ?>
</body>
<script src="./javascript/header.js"></script>
<script src="./javascript/messages-to-admin.js"></script>
</html>