<?php
// Constantes

const MONEDA            = '€';
const DECIMALES         = 2;
const SEP_DECIMAL       = ',';
const ANCHO_LINEA       = 40;
const MESES_AÑO        = 12;
const PAGAS_MINIMAS     = 12;
const PAGAS_MAXIMAS     = 14;
const PORCENTAJE_MAXIMO = 100;

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function formato(float $valor): string
{
    return number_format($valor, DECIMALES, SEP_DECIMAL) . ' ' . MONEDA;
}

//Validaciones
function validarDatos(
    string $nombre,
    string $categoria,
    ?float $brutoAnual,
    int|false $pagas,
    ?float $retencion,
    ?float $complementos
):  array {
    $errores = [];

    if ($nombre === '') {
        $errores[] = 'El nombre y apellidos son obligatorios.';
    }
    if ($categoria === '') {
        $errores[] = 'La categoría profesional es obligatoria.';
    }
    if ($brutoAnual === null || $brutoAnual <= 0) {
        $errores[] = 'El salario bruto anual es obligatorio';
    }
    if ($pagas === false || $pagas < PAGAS_MINIMAS || $pagas > PAGAS_MAXIMAS) {
        $errores[] = 'El número de pagas debe ser un entero entre ' . PAGAS_MINIMAS . ' y ' . PAGAS_MAXIMAS . '.';
    }
    if ($retencion === null || $retencion <= 0) {
        $errores[] = 'Se debe indicar un porcentaje de retención.';
    }
    if ($retencion > PORCENTAJE_MAXIMO) {
        $errores[] = 'El porcentaje de retención no puede superar el ' . PORCENTAJE_MAXIMO . '%.';
    }

    if ($complementos === null || $complementos < 0) {
        $errores[] = 'Los complementos mensuales deben ser un número igual o mayor que 0.';
    }

    return $errores;
}



// Calculos

function calcularBrutoPaga(float $brutoAnual, int $pagas): float
{
    return $brutoAnual / $pagas;
}

function calcularRetencion(float $brutoPaga, float $porcentaje): float
{
    return $brutoPaga * $porcentaje / PORCENTAJE_MAXIMO;
}


function calcularNeto(float $brutoPaga, float $retencion, float $complementos): float
{
    return $brutoPaga - $retencion + $complementos;
}


function calcularNetoMensual(float $brutoPaga, float $retencion, float $complementos, int $pagas): float
{
    $netoPagaSinComplementos = $brutoPaga - $retencion;

    return ($netoPagaSinComplementos * $pagas / MESES_AÑO) + $complementos;
}






//RESUMEN
function generarResumen(
    string $nombre,
    string $categoria,
    float $brutoAnual,
    int $pagas,
    float $brutoPaga,
    float $retencion,
    float $complementos,
    float $netoPaga,
    float $netoMensual
): string {
    //Hace el resumen como si fuera una array y luego le da saltos de linea para eso se usa el implode.
    return implode("\n", [

        ('RESUMEN SALARIAL'),
        '',
        'Trabajador: ' . $nombre,
        'Categoría: ' . $categoria,
        '',
        ('Bruto anual:' . formato($brutoAnual)),
        ('Número de pagas:' . (string) $pagas),
        ('Bruto por paga:' . formato($brutoPaga)),
        '',
        ('Retención:' . formato($retencion)),
        ('Complementos:' . formato($complementos)),
        '',
        ('Neto estimado (por paga):' . formato($netoPaga)),
        ('Neto mensual:' . formato($netoMensual)),
        
    ]);
}