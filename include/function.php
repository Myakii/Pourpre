<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

// ━━━━━━━━━━━━━━━  CLIENT
// Fonction de message Message d'erreur pour le Login
function showLoginRegisterErrorMessage($error_msg)
{

    echo "
    
        <div class='error_message' id='error_message'>
            <div class='display_flex'>
            <h2>Nous avons rencontré le.s problème.s suivant.s :</h2>
            </div>
    ";
    foreach ($error_msg as $list_error) {

        echo $list_error;
    }
    echo "</div>
    
    ";

    unset($error_msg);
}

// Fonction de création de compte
function register($pdo){
    global $error_msg;


    $name = filter_input(INPUT_POST, "name");
    $first_name = filter_input(INPUT_POST, "first_name");
    $email = filter_input(INPUT_POST, "email");
    $gender = filter_input(INPUT_POST, "gender");
    $password = filter_input(INPUT_POST, "password");
    $phone_number = filter_input(INPUT_POST, "phone_number");
    $cpassword = filter_input(INPUT_POST, "cpassword");

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
            FROM users
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

            INSERT INTO users (name, first_name, gender, email, password, phone_number, avatar, role, status)
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
            ":role" => "Client",
            "status" => "Active",

        ]);

        $login_request = $pdo->prepare("
            SELECT * 
            FROM users
            WHERE email = :login
        
        ");

        $login_request->execute([

            ":login" => $lowercase_email,

        ]);

        $user = $login_request->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["login"] = $lowercase_email;
            $_SESSION["id"] = $user['id'];
            $_SESSION["name"] = $user['name'];
            $_SESSION["first_name"] = $user['first_name'];
            $_SESSION["avatar"] = $user['avatar'];
            $_SESSION["phone_number"] = $user['phone_number'];
            $_SESSION["gender"] = $user['gender'];
            $_SESSION["role"] = $user['role'];
            create_token($pdo);
            header("Location: home.php");
            exit();
        }
    } else {

        array_push($error_msg, "<p>Le formulaire n'est pas complété.</p>");

    }

}

// Fonction de connexion
function login($pdo){
    global $error_msg;
    
    $login = filter_input(INPUT_POST, "login");
    $password = filter_input(INPUT_POST, "password");

    $login_request = $pdo->prepare("

        SELECT * 
        FROM users
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

            $_SESSION["login"] = $login;
            $_SESSION["id"] = $users['id'];
            $_SESSION["name"] = $users['name'];
            $_SESSION["first_name"] = $users['first_name'];
            $_SESSION["avatar"] = $users['avatar'];
            $_SESSION["phone_number"] = $users['phone_number'];
            $_SESSION["gender"] = $users['gender'];
            $_SESSION["role"] = $users['role'];
            create_token($pdo);
            if(isset($_SESSION['login']) && ($_SESSION['role'] === "Admin")) {
                header("Location: dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();

        } else {

            array_push($error_msg, "<li>Votre identifiant et/ou votre mot de passe est incorrect</li>");
            

        }
        
    }
}

// Fonction de déconnexion
function logout()
{
    session_start();
    session_destroy();
    header("Location: home.php");
}

function edit_profil($pdo){
    
}

function profil($pdo) {
    $query = $pdo->prepare("
        SELECT *
        FROM users
    ");
    $query->execute();
    $profil = $query->fetch(PDO::FETCH_ASSOC);
    
    echo '
        <div id="desc_img">
            <img src="' . $profil["avatar"] . '">
        </div>
    ';
}

// Pour tous les rôles 
// Ajout d'un DIV selon les rôles
function header_role($pdo){
    // Vérification pour les administrateurs
    $stmt_admin = $pdo->prepare("
        SELECT * 
        FROM users 
        WHERE role = :role
        ");
    $stmt_admin->bindValue(':role', 'Admin');
    $stmt_admin->execute();
    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

    // Vérification pour les employés
    $stmt_staff = $pdo->prepare("
        SELECT * 
        FROM users_staff 
        WHERE role = :role
    ");
    $stmt_staff->bindValue(':role', 'Employé(e)');
    $stmt_staff->execute();
    $staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);


    // Changer le header selon le rôle
    if (isset($_SESSION['login']) && ($_SESSION['role'] === "Admin")) {
        echo '
        <div id="navbar">
            <form action="dashboard.php" method="POST">
                <input type="hidden" name="dashboard.php">
                <button type="submit" class="hover-button-nav">Planning</button>
            </form>
            <form action="rental.php" method="POST">
                <input type="hidden" name="rental">
                <button type="submit" class="hover-button-nav">Appartements</button>
            </form>
            <form action="notice_admin.php" method="POST">
                <input type="hidden" name="notice_admin">
                <button type="submit" class="hover-button-nav">Notifications</button>
            </form>
            <form action="name_list.php" method="POST">
                <input type="hidden" name="name_list">
                <button type="submit" class="hover-button-nav">Messagerie</button>
            </form>
      </div>
      
        ';
    } elseif (isset($_SESSION['login']) && ($_SESSION['role'] === "Employé(e)")) {
        echo '
        <div id="navbar">
            <form action="dashboard_staff.php" method="POST">
                <input type="hidden" name="dashboard_staff">
                <button type="submit" class="hover-button-nav">Planning</button>
            </form>
            <form action="admin_list.php" method="POST">
                <input type="hidden" name="messaging_staff">
                <button type="submit" class="hover-button-nav">Messagerie</button>
            </form>
            <form action="notice_staff.php" method="POST">
                <input type="hidden" name="notice_staff">
                <button type="submit" class="hover-button-nav">Notifications</button>
            </form>
      </div>
      
        ';
    } else {
        echo '
        <div id="navbar">
            <form action="home.php" method="POST">
                <input type="hidden" name="gome">
                <button type="submit" class="hover-button-nav">Home</button>
            </form>
                <form action="rental.php" method="POST">
                <input type="hidden" name="rental">
            <button type="submit" class="hover-button-nav">Séjour</button>
            </form>
            <form action="story.php" method="POST">
                <input type="hidden" name="story">
                <button type="submit" class="hover-button-nav">À propos</button>
            </form>
      </div>
      
        ';
    }
}

// Connecter ou non
function connect_or_not($pdo) {

    // Vérification pour les administrateurs
    $stmt_admin = $pdo->prepare("
        SELECT * 
        FROM users 
        WHERE role = :role
        ");
    $stmt_admin->bindValue(':role', 'Admin');
    $stmt_admin->execute();
    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

    // Vérification pour les employés
    $stmt_staff = $pdo->prepare("
        SELECT * 
        FROM users_staff 
        WHERE role = :role
    ");
    $stmt_staff->bindValue(':role', 'Employé(e)');
    $stmt_staff->execute();
    $staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);


    if (isset($_SESSION['login']) AND ($_SESSION['role'] === "Admin")) {
        echo '
        <div class="below_div hidden_div">
                <form action="profil.php" method="POST">
                    <input type="hidden" class="button_header" name="profil">
                    <button type="submit">Profil</button>
                </form>  
                
                <form action="" method="POST">
                    <input type="hidden" name="logout" value="true">
                    <button type="submit">Déconnexion</button>
                </form>
        </div>
        ';
    } elseif (isset($_SESSION['login']) AND ($_SESSION['role'] === "Employé(e)")) {
        echo '
        <div class="below_div hidden_div">
            <ul>
                <form action="profil_staff.php" method="POST">
                    <input type="hidden" class="button_header" name="profil">
                    <button type="submit">Profil</button>
                </form>  
                <form action="" method="POST">
                    <input type="hidden" class="button_header" name="logout" value="true">
                    <button type="submit">Déconnexion</button>
                </form>
            </ul>
        </div>
        ';
    } elseif (isset($_SESSION['login']) AND ($_SESSION['role'] === "Client")) {
        echo '
        <div class="below_div hidden_div">
            <form action="profil.php" method="POST">
                <input type="hidden" class="button_header" name="profil">
                <button type="submit">Profil</button>
            </form>
            <form action="admin_list.php" method="POST">
                <input type="hidden" class="button_header" name="messaging">
                <button type="submit">Messagerie</button>
            </form>
            <form action="notice.php" method="POST">
                <input type="hidden" class="button_header" name="notice">
                <button type="submit">Notifications</button>
            </form>
            <form action="help.php" method="POST">
                <input type="hidden" class="button_header" name="help">
                <button type="submit">Aide</button>
            </form>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button type="submit">Déconnexion</button>
            </form>
        </div>
      
        ';
    } else {
        echo '
        <div class="below_div hidden_div">
            <ul>
                <form action="help.php" method="POST">
                    <input type="hidden" class="button_header" name="help">
                    <button type="submit">Aide</button>
                </form>
        
                <form action="identification.php" method="POST">
                    <input type="hidden" class="button_header" name="login" value="true">
                    <button type="submit">Connexion</button>
                </form>
            </ul>
        </div>
        ';
    }
}

function slide_asc($pdo) {
    $query = "
        SELECT img 
        FROM house 
        ORDER BY number_reservation 
        ASC LIMIT 3
    ";
    $result = $pdo->query($query);
    $houseImages = $result->fetchAll(PDO::FETCH_COLUMN);
    return $houseImages;
}

