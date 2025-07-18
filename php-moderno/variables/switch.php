<?php

$day = 3;

switch ($day) {
    case 1:
        echo "Domingo";
        break;
    case 2:
        echo "Segunda-feira";
        break;
    case 3:
        echo "Terça-feira";
        break;
    case 4:
        echo "Quarta-feira";
        break;
    case 5:
        echo "Quinta-feira";
        break;
    case 6:
        echo "Sexta-feira";
        break;
    case 7:
        echo "Sábado";
        break;
    default:
        echo "Dia inválido";
}

$month = 2;

switch ($month) {
    case 1:
    case 2:
    case 12:
        echo "es invierno";
        break;
    case 4:  
    case 5:
    case 6:
    case 7:
        echo "es verano";
        break;
    case 8:
        echo "es verano";
        break;

    default:
        echo "Mês inválido";
}