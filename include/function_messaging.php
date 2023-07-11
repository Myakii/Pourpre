<?php

require_once './authentification/token.php';
$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", "root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");


if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

// ━━━━━━━━━━━━━━━ MESSAGING
function display_name_list($pdo) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name_list_req = $pdo->prepare("
            SELECT id, name, first_name 
            FROM users
            WHERE role = 'Client'
        ");
        $name_list_req->execute();
        if ($name_list_req->rowCount() > 0) {
            $name_list = $name_list_req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($name_list as $row) {
                $name = $row['name'];
                $first_name = $row['first_name'];
                $client_id = $row['id'];
                echo "
                    <div class='name_list'>
                        <p>{$name} {$first_name}</p>
                        <form action='messages_to_client.php' method='POST'>
                            <input type='hidden' name='client_id' value='{$client_id}'>
                            <button type='submit' name='btn-chat' class='btn_messaging'>Discuter</button>
                        </form>
                    </div>
                ";
            }
        }   
    }
}

function display_admin_list($pdo){
    global $cuts_id;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $admin_list_req = $pdo->prepare("
        
            SELECT id, name, first_name 
            FROM users
            WHERE role = 'Admin'
        
        ");

        $admin_list_req->execute();

        if ($admin_list_req->rowCount() > 0) {

            $admin_list = $admin_list_req->fetchAll(PDO::FETCH_ASSOC);

            foreach ($admin_list as $row){

                $name = $row['name'];
                $first_name = $row['first_name'];
                $admin_id = $row['id'];


                echo"
                
                <div class='name_list'>
                    <h3>{$name} {$first_name}</h3>
                    <form action='messages_to_admin.php' method='POST'>
                        <input type='hidden' name='cuts_id' value='{$admin_id}'>
                        <button type='submit' name='btn-chat' class='btn-chat'>Discuter</button>
                    </form>

                </div>
            
                ";
            }
        }   
    }
}

function messages_to_admin($pdo) {
    global $receive_id;

    $get_id_req = $pdo->prepare("
        
    SELECT id 
    FROM users
    WHERE email = :login

    ");

    $get_id_req->execute([

    ':login' => $_SESSION['login'],

    ]);

    $get_id = $get_id_req->fetch(PDO::FETCH_ASSOC);

    $current_client_id = $get_id['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_send'])){

        $message_content = filter_input(INPUT_POST, "input_message");
        
        $sending_msg_req = $pdo->prepare("
        
        INSERT INTO messages (sender_id, receive_id, message_content)
        VALUE (:current_id, :receive_id, :message_content)
        
        ");

        $sending_msg_req->execute([
            ':current_id' => $current_client_id,
            ':receive_id' => $receive_id,
            ':message_content' => $message_content,
        ]);
    }

    $display_chat_req = $pdo->prepare("

        SELECT u.name, u.first_name, m.message_content, date_insert
        FROM users u
        INNER JOIN messages m
        ON u.id = m.sender_id
        WHERE (m.receive_id = :receive_id
        AND m.sender_id = :current_client_id)
        OR (m.sender_id = :receive_id
        AND m.receive_id = :current_client_id)
        ORDER BY date_insert DESC

    ");

    $display_chat_req->execute([
        ':current_client_id' => $current_client_id,
        ':receive_id' => $receive_id,
    ]);

    $display_chat = $display_chat_req->fetchAll(PDO::FETCH_ASSOC);

    if ($display_chat_req->rowCount() > 0){
        foreach ($display_chat as $row){
            $name = $row['name'];
            $first_name = $row['first_name'];
            $message_content = $row['message_content'];
            $date_insert = $row['date_insert'];

            echo "
                <div class='chat_box'>
                    <h4 class='info_message'>{$date_insert} {$name} {$first_name}</h4>
                    <p class='message_content'>{$message_content}</p>
                </div>
            ";
        }
        
    } else {
        echo "<h4>Aucun message à afficher</h4>";
    }
}

function messages_to_client($pdo) {
    global $receive_id;

    $get_id_req = $pdo->prepare("
        
    SELECT id 
    FROM users
    WHERE email = :login

    ");

    $get_id_req->execute([

    ':login' => $_SESSION['login'], 

    ]);

    $get_id = $get_id_req->fetch(PDO::FETCH_ASSOC);

    $current_admin_id = $get_id['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_send'])){

        $message_content = filter_input(INPUT_POST, "input_message");
        
        $sending_msg_req = $pdo->prepare("
        
        INSERT INTO messages (sender_id, receive_id, message_content)
        VALUE (:current_id, :receive_id, :message_content)
        
        ");

        $sending_msg_req->execute([
            ':current_id' => $current_admin_id,
            ':receive_id' => $receive_id,
            ':message_content' => $message_content,
        ]);
    }

    $display_chat_req = $pdo->prepare("

        SELECT u.name, u.first_name, m.message_content, date_insert
        FROM users u
        INNER JOIN messages m
        ON u.id = m.sender_id
        WHERE ( m.receive_id = :receive_id
        AND m.sender_id = :current_admin_id )
        OR ( m.sender_id = :receive_id
        AND m.receive_id = :current_admin_id )
        ORDER BY date_insert DESC
    ");

    $display_chat_req->execute([
        ':current_admin_id' => $current_admin_id,
        ':receive_id' => $receive_id,
    ]);

    $display_chat = $display_chat_req->fetchAll(PDO::FETCH_ASSOC);

    if ($display_chat_req->rowCount() > 0){
        foreach ($display_chat as $row){
            $name = $row['name'];
            $first_name = $row['first_name'];
            $message_content = $row['message_content'];
            $date_insert = $row['date_insert'];

            echo "
                <div class='chat_box'>
                    <h4 class='info_message'>{$date_insert} {$name} {$first_name}</h4>
                    <p class='message_content'>{$message_content}</p>
                </div>
            ";
        }
        
    } else {
        echo "<h4>Aucun message à afficher</h4>";
    }
}

?>
