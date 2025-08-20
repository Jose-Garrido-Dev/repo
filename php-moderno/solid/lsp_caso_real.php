<?php
declare(strict_types=1);

/**
 * Ejemplo LSP aplicado a un sistema de pagos en PHP
 * -------------------------------------------------
 * Escenario: tenemos distintos métodos de pago (Tarjeta, PayPal, Transferencia, ContraEntrega).
 *
 * 1) Primero mostramos un diseño que VIOLA LSP: una subclase no puede cumplir el contrato
 *    de su clase padre (por ejemplo, "autorizar" no tiene sentido para ContraEntrega),
 *    y termina lanzando excepciones o haciendo "no-ops".
 *
 * 2) Luego mostramos un rediseño que CUMPLE LSP separando capacidades en interfaces:
 *    - Métodos que autorizan/capturan
 *    - Métodos de pago inmediato
 *    - (Opcional) Métodos que soportan reembolsos
 *
 * Moraleja LSP:
 * Las subclases deben poder sustituir a la clase base sin romper expectativas.
 * Si forzamos a todas a cumplir el mismo contrato "grande", habrá casos que no apliquen
 * y romperán el LSP.
 */

/////////////////////////////////////////////
// ❌ 1) Diseño que VIOLA LSP (anti-ejemplo)
/////////////////////////////////////////////

/**
 * Clase base "demasiado amplia": asume que TODOS los métodos de pago
 * pueden autorizar y luego capturar (flujo típico de tarjetas).
 */
abstract class MetodoPagoInflexible
{
    /** Autoriza fondos (por ejemplo, en tarjeta de crédito). */
    public function autorizar(float $monto): string
    {
        // Por defecto lanzamos, esperando que las subclases lo implementen bien.
        // El problema: hay métodos (p.ej. contra-entrega) donde "autorizar" NO tiene sentido.
        throw new \RuntimeException('Este método de pago no implementa autorización.');
    }

    /** Captura los fondos previamente autorizados. */
    public function capturar(string $idAutorizacion, float $monto): string
    {
        throw new \RuntimeException('Este método de pago no implementa captura.');
    }

    /** Reembolsa (refund) una transacción. */
    public function reembolsar(string $idTransaccion, float $monto): string
    {
        throw new \RuntimeException('Este método de pago no implementa reembolso.');
    }
}

/** Implementación para Tarjeta: aquí autorizar/capturar sí tiene sentido. */
class TarjetaCreditoInflexible extends MetodoPagoInflexible
{
    public function autorizar(float $monto): string
    {
        // ... lógica real contra gateway ...
        return 'auth_cc_123';
    }

    public function capturar(string $idAutorizacion, float $monto): string
    {
        // ... lógica real contra gateway ...
        return 'tx_cc_456';
    }

    public function reembolsar(string $idTransaccion, float $monto): string
    {
        // ... lógica real contra gateway ...
        return 'refund_cc_789';
    }
}

/**
 * ContraEntrega (Cash on Delivery): NO puede autorizar/capturar.
 * Si lo forzamos a heredar, terminamos lanzando excepciones => VIOLA LSP.
 */
class ContraEntregaInflexible extends MetodoPagoInflexible
{
    // No tiene sentido autorizar/capturar antes: el cobro es al entregar el paquete.
    // Si alguien usa esta clase donde espera autorizar, romperá el flujo (excepción).
}

/**
 * Un "procesador" que asume que todos los métodos pueden autorizar/capturar.
 * Si le pasamos ContraEntregaInflexible, al llamar a autorizar() rompe todo.
 */
class ProcesadorPagosInflexible
{
    public function cobrar(MetodoPagoInflexible $metodo, float $monto): string
    {
        // Asumimos el flujo AUTORIZAR -> CAPTURAR para todos los métodos
        $authId = $metodo->autorizar($monto);           // ❌ ContraEntrega lanza excepción aquí
        return $metodo->capturar($authId, $monto);
    }
}

// --- DEMO del problema ---
// $procesador = new ProcesadorPagosInflexible();
// $ok = $procesador->cobrar(new TarjetaCreditoInflexible(), 1000); // ✅ funciona
// $boom = $procesador->cobrar(new ContraEntregaInflexible(), 1000); // ❌ excepción => viola LSP


/////////////////////////////////////////////////////////
// ✅ 2) Rediseño que CUMPLE LSP (separación por capacidades)
/////////////////////////////////////////////////////////

/**
 * Contrato base mínimo: cualquier método de pago debe poder "pagar".
 * No imponemos cómo (inmediato, con autorización previa, etc.).
 */
interface MetodoPago
{
    /**
     * Realiza un pago y devuelve un ID de transacción.
     * Todas las implementaciones deben poder hacer esto sin romper expectativas.
     */
    public function pagar(float $monto): string;
}

/**
 * Capacidad adicional: algunos métodos pueden "autorizar" y luego "capturar".
 * (Tarjeta, a veces PayPal/Stripe en ciertos flujos).
 */
interface SoportaAutorizacion
{
    public function autorizar(float $monto): string;
    public function capturar(string $idAutorizacion, float $monto): string;
}

/**
 * Capacidad adicional: algunos métodos permiten reembolsos.
 */
interface SoportaReembolso
{
    public function reembolsar(string $idTransaccion, float $monto): string;
}

/** Tarjeta de crédito: paga con flujo de Autorización/Captura o pago directo. */
class TarjetaCredito implements MetodoPago, SoportaAutorizacion, SoportaReembolso
{
    public function pagar(float $monto): string
    {
        // Implementación simplificada: pago directo (autoriza+captura internas)
        $authId = $this->autorizar($monto);
        return $this->capturar($authId, $monto);
    }

    public function autorizar(float $monto): string
    {
        // ... integrarse con gateway ...
        return 'auth_cc_001';
    }

    public function capturar(string $idAutorizacion, float $monto): string
    {
        // ... integrarse con gateway ...
        return 'tx_cc_002';
    }

    public function reembolsar(string $idTransaccion, float $monto): string
    {
        // ... integrarse con gateway ...
        return 'refund_cc_003';
    }
}

/** Transferencia bancaria: pago inmediato confirmado por comprobante; no autoriza/captura. */
class TransferenciaBancaria implements MetodoPago
{
    public function pagar(float $monto): string
    {
        // ... verificar comprobante/confirmación bancaria ...
        return 'tx_bank_1001';
    }
}

/** Contra Entrega: el "pago" se registra como pendiente y se confirma al entregar. */
class ContraEntrega implements MetodoPago
{
    public function pagar(float $monto): string
    {
        // No hay autorización previa; se registra una orden pendiente de cobro físico.
        return 'order_cod_2001';
    }
}

/**
 * Procesador de pagos que YA NO asume capacidades que no existen.
 * - Para un cobro simple, usa solo MetodoPago::pagar().
 * - Si el flujo requiere autorización, recibe específicamente SoportaAutorizacion.
 * - Si requiere reembolso, exige SoportaReembolso.
 * De esta forma, cada contrato se respeta y NO rompemos LSP.
 */
class ProcesadorPagos
{
    /** Flujo simple que sirve para TODOS los métodos (cumple LSP). */
    public function cobrar(MetodoPago $metodo, float $monto): string
    {
        return $metodo->pagar($monto);
    }

    /** Flujo de dos pasos (solo para métodos que soportan autorización). */
    public function cobrarConAutorizacion(SoportaAutorizacion $metodo, float $monto): string
    {
        $authId = $metodo->autorizar($monto);
        return $metodo->capturar($authId, $monto);
    }

    /** Reembolso (solo métodos que lo soporten). */
    public function reembolsar(SoportaReembolso $metodo, string $txId, float $monto): string
    {
        return $metodo->reembolsar($txId, $monto);
    }
}

// --- DEMO correcto ---
$procesador = new ProcesadorPagos();

$tx1 = $procesador->cobrar(new TransferenciaBancaria(), 5000); // ✅ OK
$tx2 = $procesador->cobrar(new ContraEntrega(), 12000);        // ✅ OK
$tx3 = $procesador->cobrar(new TarjetaCredito(), 10000);       // ✅ OK (pago directo)

$tx4 = $procesador->cobrarConAutorizacion(new TarjetaCredito(), 15000); // ✅ solo tarjeta

// Reembolso solo en métodos que lo soporten
$refund = $procesador->reembolsar(new TarjetaCredito(), 'tx_cc_002', 5000); // ✅ OK

/**
 * ✅ Conclusión (cumpliendo LSP):
 * - El contrato base (MetodoPago) es pequeño y universal: todos pueden "pagar".
 * - Capacidades adicionales (autorizar/capturar, reembolsar) están separadas en interfaces.
 * - El procesador no asume que TODOS pueden todo; pide exactamente lo que necesita.
 * - Cualquier implementación puede sustituir a otra en el contexto de su contrato (LSP).
 */