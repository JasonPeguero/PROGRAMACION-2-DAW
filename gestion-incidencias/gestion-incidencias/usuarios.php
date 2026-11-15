<?php
require "funciones.php";
// Solo el administrador puede ver esta página
exigir_rol(["Administrador"]);

$usuarios = lista_usuarios();
$incidencias = cargar_incidencias();

// Contamos cuántas incidencias tiene relacionadas cada usuario
function contar_incidencias($incidencias, $nombre) {
    $total = 0;
    foreach ($incidencias as $inc) {
        if ($inc["cliente"] === $nombre || $inc["tecnico"] === $nombre) {
            $total++;
        }
    }
    return $total;
}

mostrar_cabecera("Usuarios");
?>
<h1 class="h3">Usuarios</h1>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <caption class="visually-hidden">Listado de usuarios</caption>
    <thead>
      <tr>
        <th scope="col">Usuario</th>
        <th scope="col">Rol</th>
        <th scope="col">Incidencias relacionadas</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $nombre => $datos): ?>
        <tr>
          <th scope="row"><?= e($nombre) ?></th>
          <td><?= e($datos["rol"]) ?></td>
          <td><?= contar_incidencias($incidencias, $nombre) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php mostrar_pie(); ?>
