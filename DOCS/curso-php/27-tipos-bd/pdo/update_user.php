<?php
// ---------- pdo/update_user.php ----------

require 'funciones.php'; // Importa las funciones de usuario
$id = (int)($_GET['id'] ?? 0);

if($id){
    actualizarUsuario($id,'pepe','nueva123');
    echo "Usuario $id actualizado correctamente.\n"; // Mensaje de éxito
} else {
        echo "Nada que actualizar o error en la consulta.";
    }
