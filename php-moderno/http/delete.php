<?php
header('Content-Type: application/json');

$arr =[
    ["id"=>1, "name"=>"Juan"],
    ["id"=>2, "name"=>"Ana"],
    ["id"=>3, "name"=>"Pedro"]
];

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    extract($_GET);
    if(isset($id)){
        $index = get($id, $arr);
        if($index >=0){
            unset($arr[$index]);
            $arr = array_values($arr); // reindexa el array
            http_response_code(200);
            echo json_encode([
                "message" => "Datos eliminados correctamente",
                "data" => $arr
            ]);
        }
    }else{
        http_response_code(404);
        echo json_encode(['error'=>'Falta el identificador']);
    }
}else{
    http_response_code(400);
    echo json_encode(['error'=>'La solicitud no es de tipo DELETE']);
}

function get(int $id, array $arr){
    for($i=0; $i<count($arr); $i++){
        if($arr[$i]['id'] == $id){
            return $i;
        }
    }
    return -1;
}