<?php
// ---------- mysqli/delete_user.php ----------
require 'funciones.php';
$id = (int)($_GET['id'] ?? 0);        // Lee id
if ($id && borrarUsuario($id)) {      // Borra
  echo "Eliminado usuario $id";
}
