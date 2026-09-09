<?php

session_start();

include("../includes/conexion.php");

if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../login.php");

    exit;

}


$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $categoria = trim($_POST["categoria"]);
    $artista = trim($_POST["artista"]);

    $imagen = "";

    if (
        isset($_FILES["imagen"]) &&
        $_FILES["imagen"]["error"] == 0
    ) {

        $nombreImagen =
            time() . "_" .
            basename($_FILES["imagen"]["name"]);

        $destino =
            "../imagenes/" . $nombreImagen;

        if (
            move_uploaded_file(
                $_FILES["imagen"]["tmp_name"],
                $destino
            )
        ) {

            $imagen = $nombreImagen;

        }

    }


    $consulta = $conexion->prepare(
        "INSERT INTO productos
        (nombre, descripcion, precio, imagen, categoria, artista, usuario_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );


    $consulta->bind_param(
        "ssdsssi",
        $nombre,
        $descripcion,
        $precio,
        $imagen,
        $categoria,
        $artista,
        $_SESSION["usuario_id"]
    );


    if ($consulta->execute()) {

        header("Location: index.php");

        exit;

    } else {

        $mensaje = "Error al publicar el producto.";

    }

}

include("../includes/header.php");

?>


<div class="container">

    <div class="formulario">

        <h2 class="text-center">
            Publicar producto
        </h2>


        <?php if ($mensaje != ""): ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars($mensaje) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            enctype="multipart/form-data">


            <div class="mb-3">

                <label>Nombre del producto</label>

                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Descripción</label>

                <textarea
                    name="descripcion"
                    class="form-control"
                    rows="4"
                    required></textarea>

            </div>


            <div class="mb-3">

                <label>Precio</label>

                <input
                    type="number"
                    step="0.01"
                    name="precio"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Categoría</label>

                <select
                    name="categoria"
                    class="form-control">

                    <option value="Pintura">
                        Pintura
                    </option>

                    <option value="Dibujo">
                        Dibujo
                    </option>

                    <option value="Street Art">
                        Street Art
                    </option>

                    <option value="Materiales">
                        Materiales
                    </option>

                    <option value="Otros">
                        Otros
                    </option>

                </select>

            </div>


            <div class="mb-3">

                <label>Artista</label>

                <input
                    type="text"
                    name="artista"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Imagen</label>

                <input
                    type="file"
                    name="imagen"
                    class="form-control"
                    accept="image/*">

            </div>


            <button
                type="submit"
                class="btn btn-success w-100">

                Publicar

            </button>


        </form>

    </div>

</div>


<?php include("../includes/footer.php"); ?>
