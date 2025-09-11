<?php

//la función array_map permite crear un nuevo array transformado a partir de un array origen
require "modelsArray/people.php";
require "modelsArray/functions.php";

use ModelsArray\People;

$people = [
    new People("Juan", 25),
    new People("Maria", 30),
    new People("Pedro", 35)
];
// mapeo de los nombres
$names = array_map(fn ($person) => $person->name, $people );

show($names);
show($people);

$namesWithFormat = array_map(fn ($person) =>
    "<b>".$person->name."</b>", $people);


show($namesWithFormat);  

show(array_keys($namesWithFormat)); // es para retornar a partir de un  array un array con los elementos id 
$namesWithNumber = array_map(fn ($person, $index) =>
    // ($index+1). " - ".$person->name
  ["id" => ($index +1), "name" => $person->name]
, $people, array_keys($people)
);

//hemos creado un cuerpo dinamicamente de un array , un array desde otro array




show($namesWithNumber);

echo $namesWithNumber[0]["name"];