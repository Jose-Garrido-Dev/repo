<?php


echo strtoupper("hola mundo") . "\n";
echo mb_strtoupper("hola Josés") . "\n";
echo strtolower("HOLA MUNDO") . "\n";
// ojo que esta funcion devuelve longitud de bytes
// por lo que si tiene tilde la palabra tendra un registro mas
echo strlen('alejandro');

echo mb_strlen('alejandró') . "\n";

// contador de palabras
echo str_word_count('hola mundo') . "\n";
echo time();
// da un nro aleatorio entre 1 y 10
// ojo que si no le pasamos parametros devuelve un nro entre 0 y getrandmax
// getrandmax() devuelve el maximo numero aleatorio que puede devolver la funcion
// por lo que si no le pasamos parametros el maximo sera 2147483647
echo rand(1,10) . "\n"."<br>";

$date= date('d-m-Y');
echo $date . "\n"."<br>";