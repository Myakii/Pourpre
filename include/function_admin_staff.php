<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

// ━━━━━━━━━━━━━━━ ADMIN

function dynamicUserSearchBar($pdo, $searchbar){

    $request_user = $pdo->prepare("
        SELECT id, name, first_name, gender, email, phone_number, role, status
        FROM users
        WHERE name LIKE CONCAT('%', :searchbar, '%')        
        OR first_name LIKE CONCAT('%', :searchbar, '%')
        OR gender LIKE CONCAT('%', :searchbar, '%')
        OR email LIKE CONCAT('%', :searchbar, '%')
        OR phone_number LIKE CONCAT('%', :searchbar, '%')
        OR role LIKE CONCAT('%', :searchbar, '%')
        OR `status` LIKE CONCAT('%', :searchbar, '%');
    
    ");

    $request_user->execute([

        ":searchbar" => $searchbar,

    ]);

    $researchByName = $request_user->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($researchByName as $row){

        $users_id = $row['id'];
        $users_name = $row['name'];
        $users_first_name = $row['first_name'];
        $users_gender = $row['gender'];
        $users_email = $row['email'];
        $users_phone_number = $row['phone_number'];
        $users_role = $row['role'];
        $users_status = $row['status'];

        echo "

        <tr>

            <td class='td_id'> {$users_id} </td>
            <td class='td_name'>{$users_name}</td>
            <td class='td_first_name'>{$users_first_name}</td>
            <td class='td_gender'>{$users_gender}</td>
            <td class='td_email'>{$users_email}</td>
            <td class='td_phone_number'>{$users_phone_number}</td>
            <td class='td_role'>{$users_role}</td>
            <td class='td_status'>{$users_status}</td>

            <td>
            
                <button class='btn-overlay' data-target='overlay{$users_id}'>Information</button>
            
            
            </td>

        </tr>
        
        ";

    }
    
}

function displayUserInformation($pdo){
        
    $request_user_overlay = $pdo->prepare("

        SELECT id, name, first_name, gender, email, phone_number, role, status, avatar
        FROM users
    
    ");
    
    $request_user_overlay->execute();

    $user_overlay_information = $request_user_overlay->fetchAll(PDO::FETCH_ASSOC);

    foreach ($user_overlay_information as $row){

        
        $users_id = $row['id'];
        $users_name = $row['name'];
        $users_first_name = $row['first_name'];
        $users_gender = $row['gender'];
        $users_email = $row['email'];
        $users_phone_number = $row['phone_number'];
        $users_role = $row['role'];
        $users_status = $row['status'];
        $users_avatar = $row['avatar'];

        
        echo "
    
        <div id='overlay{$users_id}' class='overlay'>
            <div class='container'>
                
                <div class='information'>
                    <h1>Profil [{$users_role}]</h1>
                    <img class='svg-ionicons cross' data-target='overlay{$users_id}' src='./assets/svg/close-outline.svg' alt='cross window'>
                    
                </div>
            
                <div class='space-between'>    
                    <div>   
                        <div class='information_display'>
            
                            <h2>Nom :</h2>
                            <h2>{$users_name}</h2>
            
                        </div>
            
                        <div class='information_display'>
            
                            <h2>Prenom :</h2>
                            <h2>{$users_first_name}</h2>
            
                        </div>
            
                        <div class='information_display'>
            
                            <h2>Genre :</h2>
                            <h2>{$users_gender}</h2>
            
                        </div>
            
                        <div class='information_display'>
            
                            <h2>Email :</h2>
                            <h2>{$users_email}</h2>
            
                        </div>
            
                        <div class='information_display'>
            
                            <h2>Num. téléphone :</h2>
                            <h2>{$users_phone_number}</h2>
            
                        </div>
            
            
                        <form method='POST'>
                            <div class='information_display'>
            
                                <h2>Role :</h2>";
                                
                                

                                if($users_role == "Admin"){
                                    
                                    echo "                                
                                        <h2>{$users_role}</h2> 
                                        <input type='hidden' name='role' value='Admin' />
                                    ";

                                } elseif ($users_role == "Client"){

                                    echo"
                                    <select name='role'>
                                    <option>Client</option>
                                    <option>Admin</option>
                                    <option>Employé(e)</option>
                                    </select>
                                    ";

                                } else {

                                    echo "
                                    <select name='role'>
                                    <option>Employé(e)</option>
                                    <option>Client</option>
                                    <option>Admin</option>
                                    </select>
                                    ";
                                }

            
                        echo "</div>
            
                            <div class='information_display'>
            
                                <h2>Status :</h2>
            
                                <select name='status'>";

                                if($users_status == "Active"){

                                    echo"
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    ";

                                } else {

                                    echo"
                                    <option>Inactive</option>
                                    <option>Active</option>                                
                                    ";
                                }


                            echo "</select>
            
                            </div>

                            <button type='submit' id='delete-account-btn' name='delete_account' value='{$users_id}'>Supprimer le compte</button>
                            <button type='submit' id='profil-submit-btn' name='crud_admin_user_id' value='{$users_id}'>Enregistrer les modifications</button>
                        </form>
                        </div>
                        <img src='./assets/{$users_avatar}' class='profile_picture'>
                    </div>
                    
                </div>
        </div>
        
    
    
        ";

        
    }
}

// Changer le rôle 
function submit_crudAdminChange($pdo){

    $new_role = filter_input(INPUT_POST, "role");
    $new_status = filter_input(INPUT_POST, "status");
    $user_id = filter_input(INPUT_POST, "crud_admin_user_id");

    $request_crudAdminUser = $pdo->prepare("
        UPDATE users
        SET role = :new_role, status = :new_status
        WHERE id = :user_id
    
    ");

    $request_crudAdminUser->execute([
        
        ":new_role" => $new_role,
        ":new_status" => $new_status,
        ":user_id" => $user_id,

    ]);
    
    header("Location: crud_admin.php");
    exit();
}   

function admin_mail($pdo, $email_id) {
    $view_mail = $pdo->query("
        SELECT *
        FROM email
        WHERE email_id = :id
    ");

    $view_mail->execute([
        ':id' => $email_id,
    ]);

    $v_mail = $view_mail->fetchAll(PDO::FETCH_ASSOC);

    if ($view_mail->rowCount() > 0) {
        foreach ($v_mail as $row) {
            $v_email = $row['email'];
            $title = $row['title'];
            $date = $row['date'];
        }
    }
}

// Fonction pour la liste d'objective journalière
function days_objective($pdo) {
    echo"
        <p>Veuillez entrer un objectif pour la journée en cours...</p>
    ";
}

// Fonction pour les rdv
function appointment($pdo) {
    echo '
    <div class="appointment">
        <p>8h00 - 9h00  :</p>
        <p>9h30 - 10h30  : RDV avec Mme.Saul </p>
        <p>11h00 - 12h00  :</p>
        <p>12h30 - 13h30  : PAUSE </p>
        <p>14h00 - 15h00  :</p>
    </div>
    ';
}

?>