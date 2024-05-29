<?php
session_start();

 $servname = "localhost"; $dbname = "startupinvest"; $user = "root"; $pass = "";
 
 try{
 $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
 $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 



 if (isset($_POST['login'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM startuper WHERE pseudo = :pseudo AND pwrd = :password";
    $stmt = $dbco->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
         $user = $stmt->fetch(PDO::FETCH_ASSOC);


          $_SESSION['user_id'] = $user['id_startuper'];
        

        header("Location: acceuil-start.html");
        exit();
    } else {
        header("Location: auth-start.html?login_error=true");
            exit();
    }
}}

catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();}
?>