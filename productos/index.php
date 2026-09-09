<?php

include("../includes/conexion.php");

include("../includes/header.php");

$buscar = "";

if (isset($_GET["buscar"])) {

    $buscar = trim($_GET["buscar"]);

}

if ($buscar != "") {

    $consulta = $conexion->prepare(
        "SELECT *
         FROM productos
         WHERE nombre LIKE ?
         OR categoria LIKE ?
         OR artista LIKE ?
         ORDER BY id DESC"
    );

    $texto = "%" . $buscar . "%";

    $consulta->bind_param(
        "sss",
        $texto,
        $texto,
        $texto
    );

    $consulta->execute();

    $productos = $consulta->get_result();

} else {

    $productos = $conexion->query(
        "SELECT *
         FROM productos
         ORDER BY id DESC"
    );

}

?>


<div class="container mt-5">

    <div class="text-center">

        <h1>Productos y obras</h1>

        <p>
            Descubrí lo que los artistas tienen para ofrecer.
        </p>

    </div>


    <form
        method="GET"
        class="d-flex mb-5">

        <input
            type="text"
            name="buscar"
            class="form-control me-2"
            placeholder="Buscar producto, categoría o artista..."
            value="<?= htmlspecialchars($buscar) ?>">

        <button
            class="btn btn-primary">

            Buscar

        </button>

    </form>


    <div class="row g-4">

        <?php if ($productos->num_rows > 0): ?>

            <?php while ($producto = $productos->fetch_assoc()): ?>

                <div class="col-md-4">

                    <div class="card producto-card h-100 shadow">


                        <?php if (!empty($producto["imagen"])): ?>

                            <img
                                src="../imagenes/<?= htmlspecialchars($producto["imagen"]) ?>"
                                class="card-img-top"
                                alt="Producto">

                        <?php else: ?>

                            <div
                                class="p-5 text-center bg-secondary text-white">

                                Sin imagen

                            </div>

                        <?php endif; ?>


                        <div class="card-body">

                            <h5 class="card-title">

                                <?= htmlspecialchars(
                                    $producto["nombre"]
                                ) ?>

                            </h5>


                            <p>

                                <?= htmlspecialchars(
                                    $producto["descripcion"]
                                ) ?>

                            </p>


                            <p class="fw-bold">

                                $<?= number_format(
                                    $producto["precio"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </p>


                            <p>

                                🎨
                                <?= htmlspecialchars(
                                    $producto["artista"]
                                ) ?>

                            </p>


                            <a
                                href="ver.php?id=<?= $producto["id"] ?>"
                                class="btn btn-primary">

                                Ver producto

                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="alert alert-info">

                No se encontraron productos.

            </div>

        <?php endif; ?>

    </div>

</div>


<?php include("../includes/footer.php"); ?>
