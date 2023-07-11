<?php
    require_once './include/function_admin_staff.php';
    require_once './include/function_task.php';

    $stmt = $pdo->query("
        SELECT *
        FROM email
    ");
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $name_email = "De";
    $title = "Objet";
    $date_email = "Date";

    if (isset($_POST['delete_task'])) {
        $task_id = $_POST['task_id'];
        delete_task($pdo); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/header.css" rel="stylesheet" />
    <link href="./css/footer.css" rel="stylesheet" />
    <link href="./css/dashboard.css" rel="stylesheet" />
    <title>Calendrier</title>
</head>
<body>
    <?php include './pages/header.php' ?>
    <div class="all_dashboard">
        <div class="welcome">
            <h2>Bienvenue <?= $_SESSION['name'] . " " . $_SESSION['first_name'] ?> ! </h2>
            <div class="search_glass">
                <img src="assets/search.svg">
            </div>
        </div>

        <div class="daily_task">
                <h2>Planning du jour</h2>
            <div class="liner_title"></div>
            <div class="table_email">
                <table>
                    <tr>
                        <th><?= $name_email ?></th>
                        <th><?= $title ?></th>
                        <th><?= $date_email ?></th>
                    </tr>
                    <?php foreach ($emails as $email) { ?>
                        <tr>
                            <td><?= $email['email']; ?></td>
                            <td><?= $email['title']; ?></td>
                            <td><?= $email['date']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="arrow_more_mail">
                    <a href="mail.php">
                        <img src="assets/arrow-down-circle.svg" id="arrow_more_mail">
                    </a>
                </div>
            </div>
        </div>

        <div class="liner_title"></div>

        <div class="daily_task_second">
            <div class="task_display">
                <h3> Tâches du jour </h3>
                <?= display_all_task($pdo) ?>
                <div class="recover">
                    <?= recover($pdo, $method); ?>
                </div>
            </div>
            <div class="days_objective">
                <h3>Objectif du jour</h3>
                <?= days_objective($pdo) ?>
            </div>
        </div>    
        <div class="table_appointment">
            <h3>Rendez-vous</h3>
                <?= appointment($pdo) ?>
        </div>
    </div>
    <?php include './pages/footer.php'; ?>
</body>
<script src="./javascript/header.js"></script>
<script src="./javascript/dashboard.js"></script>
</html>