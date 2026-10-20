<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <title>ejercicio2</title>
</head>
<body>
    <div class = "container-sm mt-5">
 <form method="GET" action="clientes.php">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre y apellidos</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="mb-3">
            <label for="DNI" class="form-label">DNI/NIE</label>
            <input type="text" class="form-control" id="DNI" name="DNI">
        </div>
        <div class="mb-3">
            <label for="Empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="Empresa" name="Empresa">
        </div>
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="Correo" name="Correo">
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="Telefono" name="Telefono">
        </div>
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion">
        </div>
        <div class="mb-3">
            <label for="CodigoPostal" class="form-label">Código postal</label>
            <input type="number" class="form-control" id="CodigoPostal" name="CodigoPostal">
        </div>
        <div class="mb-3">
            <label for="Ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="Ciudad" name="Ciudad">
        </div>
        <button type="submit" class="btn btn-primary">buscar</button>
        <a href="clientes.php?todos=1" class="btn btn-link">Ver todos los clientes</a>
    </form>
    </div>
</body>
</html>