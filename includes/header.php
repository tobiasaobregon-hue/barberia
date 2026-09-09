<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Graft-Point</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="/graft-point/css/estilos.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand fw-bold"
           href="/graft-point/index.php">
            🎨 Graft-Point
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"
                       href="/graft-point/index.php">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/graft-point/productos/index.php">
                        Productos
                    </a>
                </li>

                <?php if (isset($_SESSION["usuario_id"])): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/graft-point/productos/crear.php">
                            Publicar
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/graft-point/cerrar_sesion.php">
                            Cerrar sesión
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/graft-point/login.php">
                            Iniciar sesión
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/graft-point/registro.php">
                            Registrarse
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>
