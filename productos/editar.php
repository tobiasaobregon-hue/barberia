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
    "SELECT *
     FROM productos
     WHERE id = ?"
);

$consulta->bind_param("i", $id);

$consulta->execute();

$resultado = $consulta->get_result();


if ($resultado->num_rows == 0) {

    die("Producto no encontrado.");

}


$producto = $resultado->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $categoria = trim($_POST["categoria"]);
    $artista = trim($_POST["artista"]);


    $actualizar = $conexion->prepare(
        "UPDATE productos
         SET nombre = ?,
             descripcion = ?,
             precio = ?,
             categoria = ?,
             artista = ?
         WHERE id = ?"
    );


    $actualizar->bind_param(
        "ssdssi",
        $nombre,
        $descripcion,
        $precio,
        $categoria,
        $artista,
        $id
    );


    if ($actualizar->execute()) {

        header("Location: ver.php?id=" . $id);

        exit;

    }

}


include("../includes/header.php");

?>


<div class="container">

    <div class="formulario">

        <h2>Editar producto</h2>


        <form method="POST">

            <div class="mb-3">

                <label>Nombre</label>

                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    value="<?= htmlspecialchars($producto["nombre"]) ?>"
                    required>

            </div>


            <div class="mb-3">

                <label>Descripción</label>

                <textarea
                    name="descripcion"
                    class="form-control"
                    required><?= htmlspecialchars($producto["descripcion"]) ?></textarea>

            </div>


            <div class="mb-3">

                <label>Precio</label>

                <input
                    type="number"
                    step="0.01"
                    name="precio"
                    class="form-control"
                    value="<?= $producto["precio"] ?>"
                    required>

            </div>


            <div class="mb-3">

                <label>Categoría</label>

                <input
                    type="text"
                    name="categoria"
                    class="form-control"
                    value="<?= htmlspecialchars($producto["categoria"]) ?>">

            </div>


            <div class="mb-3">

                <label>Artista</label>

                <input
                    type="text"
                    name="artista"
                    class="form-control"
                    value="<?= htmlspecialchars($producto["artista"]) ?>">

            </div>


            <button
                class="btn btn-primary">

                Guardar cambios

            </button>

        </form>

    </div>

</div>


<?php include("../includes/footer.php"); ?>
