<?php

require_once './include/function.php';

$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");


if ($methode == "POST"){

    if(isset($_POST['submit_register'])){

        register($pdo);
            

    }

    if(isset($_POST['submit_login'])){

        login($pdo);


    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/identification.css">
    <title>identification</title>
</head>
<body>

    <section>
    
        <?php 
            if(!empty($error_msg)){
                showLoginRegisterErrorMessage($error_msg);
            }
        ?>

        <div class="forms">
            <!-- Connexion -->
            <form class="contact_form" id="login_form" method="POST">
                <div class="icon_home_1">
                    <a href="home.php">
                        <img src="assets/home.svg" id="icon_home">
                    </a>
                </div>

                <div class="logo_header">
                    <a href="home.php">
                        <img src="assets/logo_transparent.svg" />
                    </a>
                </div>

                <h2>Déjà client ? Identifiez vous</h2>
                <div class="option_gender hidden">
                </div>  
                <div class="inputDiv">
                    <input type="text" name="login" placeholder="Adresse e-mail" required>
                </div>

                <div class="inputDiv">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <div class="button">
                    <button type="submit" name="submit_login">Me connecter</button>
                    <button type="button" id="register_button">Inscrivez-vous</button>
                    <div class="forgot_password"> 
                        <a href="forgot_password.php"> Mot de passe oublié ? </a>
                    </div>
                </div>
                
            </form>

            <!-- Création de compte -->
            <form class="contact_form" id="register_form" method="POST">
                <div class="icon_home_2">
                    <a href="home.php">
                        <img src="assets/home.svg" id="icon_home">
                    </a>
                </div>
                
                <div class="logo_header">
                    <a href="home.php">
                        <img src="assets/logo_transparent.svg" />
                    </a>
                </div>

                <h2>Créez votre compte</h2>
                <div class="option_gender">
                    <p>Veuillez remplir tous les champs : </p>
                    <div class="input_gender">
                        <input type="radio" name="gender" id ="radio1" value="Homme" required>
                        <label for="radio1">Homme</label>

                        <input type="radio" name="gender" id ="radio2" value="Femme" required>
                        <label for="radio2">Femme</label>
                    </div>
                </div>  

                <div class="inputDiv">
                    <input id="inputNameField" type="text" name="name" placeholder="Nom">
                    <p id="hidden_name" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p>
                </div>

                <div class="inputDiv">
                    <input id="inputFirstNameField" type="text" name="first_name" placeholder="Prénom">
                    <p id="hidden_first_name" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p>
                </div>

                <div class="inputDiv">
                    <input id="inputEmailField" type="text" name="email" placeholder="Adresse e-mail">
                    <p id="hidden_email" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p>
                </div>

                <div class="inputDiv">
                    <input id="inputPasswordField" type="password" name="password" placeholder="Mot de passe">
                    <p id="hidden_password" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p>
                </div>

                <div class="inputDiv">
                    <input id="inputCPasswordField" type="password" name="cpassword" placeholder="Confirmer votre mot de passe">
                    <p id="hidden_cpassword" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p>
                </div>

                <div class="inputDiv">
                    <input id="inputPhoneField" type="tel" name="phone_number" placeholder="Numéro de téléphone">
                    <p id="hidden_phone_number" class="condition_input_text" style="display: none;">Ce champ est obligatoire</p> 
                </div>

                <div class="button">
                    <button type="submit" name="submit_register">Créer mon compte</button>
                    <button type="button" id="return_button">Retour</button>
                </div>                
            </form>
        </div>
    </section>
    <script src="./javascript/identification.js"></script>
</body>

</html>
