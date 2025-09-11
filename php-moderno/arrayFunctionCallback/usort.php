<?php
// esta función esta función permite ordenar un array usando una función de callback
require "modelsArray/people.php";
require "modelsArray/functions.php";
// se agrega el namespace para crear objetos de la clase people
use ModelsArray\People;

$people = [
    new People("Juan", 45),
    new People("Maria", 30),
    new People("Pedro", 35)
];
//operador espacial ahorra 3 ifs en funciones que van a ordenar valores
// echo (1<=>2)."<br>";
// echo (2<=>1)."<br>";
// echo (1<=>1)."<br>";

//menor a mayor
usort($people,
    fn ($person1,$person2)
    => $person1->age <=> $person2->age );


//mayor a menor
    // usort($people,
    // fn ($person1,$person2)
    // => $person2->age <=> $person1->age );


show($people);    