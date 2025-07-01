<?php
declare(strict_types=1);

/* vercookies.php -------------------------------------------------- */
function pintar(string $nombre): void
{
    echo isset($_COOKIE[$nombre])
        ? "<h1>{$_COOKIE[$nombre]}</h1>"
        : "<p>No existe la cookie <b>$nombre</b></p>";
}

pintar('micookie');
pintar('unyear');
?>

<a href="crearcookies.php">Crear mis galletas</a> |
<a href="borrarcookies.php">Borrar mis galletas</a>
