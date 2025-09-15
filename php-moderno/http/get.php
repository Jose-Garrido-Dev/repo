<?php

if( $_SERVER['REQUEST_METHOD'] == 'GET'){
    //echo json_encode($_GET);
    echo $_GET['name'] ?? 'No hay nombre';
}else{
    http_response_code(404);
    echo json_encode(['error'=>'La solicitud no es de tipo GET']);
}


