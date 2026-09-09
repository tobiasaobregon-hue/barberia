<?php

include("../includes/conexion.php");

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


include("../includes/header.php");

?>


<div class="container mt-5">

    <div class="row">

        <div class="col-md-6">

            <?php if (!empty($producto["imagen"])): ?>

                <img
                    src="../imagenes/<?= htmlspecialchars($producto["imagen"]) ?>"
                    class="img-fluid rounded">

            <?php else: ?>

                <div class="p-5 bg-secondary text-white text-center">

                    Sin imagen

                </div>

            <?php endif; ?>

        </div>


        <div class="col-md-6">

            <h1>
                <?= htmlspecialchars($producto["nombre"]) ?>
            </h1>


            <p class="lead">

                <?= htmlspecialchars(
                    $producto["descripcion"]
                ) ?>

            </p>


            <h3>

                $<?= number_format(
                    $producto["precio"],
                    2,
                    ",",
                    "."
                ) ?>

            </h3>


            <p>

                <strong>Categoría:</strong>

                <?= htmlspecialchars(
                    $producto["categoria"]
                ) ?>

            </p>


            <p>

                <strong>Artista:</strong>

                <?= htmlspecialchars(
                    $producto["artista"]
                ) ?>

            </p>


            <button
                class="btn btn-success btn-lg"
                onclick="solicitarProducto()">

                🛒 Solicitar producto

            </button>

        </div>

    </div>

</div>


<?php include("../includes/footer.php"); ?>
