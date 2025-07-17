<?php

$host = 'localhost';
$db= 'authPHP';
$user= 'root';
$pass='';
$charset='utf8mb4';

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";

try {
    $pdo= new PDO($dsn,$user, $pass);
}catch(PDOException $e){
    die("Error en la conexion: ".$e->getMessage());
}