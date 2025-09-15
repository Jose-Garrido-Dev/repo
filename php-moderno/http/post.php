<?php

header('Content-Type: application/json');
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    // esta es una solicitud POST y con la funcion file_get_contents puedo leer el cuerpo de la solicitud
    //echo file_get_contents('php://input');


    $json = file_get_contents('php://input');
    $data = json_decode($json); // si quieres que sea un array, agrega true como segundo parametro     $data = json_decode($json, true);
    // echo $data->name;
    // echo "\n";

    extract((array)$data); // extrae las variables del objeto json y las transforma en un array asociativo
    // ahora puedo usar las variables directamente
    echo $name;
    http_response_code(201);
    echo json_encode([
        "message" => "Datos recibidos correctamente",
        "data" => $data
    ]);
}else{
    http_response_code(404);
    echo json_encode(['error'=>'La solicitud no es de tipo POST']);
}


