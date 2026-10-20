<?php
 
// constantes
const MONEDA          = '€';
const DECIMALES       = 2;
const SEP_DECIMAL     = ',';
const ANCHO_LINEA     = 40;
const IVA_MAXIMO      = 100;
const MINIMO_PAGINAS  = 1;
 

function formato(float $valor): string
{
    return number_format($valor, DECIMALES, SEP_DECIMAL) . ' ' . MONEDA;
}
 
$errores     = [];
$presupuesto = null;
$datos = [
    'cliente' => '', 'horas' => '', 'precio' => '',
    'paginas' => '', 'alojamiento' => '', 'iva' => '',
];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $campo => $_) {
        $datos[$campo] = trim((string) ($_POST[$campo] ?? ''));
    }
 
    // Conversión de tipos
    $cliente     = $datos['cliente'];
    $horas       = ($datos['horas']);
    $precio      = ($datos['precio']);
    $paginas     = filter_var($datos['paginas'], FILTER_VALIDATE_INT);
    $alojamiento = ($datos['alojamiento']);
    $iva         = ($datos['iva']);
 
    // Validación
    if ($cliente === '') {
        $errores[] = 'El nombre del cliente es obligatorio.';
    }
    if ($horas === null || $horas <= 0) {
        $errores[] = 'Las horas de desarrollo deben ser un número mayor que 0.';
    }
    if ($precio === null || $precio < 0) {
        $errores[] = 'El precio por hora debe ser un número igual o mayor que 0.';
    }
    if ($paginas === false || $paginas < MINIMO_PAGINAS) {
        $errores[] = 'El número de páginas debe ser un entero de al menos ' . MINIMO_PAGINAS . '.';
    }
    if ($alojamiento === null || $alojamiento < 0) {
        $errores[] = 'El coste de alojamiento debe ser un número igual o mayor que 0.';
    }
    if ($iva === null || $iva < 0 || $iva > IVA_MAXIMO) {
        $errores[] = 'El IVA debe ser un número entre 0 y ' . IVA_MAXIMO . '.';
    }
 
    // Cálculos
    if (empty($errores)) {
        $costeDesarrollo = $horas * $precio;
        $subtotal        = $costeDesarrollo + $alojamiento;
        $importeIva      = $subtotal * $iva / IVA_MAXIMO;
        $total           = $subtotal + $importeIva;

 
        $presupuesto = implode("\n", [
            
            'PRESUPUESTO DE PROYECTO',
            '',
            'Cliente: ' . $cliente,
            'Páginas del sitio web: ' . $paginas,
            '',
            'Horas de desarrollo: ' . $horas,
            'Precio/hora: ' . formato($precio),
            '',
            'Coste desarrollo: ' . formato($costeDesarrollo),
            'Alojamiento: ' . formato($alojamiento),
            '',
            'Subtotal: ' . formato($subtotal),
            'IVA (' . $iva . '%): ' . formato($importeIva), 
            '',
            'TOTAL: ' . formato($total)
        ]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de presupuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm mt-5 mb-5">
    <h1 class="mb-4">Calculadora de presupuestos web</h1>
 
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo ($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
 
    <form method="POST">
        <div class="mb-3">
            <label for="cliente" class="form-label">Nombre del cliente<span>*</span></label>
            <input type="text" class="form-control" id="cliente" name="cliente" value="<?php echo $datos['cliente']; ?>">
        </div>
        <div class="mb-3">
            <label for="horas" class="form-label">Numero de horas de desarrollo<span>*</span></label>
            <input type="text" class="form-control" id="horas" name="horas" value="<?php echo $datos['horas']; ?>">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio por hora<span>*</span></label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $datos['precio']; ?>">
        </div>
        <div class="mb-3">
            <label for="paginas" class="form-label">NUmero de pAginas que tendra el sitio web<span>*</span></label>
            <input type="text" class="form-control" id="paginas" name="paginas" value="<?php echo $datos['paginas']; ?>">
        </div>
        <div class="mb-3">
            <label for="alojamiento" class="form-label">Coste adicional de alojamiento<span>*</span></label>
            <input type="text" class="form-control" id="alojamiento" name="alojamiento" value="<?php echo $datos['alojamiento']; ?>">
        </div>
        <div class="mb-3">
            <label for="iva" class="form-label">Porcentaje de IVA<span>*</span></label>
            <input type="text" class="form-control" id="iva" name="iva" value="<?php echo $datos['iva']; ?>">
        </div>
 
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
 
    <?php if ($presupuesto !== null): ?>
        <pre class="mt-4 p-3 border bg-light"><?php echo htmlspecialchars($presupuesto); ?></pre>
    <?php endif; ?>
</div>
</body>
</html>