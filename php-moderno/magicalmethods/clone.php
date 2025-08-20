<?php

// $array1 = [1, 2, 3];
// $array2 = $array1;
// $array2[0] = 10;
// print_r($array1); // [1, 2, 3]
// print_r($array2); // [10, 2, 3]

class A{
    public string $label;
}

class Some {
    public string $name;
    public A $a;

    public function __clone(){
        $this->name = strtoupper($this->name);
        $this->a = clone $this->a; // Clonación profunda
        // Si A tuviera propiedades que son objetos, también deberíamos clonarlas
        // para evitar referencias compartidas.
    }
}

    function change(Some $some){
        $some->name ="ya no tiene algo se ha cambiado su valor";
    }


    $some = new Some();
    $some->a = new A();
    $some->a->label = "etiqueta";
    $some->name="algo";
    $some2 = $some; // Copia por referencia
    $some2->name = "lo cambio";
    echo $some2->name . "\n"; // Imprime "lo cambio"
    echo $some->name . "\n"; // Imprime "lo cambio"
    change($some);
    echo $some->name . "\n"; // Imprime "ya no tiene algo se ha cambiado su valor"
    echo $some2->name . "\n"; // Imprime "ya no tiene algo


    $newSome = clone $some; // Clonación
    //$newSome->name = "nuevo nombre";
    echo $newSome->name . "\n"; // Imprime "nuevo nombre"
    echo $some->name . "\n"; // Imprime "ya no tiene algo se