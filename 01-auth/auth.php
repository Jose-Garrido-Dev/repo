<?php
session_start();

//Verificamos si  hay una sesión activa
function requiereLogin(){
    if(!isset($_SESSION['usuario'])){
        header('Location: login.php');
        exit;
    }
}

//Verifica si el rol es admin
function requiereRol($rol){
    if(!isset($_SESSION['usuario']) || $SESSION['usuario']['rol'] !== $rol){
        echo "Acceso Denegado, es solo para $rol";
        exit;
    }
}