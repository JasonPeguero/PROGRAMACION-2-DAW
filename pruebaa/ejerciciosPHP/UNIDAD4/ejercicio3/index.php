<?php
// esto lo que haces es que si hay una sesion iniciada muestra el panel, si no hay sesion iniciada muestra el login
require "funciones.php";

if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
} else {
    header("Location: login.php");
}
exit;
?>