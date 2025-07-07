<?php
// ---------- pdo/delete_user.php ----------
require 'funciones.php'; // Importa las funciones de usuario

$id = (int)($_GET['id'] ?? 0);
if($id && borrarUsuario($id)){
    echo "Usuario $id eliminado correctamente.\n"; // Mensaje de éxito
} else {
    echo "Error al eliminar el usuario $id.\n"; // Mensaje de error
}