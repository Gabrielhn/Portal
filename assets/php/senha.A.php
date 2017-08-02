<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once("class.seg.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$conn= new \PDO("oci:host=$host;dbname=$service","PORTAL","aN1G3rp4I#");


$id=$_SESSION['usuarioId'];
$senha=$_POST['senha'];

$query3="UPDATE PO_USUARIOS SET SENHA = :senha WHERE ID=:id";
$stmt3 = $conn->prepare($query3);
$stmt3->bindValue(':senha',$senha);
$stmt3->bindValue(':id',$id); 
$stmt3->execute();
header("Location: ..\..\index.php");


?>
