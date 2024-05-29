<?php
session_start();

 $servname = "localhost"; $dbname = "startupinvest"; $user = "root"; $pass = "";
 
 try{
 $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
 $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 



 if (isset($_POST['auth'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM capital_risque WHERE pseudo = :pseudo AND pwrd = :password";
    $stmt = $dbco->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

   
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
          $_SESSION['user_id'] = $user['id_capital_risque'];
         
          
        header("Location: acceuil-cap.html");
        exit();
    } else {
        header("Location: auth-cap.html?login_error=true");

        exit();
    }
}}

catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();}
?>