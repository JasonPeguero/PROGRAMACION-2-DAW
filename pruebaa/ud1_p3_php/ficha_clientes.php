<?php
$txNombre = ($_POST['txNombre']?? '');
$txEmpresa = ($_POST['txEmpresa']?? '');
$txEmail = ($_POST['txEmail']?? '');
$txTelefono = ($_POST['txTelefono']?? '');
$txMotivoConsulta = ($_POST['txMotivoConsulta']?? '');
$txMensaje = ($_POST['txMensaje']?? '');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ficha clientes</title>

    <link rel="stylesheet" href="stilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container-sm mt-5" style="min-width: 50%; max-width: 60%;">
    <h1>ALTA DE CLIENTES</h1>
    <form action="clientes.php" method="post">

        <!-- <input type="hidden" name="enviado" value="<?= $enviado ?>"> -->

        <input type="hidden" class="form-control" id="txAccion" name="txAccion" aria-describedby="nombreCrear"
               value="crearNuevo">

        <div class="mb-3">
            <label for="txNombre" class="form-label is-required">Nombre : </label>
            <input type="text" class="form-control" id="txNombre" name="txNombre" aria-describedby="nombreAyuda"
                   placeholder="Ingresa tu nombre" value="<?= $txNombre?>">
            <!-- Ayuda para el campo de nombre
            <div id="nombreAyuda" class="form-text">Ingresa tu nombre</div> -->
        </div>

        <div class="mb-3">
            <label for="txEmpresa" class="form-label is-required">Empresa : </label>
            <input type="text" class="form-control" id="txEmpresa" name="txEmpresa" aria-describedby="empresaAyuda"
                   placeholder="Ingresa el nombre de tu empresa" value="<?= $txEmpresa?>">
        </div>

        <div class="mb-3">
            <label for="txEmail" class="form-label is-required">Email : </label>
            <input type="text" class="form-control" id="txEmail" name="txEmail" aria-describedby="emailAyuda"
                   placeholder="Ingresa tu email" value="<?= $txEmail?>">
        </div>

        <div class="mb-3">
            <label for="txTelefono" class="form-label is-required">Teléfono : </label>
            <input type="text" class="form-control" id="txTelefono" name="txTelefono" aria-describedby="telefonoAyuda"
                   placeholder="Ingresa tu teléfono" value="<?= $txTelefono?>">
        </div>




        <button type="submit" class="btn btn-warning mb-2">Enviar</button>
        <a href="index.php">
            <button type="button" class="btn btn-danger mb-2">Cancelar</button>
        </a>
    </form>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>