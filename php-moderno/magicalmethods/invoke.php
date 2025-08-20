<?php

class Add {
    public function __invoke($a, $b){
        return $a + $b;
    }
}

class Validator{
    private int $min;
    private int $max;

    public function __construct(int $min, int $max){
        $this->min = $min;
        $this->max = $max;
    }

    public function __invoke($text){
        $long = strlen($text);

        if($long < $this->min || $long  > $this->max){
            return "false";
        }

        return "Todo bien";
    }
}


$add = new Add();
// echo $add(10, 20) . "\n"; // Invoking the object as

$val = new Validator(5, 20);
echo $val("fgweftwetwe");