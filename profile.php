<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbco->prepare("SELECT * FROM startuper WHERE id_startuper = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES['photo']['size'] > 0) {
        $photo = $_FILES['photo']['name'];
        $target = "uploads/" . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        $stmt = $dbco->prepare("UPDATE startuper SET photo = :photo WHERE id_startuper = :id");
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['nom']) && $_POST['nom'] !== $user['nom']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET nom = :nom WHERE id_startuper = :id");
        $stmt->bindParam(':nom', $_POST['nom']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['prenom']) && $_POST['prenom'] !== $user['prenom']) {
        $stmt = $dbco->prepare("UPDATE startuper SET prenom = :prenom WHERE id_startuper = :id");
        $stmt->bindParam(':prenom', $_POST['prenom']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['cin']) && $_POST['cin'] !== $user['cin']) {
        $stmt = $dbco->prepare("UPDATE startuper SET cin = :cin WHERE id_startuper = :id");
        $stmt->bindParam(':cin', $_POST['cin']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['pseudo']) && $_POST['pseudo'] !== $user['pseudo']) {
        $stmt = $dbco->prepare("UPDATE startuper SET pseudo = :pseudo WHERE id_startuper = :id");
        $stmt->bindParam(':pseudo', $_POST['pseudo']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['email']) && $_POST['email'] !== $user['email']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET email = :email WHERE id_startuper = :id");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['nom_entreprise']) && $_POST['nom_entreprise'] !== $user['nom_entreprise']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET nom_entreprise = :email WHERE id_startuper = :id");
        $stmt->bindParam(':nom_entreprise', $_POST['nom_entreprise']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['adresse']) && $_POST['adresse'] !== $user['adresse_entreprise']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET adresse_entreprise = :adresse WHERE id_startuper = :id");
        $stmt->bindParam(':adresse', $_POST['adresse']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['registre']) && $_POST['registre'] !== $user['numero_registre_commerce']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET numero_registre_commerce = :registre WHERE id_startuper = :id");
        $stmt->bindParam(':registre', $_POST['registre']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
    if (!empty($_POST['password']) && $_POST['password'] !== $user['pwrd']) {
       
        $stmt = $dbco->prepare("UPDATE startuper SET pwrd = :password WHERE id_startuper = :id");
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
    }
   
    
}

header("Location: profil_start.php");
?>
