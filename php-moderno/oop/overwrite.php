<?php

class Discount{
    protected $discount = 0;

    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    public function getDiscount($price){
        echo "Se aplica descuento<br>";
        return $price * $this->discount;
    }
}

// Sobreescribimos el metodo getDiscount en la clase hija SpecialDiscount
// para cambiar su comportamiento, pero mantenemos la misma firma del metodo
// (mismo nombre y parametros)
// Esto es una sobreescritura de metodo (overriding)
// La clase hija puede acceder a los metodos y propiedades de la clase padre
// usando $this->, y puede llamar al metodo de la clase padre usando parent::nombre
// Si la clase padre tiene un metodo abstracto, la clase hija debe implementarlo
// Si la clase padre tiene un metodo final, la clase hija no puede sobreescribirlo
// Si la clase padre tiene un metodo estatico, la clase hija no puede sobreescribirlo
// Si la clase padre tiene un metodo privado, la clase hija no puede acceder a el
// Si la clase padre tiene un metodo protegido, la clase hija puede acceder a el
// Si la clase padre tiene un metodo publico, la clase hija puede acceder a el
// Si la clase padre tiene un metodo con el mismo nombre que un metodo de la clase hija
class SpecialDiscount extends Discount {
    const SPECIAL_DISCOUNT = 2;

    public function getDiscount($price){
        echo "Se aplica descuento especial<br>";
        return $price * $this->discount * self::SPECIAL_DISCOUNT;
    }

}

$discount = new SpecialDiscount(0.1);
$discountAmount = $discount->getDiscount(100);
echo $discountAmount;