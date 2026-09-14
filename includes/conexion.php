<?php

$servidor = "sql200.infinityfree.com";
$usuario = "if0_42918116";
$password = "dHk3GpHhEMKQ7B";
$base_datos = "if0_42918116_XXX";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

?>
