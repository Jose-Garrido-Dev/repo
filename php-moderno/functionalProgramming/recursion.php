<?php

// Función recursiva para calcular el factorial de un número
function factorial($n) {
  if ($n === 0) {
    return 1;
  }
  return $n * factorial($n - 1);
}

echo factorial(5); // 120


echo "<br>";
echo "<br>";

// Función recursiva para calcular el n-ésimo número de Fibonacci
function fibonacci($n) {
  if ($n === 0) {
    return 0;
  }
  if ($n === 1) {
    return 1;
  }
  return fibonacci($n - 1) + fibonacci($n - 2);
}

echo fibonacci(7); // Imprime: 13