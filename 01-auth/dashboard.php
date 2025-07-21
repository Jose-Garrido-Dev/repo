<?php

require 'auth.php';
requiereLogin();

?>

<h1>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h1>
<h2>Tu rol es: <?= $_SESSION['usuario']['rol']?></h2>
<a href="logout.php">Cerrar Sesión</a> 