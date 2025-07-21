<?php

$person = new Person();
$person->name = "Juan";
echo $person->name;
echo $person->country;
$person->address = "Calle Falsa 123";

echo time();


class Person{
    public int $id;
    public string $name;
// este metodo se ejecuta cuando se intenta acceder a una propiedad que no existe
    public function __get($name){
        echo "No existe $name en el objeto";
    }
// este metodo se ejecuta cuando se intenta asignar un valor a una propiedad que no existe
    public function __set($name, $value){
        echo "No puedes agregar $value a $name";
    }
}