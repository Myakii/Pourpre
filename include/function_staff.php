<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

// ━━━━━━━━━━━━━━━ STAFF
// Fonction de création de compte
function register_staff($pdo){
    global $error_msg;


    $name = filter_input(INPUT_POST, "name");
    $first_name = filter_input(INPUT_POST, "first_name");
    $email = filter_input(INPUT_POST, "email");
    $gender = filter_input(INPUT_POST, "gender");
    $password = filter_input(INPUT_POST, "password");
    $phone_number = filter_input(INPUT_POST, "phone_number");
    $cpassword = filter_input(INPUT_POST, "cpassword");
    $role = filter_input(INPUT_POST, "role");

    $lowercase_email = strtolower($email);
    $capitalize_name = ucfirst($name);
    $capitalize_first_name = ucfirst($first_name);

    $check_name = false;
    $check_first_name = false;
    $check_email = false;
    $check_password = false;
    $check_phone_number = false;
    $check_final_submit = false;

    $error_msg = array();

    if(!empty($name)){
        $check_name = true;
    } else {
        array_push($error_msg, "<li>Veuillez insérer un nom</li>");

    }

    if(!empty($first_name)){
        $check_first_name = true;
    } else {

        array_push($error_msg, "<li>Veuillez insérer un prénom</li>");

    }
   

    if(!empty($email)){

        $check_if_existing_email = $pdo->prepare("
            SELECT email
            FROM users_staff
            WHERE email = :form_email
        
        ");

        $check_if_existing_email->execute([

            ":form_email" => $email


        ]);

        $if_existing_email = $check_if_existing_email->fetch(PDO::FETCH_ASSOC);

        if(!empty($if_existing_email)){

            array_push($error_msg, "<li>Ce mail existe déjà, veuillez en choisir un autre</li>");

        } else {

            $check_email = true;

        }


    } else {
        
        array_push($error_msg, "<li>Veuillez insérer un mail</li>");

    }
 
    if(!empty($password)){ 

        if($password === $cpassword){

            $check_password = true;

        } else {

            array_push($error_msg, "<lI>Vos mots de passes ne correspondent pas</li>");

        }
        
    } else {

        array_push($error_msg, "<li>Veuillez insérer un mot de passe</li>");

    }
    
    if(!empty($phone_number)){

        $check_phone_number = true;

    } else {

        array_push($error_msg, "<li>Veuillez insérer un numéro de téléphone</li>");

    }

    if($check_name == true 
    && $check_first_name == true 
    && $check_email == true 
    && $check_password == true 
    && $check_phone_number == true){
        $check_final_submit = true;    
    }

    if($check_final_submit == true){

        $register_request = $pdo->prepare("

            INSERT INTO users_staff (name, first_name, gender, email, password, phone_number, avatar, role, status)
            VALUES (:name, :first_name, :gender, :email, :password, :phone_number, :avatar, :role, :status)
        
        ");

        $register_request->execute([

            ":name" => $capitalize_name,
            ":first_name" => $capitalize_first_name,
            ":gender" => $gender,
            ":email" => $lowercase_email,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
            ":phone_number" => $phone_number,
            ":avatar" => "default_image.png",
            ":role" => "Employé(e)",
            ":status" => "Active",


        ]);   

        $login_request = $pdo->prepare("
            SELECT * 
            FROM users_staff
            WHERE email = :login
        
        ");

        $login_request->execute([

            ":login" => $lowercase_email,

        ]);

        $_SESSION["login"] = $lowercase_email;
        create_token($pdo);
        header("Location: dashboard_staff.php");
        exit();

    } else {

        array_push($error_msg, "<p>Le formulaire n'est pas complété.</p>");

    }

}

// Fonction de connexion
function login_staff($pdo){
    
    global $error_msg;
    
    $login = filter_input(INPUT_POST, "login");
    $password = filter_input(INPUT_POST, "password");

    $login_request = $pdo->prepare("

        SELECT * FROM users_staff
        WHERE email = :login
    
    
    ");

    $login_request->execute([

        ":login" => $login

    ]);

    $users = $login_request->fetch(PDO::FETCH_ASSOC);  
    
    $error_msg = array();

    if(empty($users)){
        array_push($error_msg, "<li>Votre identifiant et/ou votre mot de passe est incorrect</li>");
    } else {

        if (password_verify($password, $users['password'])){

            $_SESSION["id"] = $users['id'];
            $_SESSION["name"] = $users['name'];
            $_SESSION["first_name"] = $users['first_name'];
            $_SESSION["role"] = $users['role'];
            $_SESSION["login"] = $login;
            create_token($pdo);
            header("Location: dashboard_staff.php");
            exit();

        } else {

            array_push($error_msg, "<li>Votre identifiant et/ou votre mot de passe est incorrect</li>");
            

        }
        
    }
}


// Affichage du tableau de bord pour les Staff
function dashboard_staff($pdo, $method) {

    $request_user_information = $pdo->prepare("
        SELECT id, name, first_name, role
        FROM users_staff
        WHERE email = :email
    ");


    $request_user_information->execute([

        ":email" => $_SESSION['login'],

    ]);

    $user_information = $request_user_information->fetch(PDO::FETCH_ASSOC);

    $role = $user_information['role'];

    if ($method == "POST"){

        if(isset($_POST['submit_logout'])){

            logout($pdo);
            

        }
    }

    if ($role == 'Admin'){

        echo "
        
        <form action='dashboard.php' method='POST'>
        <button type='submit'>Ajouter une tâche</button>
        </form>

        ";

    } 
    elseif ($role == 'Employé(e)'){
        
        echo "
        <form action='display_task.php' method='POST'>
        <button type='submit'>Tâches à faire</button>
        </form>
        ";
        
    }
}

function display_staff_notice($pdo){
    if ($_SERVER['REQUEST_METHOD'] = "POST"){

        $display_notice_staff_req = $pdo->prepare("

            SELECT * 
            FROM notice_staff


        ");

        $display_notice_staff_req->execute();

        $display_notice_staff = $display_notice_staff_req->fetchAll(PDO::FETCH_ASSOC);

        foreach ($display_notice_staff as $row){

            $date = $row['date'];
            $house_id = $row['house_id'];

            echo "<div class='staff_notice'>{$date} Une nouvelle tâche vous a été attribué à l'apparement {$house_id}</div>";


        }



    }

}


?>