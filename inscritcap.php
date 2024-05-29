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
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];



        $Sql2 = "SELECT * FROM capital_risque WHERE pseudo = :pseudo OR cin = :cin OR email = :email";
        $Stmt2 = $dbco->prepare($Sql2);
        $Stmt2->bindParam(':pseudo', $pseudo);
        $Stmt2->bindParam(':cin', $cin);
        $Stmt2->bindParam(':email', $email);
        $Stmt2->execute();

        if ($Stmt2->rowCount() > 0) {
            header("Location:  inscription-start.html?error=exists");
            exit();
        } else {
        
        $sql = "INSERT INTO `capital_risque`(`nom`, `prenom`, `cin`, `email`, `pseudo`, `pwrd`) VALUES(:nom, :prenom, :cin, :email, :pseudo, :pwrd)";
        $stmt = $dbco->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':cin', $cin);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':pwrd', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

$user_id = $dbco->lastInsertId();
$_SESSION['user_id'] = $user_id;


            header("Location: acceuil-cap.html");
            exit();
        }
    }
}
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
