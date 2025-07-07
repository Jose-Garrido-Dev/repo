<?php
// ---------- mysqli/funciones.php ----------
require 'config.php';

/* CREATE -------------------------------------------------------------*/
function crearUsuario(string $user, string $pass, string $role='user'): int
{
    $hash = password_hash($pass, PASSWORD_DEFAULT);               // Hash bcrypt
    $stmt = db()->prepare(                                         // Prepara SQL
      'INSERT INTO users(username, passhash, role) VALUES (?, ?, ?)'
    );
    $stmt->bind_param('sss', $user, $hash, $role);                 // Vincula
    $stmt->execute();                                              // Ejecuta
    return $stmt->insert_id;                                       // Devuelve ID
}

/* READ ---------------------------------------------------------------*/
function listarUsuarios(): array
{
    $res = db()->query('SELECT id, username, role FROM users');    // Ejecuta query
    return $res->fetch_all(MYSQLI_ASSOC);                          // Todas las filas
}

/* UPDATE -------------------------------------------------------------*/
function actualizarUsuario(
    int $id,
    ?string $user=null,
    ?string $pass=null,
    ?string $role=null
): bool
{
    $campos = [];          // Columnas SET
    $params = [];          // Valores
    $types  = '';          // Cadena de tipos

    if ($user !== null) { $campos[]='username=?'; $params[]=$user; $types.='s'; }
    if ($pass !== null) { $campos[]='passhash=?'; $params[]=password_hash($pass, PASSWORD_DEFAULT); $types.='s'; }
    if ($role !== null) { $campos[]='role=?';     $params[]=$role; $types.='s'; }

    if (!$campos) return false; // Nada que actualizar

    $sql = 'UPDATE users SET '.implode(', ', $campos).' WHERE id=?'; // SQL dinámico
    $stmt = db()->prepare($sql);      // Prepara
    $params[] = $id;                  // Añade id al final
    $types   .= 'i';                  // Añade tipo int
    $stmt->bind_param($types, ...$params); // Destruye el array en argumentos
    return $stmt->execute();          // Ejecuta
}

/* DELETE -------------------------------------------------------------*/
function borrarUsuario(int $id): bool
{
    $stmt = db()->prepare('DELETE FROM users WHERE id=?'); // Prepara
    $stmt->bind_param('i', $id);                           // Vincula
    return $stmt->execute();                               // Ejecuta
}
