<?php 
require_once './include/function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="./css/forgot_password.css">
</head>
<body>
    <h2>Mot de passe oublié</h2>
    <form method="post">
        <label for="email">Email</label>
        <input type="email" placeholder="Votre Email" name="email" required>
        <button type="submit">Envoyer un mot de passe aléatoire</button>
    </form>
</body>
</html>


<?php

if(isset($_POST['email']))  //Envoi un mail d'un mot de passe secondaire
{
    $password = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $message = "Bonjour, </br>Voici votre mot de temps secondaire: $password";
    $headers = 'Content-Type: text/plain; charset="utf-8"'." ";

    if(mail($_POST['email'], 'Mot de passe oublié', $message, $headers))
    {
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$hashedPassword, $_POST['email']]); // Update le mot de passe dans la base de donnée
        echo "Mail envoyé";
    }
    else
    {
        echo "Une erreur est survenue... ";
    }
}
?>