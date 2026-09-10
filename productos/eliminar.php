<?php

session_start();

include("../includes/conexion.php");


if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../login.php");

    exit;

}


if (!isset($_GET["id"])) {

    header("Location: index.php");

    exit;

}


$id = intval($_GET["id"]);


$consulta = $conexion->prepare(
    "DELETE FROM productos
     WHERE id = ?"
);

$consulta->bind_param("i", $id);

$consulta->execute();


header("Location: index.php");

exit;

?>
