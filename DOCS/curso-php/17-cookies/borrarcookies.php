<?php
declare(strict_types=1);

/* borrar_cookies.php --------------------------------------------- */
$params = ['expires' => time() - 3600, 'path' => '/'];
setcookie('micookie', '', $params);
setcookie('unyear',   '', $params);

header('Location:vercookies.php');
exit;
