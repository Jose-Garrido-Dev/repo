<?php
header('Content-Type: application/json');


$arr = [
    ["id"=>1, "name"=>"Juan"],
    ["id"=>2, "name"=>"Ana"],
    ["id"=>3, "name"=>"Pedro"]
];

if( $_SERVER['REQUEST_METHOD'] == 'PUT'){
    $json = file_get_contents('php://input');

    $data=json_decode($json);
    extract((array)$data);

    if($data != null && isset($id) && isset($name)){
        $index = get($id, $arr);
            if($index >= 0){
                $arr[$index]['name'] = $name;
                http_response_code(200);
                echo json_encode([
                    "message" => "Datos actualizados correctamente",
                    "data" => $arr[$index]
                ]);
            }else{
                http_response_code(404);
                echo json_encode(['error'=>'No existe el identificador' . $id]);
            }

    }else{
        http_response_code(400);
        echo json_encode(['error'=>'La solicitud no es de tipo PUT']);
    }
}
function get(int $id, array $arr){
    for($i=0; $i<count($arr); $i++){
        if($arr[$i]['id'] == $id){
            return $i;
        }
    }
    return -1;
}