<?php
/**
 * Ejemplo del Principio de Sustitución de Liskov (LSP) en PHP
 * -----------------------------------------------------------
 * El LSP dice: "Las clases hijas deben poder sustituir a las clases padre
 * sin alterar el comportamiento esperado del programa".
 *
 * En este ejemplo, mostramos primero una VIOLACIÓN al LSP,
 * y luego cómo cumplirlo usando interfaces y separación de responsabilidades.
 */

///////////////////////////
// ❌ EJEMPLO QUE VIOLA LSP
///////////////////////////

class Ave {
    public function volar() {
        return "Estoy volando 🐦";
    }
}

class PinguinoMalo extends Ave {
    public function volar() {
        // Un pingüino no puede volar, por lo que lanzamos una excepción
        // Esto rompe el contrato de la clase base (Ave), ya que no cumple su promesa.
        throw new Exception("No puedo volar ❌");
    }
}

// Función que recibe cualquier Ave y la hace volar
function hacerVolarMalo(Ave $ave) {
    echo $ave->volar();
}

// Uso
$ave = new Ave();
hacerVolarMalo($ave); // ✅ "Estoy volando 🐦"

// Esto rompe el programa, ya que un pingüino no puede volar
// y la función asume que sí puede, violando el LSP.
// $pinguino = new PinguinoMalo();
// hacerVolarMalo($pinguino); // ❌ Error


///////////////////////////
// ✅ EJEMPLO QUE CUMPLE LSP
///////////////////////////

/**
 * En vez de asumir que todas las aves pueden volar,
 * separamos el comportamiento en interfaces.
 */
interface Ave {
    public function comer();
}

interface AveVoladora extends Ave {
    public function volar();
}

// Un águila es un ave y además vuela
class Aguila implements AveVoladora {
    public function comer() {
        return "Comiendo como un águila 🦅";
    }

    public function volar() {
        return "Volando alto 🦅";
    }
}

// Un pingüino es un ave, pero NO vuela
class Pinguino implements Ave {
    public function comer() {
        return "Comiendo como un pingüino 🐧";
    }
}

// Función que solo acepta aves voladoras
function hacerVolar(AveVoladora $ave) {
    echo $ave->volar();
}

// Uso correcto
$aguila = new Aguila();
hacerVolar($aguila); // ✅ "Volando alto 🦅"

// El pingüino no se pasa a la función de volar porque no implementa AveVoladora
$pinguino = new Pinguino();
echo $pinguino->comer(); // ✅ "Comiendo como un pingüino 🐧"

/**
 * ✅ Conclusión:
 * Separar los comportamientos evita que las subclases
 * rompan las expectativas de las clases base.
 * Esto mantiene el código coherente y cumple el Principio de Sustitución de Liskov.
 */