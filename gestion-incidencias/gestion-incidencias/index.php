<?php
// index.php: según si hay sesión o no, enviamos al panel o al login
require "funciones.php";

if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
} else {
    header("Location: login.php");
}
exit;
