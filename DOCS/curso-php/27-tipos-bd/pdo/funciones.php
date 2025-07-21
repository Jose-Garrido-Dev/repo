<?php
// ---------- pdo/funciones.php ----------
require 'config.php'; // Importa la función pdo() y la sesión

/* ──────────────────────────────
 |  CREATE: insertar usuario
 ──────────────────────────────*/

 function crearUsuario(String $user, string $pass, string $role="user"):int
 {
    $hash  = password_hash($pass, PASSWORD_DEFAULT); // Genera bcrypt
    $sql= 'INSERT INTO users(username, passhash, role)
            VALUES(:u,:h,:r)';    //marcadores nombrados

    pdo()->prepare($sql)->execute([
        ':u'=> $user,
        ':h'=> $hash,
        ':r' => $role
    ]);    
    
    return (int) pdo()->lastInsertId(); // Devuelve el ID generado
 }

 /* ──────────────────────────────
 |  READ: listar usuarios
 ──────────────────────────────*/

 function listarUsuarios():array
 {
    $sql = 'SELECT id, username,role FROM users'; // query simple
    return pdo()->query($sql)->fetchAll();// devuelve todas las filas

 }

/* ──────────────────────────────
 |  UPDATE: actualizar usuario
 ──────────────────────────────*/

 function actualizarUsuario(
   int $id,
    ?string $user = null,
    ?string $pass = null,
    ?string $role = null
): bool
{
    /* 1. Construimos dinámicamente las columnas a tocar */
    $campos = [];                    // Lista "columna=:param"
    $params = [':id' => $id];        // Siempre tendremos al menos el id

    if ($user !== null) {            // Si viene username
        $campos[]          = 'username = :u';
        $params[':u']      = $user;
    }

    if ($pass !== null) {            // Si viene contraseña
        $campos[]          = 'passhash = :h';
        $params[':h']      = password_hash($pass, PASSWORD_DEFAULT);
    }

    if ($role !== null) {            // Si viene rol
        $campos[]          = 'role = :r';
        $params[':r']      = $role;
    }

    /* 2. Si no se pasó ningún campo, no hacemos nada */
    if (!$campos) return false;

    /* 3. Unimos las columnas y armamos la consulta. OJO al espacio antes de WHERE */
    $sql = 'UPDATE users SET '.implode(', ', $campos).' WHERE id = :id';
    echo $sql.PHP_EOL;
    var_dump($params);
    /* 4. Ejecutamos y devolvemos true/false */
    return pdo()->prepare($sql)->execute($params);
 }

 /* ──────────────────────────────
 |  DELETE: borrar usuario
 ──────────────────────────────*/

function borrarUsuario(int $id): bool
{
    $sql = 'DELETE FROM users WHERE id=?';
    return pdo()->prepare($sql)->execute([$id]); // Ejecuta y devuelve true or false
}



