<?php

$a=2;

unset($a); //elimina la variable $a

if (isset($a)){
    // echo "La variable \$a está definida\n"."<br>";
} else {
    // echo "La variable \$a no está definida\n"."<br>";
}


$wine = new Wine();
if (isset($wine->country)){
    echo "existe\n"."<br>";
} else {
    echo "La propiedad 'name' de la clase Wine no está definida\n"."<br>";
}

unset($wine->style);

class Wine{

    public $style;

    private $data = [
        'name' => 'Malbec',
        'year' => 2018,
        'country' => 'Argentina'
    ];

    public function __isset($name){
        echo "se comprueba la existencia de $name<br>";
        return isset($this->data[$name]);
    }

    public function __unset($name){
        echo "se intenta elimina la propiedad $name<br>";
    }
}