<?php
require 'auth.php';
requiereLogin();
requiereRol('admin');

?>

<h2>Area de administración</h2>
<p>Solo los usuarios con rol Administrador pueden ver esto.</p>