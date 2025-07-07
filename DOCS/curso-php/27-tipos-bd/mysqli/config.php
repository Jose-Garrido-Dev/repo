<?php
// ---------- mysqli/config.php ----------

// Abre sesión si no existe
if (session_status() === PHP_SESSION_NONE) session_start();

/* Credenciales */
const DB_HOST = 'localhost';     // Host MySQL
const DB_NAME = 'php-tipos-bd';  // Base
const DB_USER = 'root';          // Usuario
const DB_PASS = '';              // Contraseña

/* Conexión Singleton estilo MySQLi */
function db(): mysqli
{
    static $db = null;                       // Guarda la conexión
    if ($db === null) {                      // Solo conecta una vez
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); // 1. Conecta
        if ($db->connect_errno) {            // 2. Verifica error
            die('Error de conexión: '.$db->connect_error);
        }
        $db->set_charset('utf8mb4');         // 3. Fuerza UTF-8
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // 4. Excepciones
    }
    return $db;                              // 5. Devuelve la instancia
}
