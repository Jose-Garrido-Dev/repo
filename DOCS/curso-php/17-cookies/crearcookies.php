<?php
declare(strict_types=1);

/* crear_cookies.php ----------------------------------------------- */
$unYear = time() + 60 * 60 * 24 * 365;
setcookie('micookie', 'valor de mi galleta', $unYear, '/');
setcookie('unyear',   'valor de 365 días',   $unYear, '/');

/* segunda cookie de ejemplo (opcional para HTTPS en producción) */
setcookie('sesion', bin2hex(random_bytes(16)), [
    'expires'  => time() + 3600,
    'path'     => '/',
    //'domain' => 'midominio.com', // quítalo en local
    'secure'   => false,          // pon true solo bajo https
    'httponly' => true,
    'samesite' => 'Lax',
]);

header('Location:vercookies.php');
exit;