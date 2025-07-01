<?php
// 1) Cadena de conexión (DSN)
//    mysql      → indica al objeto PDO qué driver usar
//    host       → servidor de MySQL (localhost si corres todo en tu PC)
//    dbname     → nombre de la base de datos
//    charset    → codificación; utf8mb4 admite emojis y símbolos
//
// ⛔  IMPORTANTE
//     • No pongas espacios después de cada “;”
//     • Evita guiones ( - ) en el nombre de la BD o
//       cámbialos por “_” (archivos_php).  Los guiones funcionan,
//       pero luego tendrás que escapar la BD con back-ticks en cada consulta.
$dsn = 'mysql:host=localhost;dbname=archivos-php;charset=utf8mb4';

// 2) Credenciales de tu usuario MySQL
$username = 'root';
$password = '';           // En XAMPP suele estar vacío

try {
    // 3) Creamos el objeto PDO
    $pdo = new PDO(
        $dsn,
        $username,
        $password,
        [
            // Modo de error: lanza excepciones (más fácil de depurar)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );

    // 4) (Opcional) mensaje de éxito para pruebas rápidas
    // echo '✅ Conexión OK';

} catch (PDOException $e) {
    // 5) Si algo falla, detenemos el script y mostramos el motivo
    die('Error de conexión: ' . $e->getMessage());
}
