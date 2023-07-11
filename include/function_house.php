<?php

$pdo = new PDO("mysql:host=localhost:3306; dbname=pourpre", 
"root", "");
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

require_once './authentification/token.php';

if (!isset($_SESSION['started'])) {
    session_start();
    $_SESSION['started'] = true;
}

// ━━━━━━━━━━━━━━━ HOUSE
// Fonction d'ajout des maisons/appartements
function add_house()
{
    global $pdo;
    global $title, $paragraph1, $img, $name_input, $adress, $type, $house, $apart, $room, $postal_code, $description, $option_premium, $status, $open, $close, $price;

    $title = "Ajoutez votre bien !";
    $paragraph1 = "Afficher les détails du biens";
    $img = "Photos";
    $name_input = "Nom du logement";
    $adress = "Adresse";
    $type = "Type de logement";
    $house = "Maison";
    $apart = "Appartement";
    $room = "Nombre de chambres";
    $postal_code = "Code postal";
    $description = "Décrivez en quelques mots votre logement";
    $option_premium = "Option premium";
    $price = "Prix";
    $status = "Disponibilité";
    $open = "Disponible";
    $close = "Indisponible";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si les champs sont remplis
        if (!empty($_POST['name']) && !empty($_POST['adress'])) {
            $name = $_POST['name'];
            $adress = $_POST['adress'];

            // Vérifier si le champ d'img a été renseigné
            // if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
            //     $imgData = file_get_contents($_FILES['img']['tmp_name']);
            // } else {
            //     $imgData = null;
            // }
            $imgData = $_POST['outputBase64'];

            // Vérifier la disponibilité
            if (isset($_POST['Disponible']) && $_POST['Disponible'] == 'Disponible') {
                $available = 'Disponible';
            } else {
                $available = 'Indisponible';
            }

            // Option premium
            if (isset($_POST['option_premium'])) {
                $option_premium = $_POST['option_premium'];
            } else {
                $option_premium = 'Standard';
            }

            // Autres données du formulaire
            $type = $_POST['type'];
            $num_room = $_POST['room'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            // Insertion de données
            $stmt = $pdo->prepare("INSERT INTO House (img, name, adress, type, num_room, postal_code, price, description, option_premium, status) VALUES (:img, :name, :adress, :type, :num_room, :postal_code, :price, :description, :option_premium, :status)");
            $stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':adress', $adress, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':num_room', $num_room, PDO::PARAM_INT);
            $stmt->bindParam(':postal_code', $_POST['postal_code'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':option_premium', $option_premium, PDO::PARAM_STR);
            $stmt->bindParam(':status', $available, PDO::PARAM_STR);
            $stmt->execute();

            // Récupération de l'ID de la nouvelle maison et redirection
            $new_house_id = $pdo->lastInsertId();
            header("Location: house_page.php?id=" . $new_house_id);
            exit();
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }
}

function delete_house($pdo, $house_id) {

    $delete_house_requete = $pdo->prepare("
        DELETE FROM house
        WHERE id = :id
    ");

    $delete_house_requete->execute([
        ':id' => $house_id,
    ]);
}

function delete_house_admin($pdo, $house_id) {
    // Vérification pour les ADMINS
    $stmt_admin = $pdo->prepare("
        SELECT *
        FROM users
        WHERE role = :role
    ");
    $stmt_admin->bindValue(':role', 'Admin');
    $stmt_admin->execute();
    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
    
    if(isset($_SESSION['login']) && ($_SESSION['role'] === "Admin")) {
        echo '
            <form method="POST" action="">
                <input type="hidden" name="house_id" value="' . $house_id . '">
                <input type="submit" name="delete" value="Supprimer"/>
            </form>
        ';
    }
}

// Fonction d'affichage des maisons/appartements selon Id
function get_house_details($pdo, $house_id) {
    $query = "SELECT * FROM house WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$house_id]);
    $house_details = $stmt->fetch(PDO::FETCH_ASSOC);
    return $house_details;
}

function house_64($pdo) {
    $query = "SELECT id, img, name, adress, postal_code FROM house";
    $result = $pdo->query($query);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="grid">';
        foreach($rows as $row) { ?>
            <div class="place">
                <div class="place_image">
                    <h2>
                    <a href="house_page.php?id=<?= $row['id']; ?>">
                        <img src="<?=$row['img']; ?>" alt="<?= $row['name']; ?>">
                    </a> 
                    </h2>
                    </div>
                <div class="place_body"><div class="place-date">
                    <h3>
                        <a href="house_page.php?id=<?=$row['id'];?>"><?=$row['name']; ?></a>
                    </h3></div>
                <div class="place-title"><p><a href="house_page.php?id=<?=$row['id']; ?>"> <?= $row['adress']; ?></a></p></div>
                <div class="place-excerpt"><p><a href="house_page.php?id=<?= $row['id']; ?>"><?= $row['postal_code']; ?></a></p></div>
                </div> 
            </div>
            <?php
        }
    echo '</div>';


    if(isset($_SESSION['login']) && ($_SESSION['role'] === "Admin")) {
        echo '
        <div class="redi_add_house">
            <form action="add_house.php" method="POST">
                <input type="submit" name="add_house" value="Ajouter un bien"/>
            </form> 
        </div>
        ';
    }

    if (isset($_POST['delete'])) {
        $house_id = $_POST['house_id'];
        delete_house($pdo, $house_id);
        header("Location:rental.php");
    }
}

?>