<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_projet = $_POST['id'];

$stmt = $dbco->prepare("DELETE FROM projet WHERE id_projet = :id_projet");
$stmt->bindParam(':id_projet', $id_projet);
$stmt->execute();

?>
