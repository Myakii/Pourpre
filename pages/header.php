<?php

require_once './include/function.php';

$methode = $_SERVER["REQUEST_METHOD"];
connect_or_not($pdo, $methode);

// Permettre au bouton déconnexion de fonctionner
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['logout'])) {
        logout($pdo);
    }
}

?>
<header>
    <div class="bar_header">
        <div class="logo_header">
            <img src="assets/logo_transparent.svg"/>
        </div>

        <div class="profil_img">
            <img src="assets/user.svg" onclick="toggleHiddenDiv()" id="profil_image" type="button">
        </div>

    </div>

    <?php header_role($pdo, $methode); ?>
</header>