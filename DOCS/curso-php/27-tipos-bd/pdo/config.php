<?php

//Arrancamos la sesion solo si no se ha hecho antes

if(session_status() === PHP_SESSION_NONE) session_start();


/* 🔐 1. Credenciales de la BD (ajusta a tu XAMPP) */
const DB_HOST = 'localhost';    // Servidor MySQL
const DB_NAME = 'php-tipos-bd';
const DB_USER = 'root';         // Usuario
const DB_PASS = '';             // Contraseña


/* ⚙️ 2. Función Singleton que devuelve un objeto PDO */
function pdo(): PDO            // Retorna siempre la misma instancia
{
    static $pdo = null; // Static → persiste entre llamadas

    if($pdo === null){// Solo crea si aún no existe
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4'; // DSN completo
        $pdo = new PDO($dsn, DB_USER, DB_PASS,[ // Conecta
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Obtiene arrays asociativos
            PDO::ATTR_EMULATE_PREPARES => false, // Uso de prepares nativos
        ]);
    }
    return $pdo;   // Devuelve la instancia
}