<?php

// la memorización de funciones es una técnica que consiste en almacenar los resultados de las llamadas a funciones para evitar cálculos repetidos

function add($a, $b){
    return $a + $b;
}


function addMemo(){
    $memo=[];
    return function($a,$b) use(&$memo){ // se le pone & para que $memo sea referenciado
        $index = $a."-".$b;

        if(isset($memo[$index])){
            echo "Ya existia operación <br>";
            return $memo[$index];
        }



        echo "No existia operación <br>";
        $memo[$index] = $a + $b;
        return $memo[$index];

    };
}
// esto se utiliza para evitar cálculos repetidos y almacenar en caché los resultados
$mysum = addMemo();
echo $mysum(4,5)."<br>";
echo $mysum(4,5)."<br>";
echo $mysum(40,52)."<br>";
echo $mysum(40,52)."<br>";