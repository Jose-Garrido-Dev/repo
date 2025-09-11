<?php

// Ejemplo de inmutabilidad en PHP
function incrementar($numero) {
  return $numero + 1;
}

$valor = 5;
echo incrementar($valor); // Imprime: 6
echo "<br>";
echo $valor; // Imprime: 5 (el valor original no ha cambiado)


class Location{
    private float $x;
    private float $y;

    public function __construct(float $x, float $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): float {
        return $this->x;
    }

    public function getY(): float {
        return $this->y;
    }

    public function move(float $x , float $y): Location{
        $location = new Location($this->x + $x, $this->y + $y);
        return $location;
    }



}

echo "<br>";
$location = new Location(1, 2);



echo $location->getX(); // 1
echo "<br>";
echo $location->getY(); // 2

$newlocation = $location->move(10,20);

echo $newlocation->getX(). " " . $newlocation->getY(). "<br>";