<?php

$entra=true;

if($entra){
    echo "Entro no if";
} else {
    echo "Entrou no else";
}

$age=18;

if($age >= 18){
    echo "Maior de idade";
} elseif($age < 12 || $age > 65){ 
    echo "Menor de idade";
}else{
    echo "Idade entre 12 e 65 anos";
}