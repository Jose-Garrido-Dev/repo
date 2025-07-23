<?php

class Animal {
    public string $name;
    public int $age;
    public string $color;

    public function __sleep(){
        return ["name", "age", "color"];
    }

    public function __wakeup(){
        echo "Deserializando el objeto...\n" . "<br>";
        $this->age=0;
        $this->some();
    }

    private function some(){
        echo "el color es " . $this->color . "\n" . "<br>";
    }
}

$duck = new Animal();
$duck->name = "Pato";
$duck->age = 2;
$duck->color = "Amarillo";

$s = serialize($duck);
echo $s . "\n" . "<br><br>";

$obj = unserialize($s);
print_r($obj);