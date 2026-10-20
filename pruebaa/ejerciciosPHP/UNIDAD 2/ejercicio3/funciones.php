<?php
// Constantes

const MONEDA          = '€';
const DECIMALES       = 2;
const SEP_DECIMAL     = ',';
const PORCENTAJE_BASE = 100;
const ESTADOS         = ['Planificado', 'En desarrollo', 'En pruebas', 'Finalizado'];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function formato(float $valor): string
{
    return number_format($valor, DECIMALES, SEP_DECIMAL) . ' ' . MONEDA;
}

function formatoNumero(float $valor): string
{
    return number_format($valor, DECIMALES, SEP_DECIMAL);
}

// Conversión de tipos

// Devuelve el número o null si el texto no es un número válido (acepta coma decimal)
function convertirNumero(string $texto): ?float
{
    $texto = str_replace(',', '.', $texto);

    return is_numeric($texto) ? (float) $texto : null;
}

// Devuelve el entero o null si el texto no es un entero válido
function convertirEntero(string $texto): ?int
{
    $entero = filter_var($texto, FILTER_VALIDATE_INT);

    return $entero === false ? null : $entero;
}

// Validaciones
function validarDatos(
    string $nombre,
    string $cliente,
    ?int $desarrolladores,
    ?float $horasEstimadas,
    ?float $horasRealizadas,
    ?float $precioHora,
    ?float $presupuesto,
    string $estado
): array {
    $errores = [];

    if ($nombre === '') {
        $errores[] = 'El nombre del proyecto es obligatorio.';
    }
    if ($cliente === '') {
        $errores[] = 'El cliente es obligatorio.';
    }
    if ($desarrolladores === null || $desarrolladores < 1) {
        $errores[] = 'El número de desarrolladores debe ser un entero mayor que 0.';
    }
    if ($horasEstimadas === null || $horasEstimadas <= 0) {
        $errores[] = 'Las horas estimadas deben ser un número mayor que 0.';
    }
    if ($horasRealizadas === null || $horasRealizadas < 0) {
        $errores[] = 'Las horas realizadas deben ser un número igual o mayor que 0.';
    }
    if ($precioHora === null || $precioHora <= 0) {
        $errores[] = 'El precio/hora debe ser un número mayor que 0.';
    }
    if ($presupuesto === null || $presupuesto <= 0) {
        $errores[] = 'El presupuesto máximo debe ser un número mayor que 0.';
    }
    if (!in_array($estado, ESTADOS, true)) {
        $errores[] = 'El estado del proyecto no es válido.';
    }

    return $errores;
}

//Funciones de cálculo
function calcularCoste(float $horas, float $precioHora): float
{
    return $horas * $precioHora;
}

function calcularHorasRestantes(float $horasEstimadas, float $horasRealizadas): float
{
    return $horasEstimadas - $horasRealizadas;
}

function calcularPorcentaje(float $horasRealizadas, float $horasEstimadas): float
{
    return $horasRealizadas / $horasEstimadas * PORCENTAJE_BASE;
}

// Alertas
function comprobarPresupuesto(float $costeActual, float $costeEstimado, float $presupuesto): array
{
    if ($costeActual > $presupuesto) {
        return [
            'tipo'    => 'danger',
            'mensaje' => 'EL PROYECTO HA SUPERADO EL PRESUPUESTO',
        ];
    }

    if ($costeEstimado > $presupuesto) {
        return [
            'tipo'    => 'danger',
            'mensaje' => 'EL COSTE SUPERA EL PRESUPUESTO MÁXIMO',
        ];
    }

    return [
        'tipo'    => 'success',
        'mensaje' => 'PROYECTO DENTRO DEL PRESUPUESTO',
    ];
}

function comprobarHoras(float $horasRealizadas, float $horasEstimadas): ?array
{
    if ($horasRealizadas > $horasEstimadas) {
        return [
            'tipo'    => 'danger',
            'mensaje' => 'LAS HORAS REALIZADAS SUPERAN LAS HORAS ESTIMADAS',
        ];
    }

    return null;
}

// RESUMEN
function generarResumen(
    string $nombre,
    string $cliente,
    int $desarrolladores,
    string $estado,
    float $horasEstimadas,
    float $horasRealizadas,
    float $precioHora,
    float $presupuesto,
    float $costeEstimado,
    float $costeActual,
    float $horasRestantes,
    float $porcentaje
): string {
    // Se hace como un array y se une con saltos de línea mediante implode.
    return implode("\n", [

        'RESUMEN DEL PROYECTO',
        '',
        'Proyecto: ' . $nombre,
        'Cliente: ' . $cliente,
        'Desarrolladores: ' . $desarrolladores,
        'Estado: ' . $estado,
        '',
        'Horas estimadas: ' . formatoNumero($horasEstimadas),
        'Horas realizadas: ' . formatoNumero($horasRealizadas),
        'Horas restantes: ' . formatoNumero($horasRestantes),
        'Porcentaje de ejecución: ' . formatoNumero($porcentaje) . ' %',
        '',
        'Precio/hora: ' . formato($precioHora),
        'Presupuesto máximo: ' . formato($presupuesto),
        'Coste estimado: ' . formato($costeEstimado),
        'Coste actual: ' . formato($costeActual),

    ]);
}