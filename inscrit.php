<?php
session_start();
$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";

try {
    $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['inscription'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $cin = $_POST['cin'];
        $email = $_POST['email'];
        $entreprise = $_POST['entreprise'];
        $adresse = $_POST['adresse'];
        $registre = $_POST['registre'];
        $photo = $_FILES['photo']['name']; 
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $targetDir = "uploads/"; 
        $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);

        $Sql2 = "SELECT * FROM startuper WHERE pseudo = :pseudo OR cin = :cin OR email = :email";
        $Stmt2 = $dbco->prepare($Sql2);
        $Stmt2->bindParam(':pseudo', $pseudo);
        $Stmt2->bindParam(':cin', $cin);
        $Stmt2->bindParam(':email', $email);
        $Stmt2->execute();

        if ($Stmt2->rowCount() > 0) {
            header("Location:  inscription-start.html?error=exists");
            exit();
        } else {





        $sql = "INSERT INTO `startuper`(`nom`, `prenom`, `cin`, `email`, `nom_entreprise`, `adresse_entreprise`, `numero_registre_commerce`, `photo`, `pseudo`, `pwrd`) VALUES(:nom, :prenom, :cin, :email, :nom_entreprise, :adresse_entreprise, :numero_registre_commerce, :photo, :pseudo, :pwrd)";
        $stmt = $dbco->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':cin', $cin);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nom_entreprise', $entreprise);
        $stmt->bindParam(':adresse_entreprise', $adresse);
        $stmt->bindParam(':numero_registre_commerce', $registre);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':pwrd', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
$user_id = $dbco->lastInsertId();
    $_SESSION['user_id'] = $user_id;
  


            header("Location: acceuil-start.html");
            exit();
        }
    }
}
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
