<?php

function create_token($pdo){
    
    $requete = $pdo->prepare("
        SELECT * FROM users 
        WHERE email = :login
    
    ");
    
    $requete->execute([
    
        ":login" => $_SESSION["login"],
    
    ]);
    

    $users = $requete->fetch(PDO::FETCH_ASSOC);

    $random_token = bin2hex(random_bytes(64));

    $header = json_encode([

        'typ' => 'JWT',
        'alg' => 'HS256'

    ]);
    

    $payload = json_encode([
        
        'users_id' => $users["id"],
        'users_email' => $users["email"],
        'users_first_name' => $users["first_name"],
        'users_last_name' =>$users["name"],
        'gender' => $users["gender"],
        'users_password' => $users["password"],
        'users_phone_numb' => $users["phone_number"],
        'token' => $random_token

    ]);


    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'S4lutc4v43251!', true);

    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
    setcookie("TokenVerification", $jwt, time() + 100000);
    
};

?>