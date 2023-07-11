<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

function recover($pdo, $method) {
    $request_user_information = $pdo->prepare("
        SELECT id, name, first_name, role
        FROM users
        WHERE email = :email
    ");

    $request_user_information->execute([
        ":email" => $_SESSION['login'],
    ]);

    $user_information = $request_user_information->fetch(PDO::FETCH_ASSOC);
    $role = $user_information['role'];

    if ($method === "POST"){

        if(isset($_POST['submit_logout'])){
            logout($pdo);
        }
    
    }
    
    if ($role == 'Admin'){

        echo "
        <div class='button_task'>
            <form action='task.php' method='POST'>
                <button type='submit'>Ajouter une tâche</button>
            </form>
        </div>
        ";

    } 
    elseif ($role == 'Employé(e)'){
        
        echo "
        <div class='button_task'>
            <form action='display_task.php' method='POST'>
                <button type='submit'>Tâches à faire</button>
            </form>
            </div>
        ";
        
    }
}

function create_task($pdo, $method){
    global $select_display_result;

    // Interdir l'accès via URL
    if ($method == "POST"){

    } else {

        echo "ERROR 500";
        exit();

    }


    if(isset($_POST['submit_form'])){
        
        $method = $_SERVER["REQUEST_METHOD"];

        // Récup des inputs 
        $staff_name = filter_input(INPUT_POST, "staff_name");
        $apartment_number = filter_input(INPUT_POST, "apartment_number");
        $task_name = filter_input(INPUT_POST, "task_name");
        $note = filter_input(INPUT_POST, "note");
        $staff_id = filter_input(INPUT_POST, "staff_id");



        if ($method == "POST" && !empty($task_name)) {
            echo "Votre demandé a bien été enregistré";

            // Lors de la création de task on vas proposer des noms de staff, et avec ces noms
            // Dans la table task, on ne prend pas de nom, mais l'id du staff
            // Donc on vas récuperer l'id dans la table user_staff, et l'inserer dans la table task et l'attribut à staff_id 
            // en passant par un fetch mettre l'id concerné dans une variable
            $request_id = $pdo->prepare("
                
                SELECT name, id
                FROM users_staff
                WHERE name = :staff_name

            ");

            $request_id->execute([

                ':staff_name' => $staff_name,

            ]);

            $result_request_id = $request_id->fetch(PDO::FETCH_ASSOC);

            $user_id = $result_request_id['id'];

            /// L'ID A BIEN ETE RECUPERER, et a été enregistré dans la variable user_id

            

            // Une fois l'id récuperer, on crée la task
            $task_request = $pdo->prepare("
            
                INSERT INTO task (house_id, task_name, note, staff_id)
                VALUE (:apartment_number, :task_name, :note, :id)    
            ");

            


            $task_request->execute([

                ':apartment_number' => $apartment_number,
                ':task_name' => $task_name,
                ':note' => $note,
                ':id' => $user_id

            ]);
            header("Location: dashboard.php");
        }
        
    }


    // Ici on ajoute une condtion pour l'affichage des noms : Si la personne est disponible ou non
    $select_display_request = $pdo->prepare("

    SELECT name, id
    FROM users_staff
    WHERE status = 'Disponible'


    ");

    $select_display_request->execute();

    $select_display_result = $select_display_request->fetchALL(PDO::FETCH_ASSOC);

    if(empty($select_display_result)){

        echo "C'est vide";

    }    
    if (isset($_POST['submit_form'])){

        $notice_task = $pdo->prepare("
            INSERT INTO notice_staff (task_name, house_id, note)
            VALUES (:task_name, :house_id, :note)

        
        ");

        $notice_task->execute([

            ':task_name' => $task_name,
            ':house_id' => $apartment_number,
            ':note' => $note,

        ]);
    }
}

// Fonction de suppression de la tâche
function delete_task($pdo){

    if(isset($_POST['delete_task'])){

        $task_id = $_POST['task_id'];
    
        $delete_task_request = $pdo->prepare("
        
            DELETE FROM task
            WHERE id = :id 
        
        ");
    
        $delete_task_request->execute([
            
            ':id' => $task_id,
    
        ]);
    
    }
}

// Fonction de modification de la tâche [ADMIN]
function update_task($pdo){
}

// Fonction d'affichage des tâches par rapport à l'ID
function display_task($pdo, $user_id){

    

    // Requete affichage de la task : Affiche house_id task_name et note dans la table task, que si l'id 
    // du staff est = à l'id de la session
    $display_task_request = $pdo->prepare("

        SELECT id, house_id, task_name, note, task_status
        FROM task
        WHERE staff_id = :id

    ");

    $display_task_request->execute([

        ':id' => $user_id,  

    ]);

    // Ici on fetch ALL parcequ'il peut y avoir plusieur taches a réaliser par personne
    $current_task = $display_task_request->fetchAll(PDO::FETCH_ASSOC);

    // On check si SQL renvoie bien quelque chose, si oui, on affiche le nom, l'appartement, et la description de la tache
    // Sinon, on echo vous n'avez pas de tache pour le moment
    if ($display_task_request->rowCount() > 0){

        foreach ($current_task as $row){

            $current_task_id= $row['id'];
            $task_status = $row['task_status'];

            echo "
            <div class='place'>
                <div class='task_name'><h3>Nom de la tache : </h3>" . $row['task_name'] . "</h3></div>
                <div class ='house_info'><h4>Appartement numéro :</h4><p>" . $row['house_id'] . "</p></div>
                <div class ='note'><h4>Description de la tache : </h4><p>" . $row['note'] . "<p></div>
                <div class='status'><h4> Status : </h4><p>" .$task_status ."</p></div>
            </div>
            ";

            if ($task_status == "En cours"){
        
                echo "
                <div class='form_task'>
                    <form method='POST'>
                        <input type ='hidden' name='current_task_id' value='{$current_task_id}'>
                        <button class='button_done' type='submit' name='task_done'>Terminé</button>
                    </form> 
                </div>
                ";

                if (isset($_POST['task_done']) && $current_task_id == $_POST['current_task_id']){

                    $done_request = $pdo->prepare("
                    
                        UPDATE task
                        SET task_status = 'Tâche terminé'
                        WHERE id = :current_task_id
            
                    ");
            
                    $done_request->execute([
            
                        ':current_task_id' => $current_task_id,
            
                    ]);
                    
                    echo ' <h4>la tache a bien été terminée</h4>';
                    header("Location: dashboard_staff.php");
                    
                    $notif_done_req = $pdo->prepare("

                    INSERT INTO notice_admin (task_name, house_id, note, type_task)
                    VALUES (:task_name, :house_id, :note, 1)

                    ");


                    $notif_done_req->execute([

                        ':task_name' => $task_name,
                        ':house_id' => $house_id,
                        ':note' => $note,

                    ]);
                    
                }
        
            }
        }
    } else {

        echo "Vous n'avez pas de tâche pour le moment";
    }
 
}

// Fonction d'affichage des taches dans le tableau de bord [ADMIN]
function display_all_task($pdo){

    // Pour cette requete, on vas vouloir afficher les attributs listés dans le SELECT
    // On vas utiliser deux tables : task t, users u
        // Si on met l'initial juste après, ca remplace task par t pour le renommage d'attribut
        // Par exemple au lieu d'écrire task.staff_id qui n'est pas très lisible
        // On vas écrire t.staff_id

    // Pour ce INNER JOIN, on vas join le t.staff_id et le u.id
    // Grace a ce INNER JOIN, on vas pouvoir afficher le nom et prénom de la personne qui fait la tache en question

    // La derniere ligne WHERE n'est pas obligatoire, mais je l'ai mis a cause d'un léger bug SQL 
    // Lié à des id ajouté manuellement pour faire des tests
        

    $display_all_request = $pdo->prepare("

        SELECT t.id, t.staff_id, house_id, task_name, note, u.name, u.first_name
        FROM task t
        INNER JOIN users_staff u
        ON t.staff_id = u.id 
        WHERE role = 'Employé(e)'

    ");

    
    // Execution de la requete
    $display_all_request->execute();

    // On fetch pour recupere les résultats de la requete 
    $display_all = $display_all_request->fetchAll(PDO::FETCH_ASSOC);

    // On check bien si la requete renvoie bien quelque chose
    if ($display_all_request->rowCount() > 0){

        foreach ($display_all as $row) {

            $task_id = $row['id'];
            $staff_id = $row['staff_id'];
            $name = $row['name'];
            $first_name = $row['first_name'];
            $task_name = $row['task_name'];
            $house_id = $row['house_id'];
            $note = $row['note'];


            echo "
                <div class='task_name'>
                    <h4>Nom de la tâche : </h4><p>{$task_name}</p>
                </div>
            
                <div class='house_info'>
                    <h4>Appartement : </h4> <p>{$house_id}</p>
                </div>
            
                <div class='note'>
                    <h4>Description de la tâche : </h4> <p>{$note}</p>
                </div>

                <div class='task_modify'>
                    <form action='task_modify.php' method='POST'>
                        <input type='hidden' name='task_id' value='{$task_id}'>
                        <button type='submit' name='modify' value='btn-modify'>Modifier</button>
                    </form>

                    <form action='dashboard.php' method='POST'>
                        <input type='hidden' name='task_id' value='{$task_id}'>
                        <button type='submit' name='delete_task'>Supprimer</button>
                    </form>
                </div>

                <div class='separator_task'></div>
                ";
        }

    } else {
        echo "Aucune tâche en cours";
    }
    
}



?>