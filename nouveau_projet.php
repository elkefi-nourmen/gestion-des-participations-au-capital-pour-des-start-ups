<?php 
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $nb_actions = $_POST['nb_actions'];
    $montant = $_POST['montant'];
    
    // Check si le titre du projet alresdy exists dans le DB
    $stmt = $dbco->prepare("SELECT * FROM projet WHERE titre = :titre");
    $stmt->bindParam(':titre', $titre);
    $stmt->execute();
    $existingProject = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingProject) {
        // il ya un projet avec le meme nom donc affichage d'un message d'erreur 
        $_SESSION['error_message'] = "Projet déja existe!";
        header("Location: projet_start.php");
        exit();
    } else {
        // if le projet n'existe pas alors il l'insere 
        $stmt = $dbco->prepare("INSERT INTO projet (titre, description, nombre_actions_a_vendre, prix_action, id_startuper) VALUES (:titre, :description, :nb_actions, :montant, :id_startuper)");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':nb_actions', $nb_actions);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':id_startuper', $_SESSION['user_id']);
        $stmt->execute();

        // Redirect vers la meme page pour refrecher le table des projets 
        header("Location: projet_start.php");
        exit();
    }
}
?>
