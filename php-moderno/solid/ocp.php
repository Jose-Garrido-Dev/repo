<?php 

// principio abierto cerrado (OCP) ejemplo
// Este tipo de código es un ejemplo de cómo aplicar el principio abierto cerrado (OCP)
// El principio abierto cerrado establece que las clases deben estar abiertas para su extensión, pero cerradas

interface OpInterface{
    public function calculate(float $a, float $b):float;
}


class SumOperation implements OpInterface{
    public function calculate(float $a, float $b): float{
        return $a + $b;
    }
}

class MulOperation implements OpInterface{
    public function calculate(float $a, float $b): float{
        return $a * $b;
    }
}

class SubtractOperation implements OpInterface{
    public function calculate(float $a, float $b): float{
        return $a - $b;
    }
}

class Calculator{
    private OpInterface $op;

    public function __construct(OpInterface $op)
    {
        $this->op = $op;
    }

    public function calculate(float $a, float $b): float
    {
        return $this->op->calculate($a, $b);

    }
}

$sum = new SumOperation();  
$calculator = new Calculator($sum);
echo $calculator->calculate(10, 20) . "<br>"; // 30

$mul = new MulOperation();
$calculator = new Calculator($mul);
echo $calculator->calculate(10, 20) . "<br>"; // 200

$subtract = new SubtractOperation();
$calculator = new Calculator($subtract);
echo $calculator->calculate(20, 10) . "<br>"; // 10