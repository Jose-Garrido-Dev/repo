<?php
// callback es una función que se pasa como argumento a otra función

$numbers = [1, 2, 3];
function processArray(array $data, callable $callback){

    $newArr = [];

    foreach($data as $item){
        $newItem = $callback($item);
        $newArr[] = $newItem;
    }
    return $newArr;
}

$result1 = processArray($numbers, fn($e) => $e * 2);
print_r($result1);
$result2 = processArray($numbers, fn($e) => $e + 10);
print_r($result2);
