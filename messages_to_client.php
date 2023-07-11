<?php
include_once './include/function_messaging.php';
global $receive_id;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/messages_to_client.css">
    <title>Message aux clients</title>
</head>
<body>

    <?php require_once './pages/header.php' ?>
    <?php display_name_list($pdo); ?>
    <div class="messages_to_client">
        <h3>Messagerie</h3>
        <form class="refresh" method='POST'>
            <input type='text' name='input_message'>
            <input type="hidden" name="cuts_id" value='<?php echo $receive_id ?>'>
            <button type='submit'name='btn_send'>Envoyer</button>
        </form>
        <?php messages_to_client($pdo) ?>
    </div>
    <?php require_once './pages/footer.php' ?>
</body>
<script src="./javascript/header.js"></script>
</html>