<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_projet = $_POST['id_projet'];
$actions_acheter = $_POST['actions_acheter'];

$stmt = $dbco->prepare("SELECT * FROM capital_risque_projet WHERE id_projet = :id_projet AND id_capital_risque = :id_capital_risque");
$stmt->bindParam(':id_projet', $id_projet);
$stmt->bindParam(':id_capital_risque', $_SESSION['user_id']); 
$stmt->execute();
$existe = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existe) {
    $stmt = $dbco->prepare("UPDATE capital_risque_projet SET nombre_actions_achetees = nombre_actions_achetees + :actions_acheter WHERE id_projet = :id_projet AND id_capital_risque = :id_capital_risque");
    $stmt->bindParam(':actions_acheter', $actions_acheter);
    $stmt->bindParam(':id_projet', $id_projet);
    $stmt->bindParam(':id_capital_risque', $_SESSION['user_id']);
    $stmt->execute();
} else {
    $stmt = $dbco->prepare("INSERT INTO capital_risque_projet (id_projet, id_capital_risque, nombre_actions_achetees) VALUES (:id_projet, :id_capital_risque, :actions_acheter)");
    $stmt->bindParam(':id_projet', $id_projet);
    $stmt->bindParam(':id_capital_risque', $_SESSION['user_id']);
    $stmt->bindParam(':actions_acheter', $actions_acheter);
    $stmt->execute();
}

$stmt = $dbco->prepare("UPDATE projet SET nombre_actions_vendues = nombre_actions_vendues + :actions_acheter WHERE id_projet = :id_projet");
$stmt->bindParam(':actions_acheter', $actions_acheter);
$stmt->bindParam(':id_projet', $id_projet);
$stmt->execute();


?>
