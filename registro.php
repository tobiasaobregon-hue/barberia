<?php

session_start();

include("includes/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (
        empty($nombre) ||
        empty($apellido) ||
        empty($email) ||
        empty($password)
    ) {

        $mensaje = "Completá todos los campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresá un email válido.";

    } else {

        $consulta = $conexion->prepare(
            "SELECT id FROM usuarios WHERE email = ?"
        );

        $consulta->bind_param("s", $email);
        $consulta->execute();

        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {

            $mensaje = "Ese email ya está registrado.";

        } else {

            $password_segura = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $insertar = $conexion->prepare(
                "INSERT INTO usuarios
                (nombre, apellido, email, password)
                VALUES (?, ?, ?, ?)"
            );

            $insertar->bind_param(
                "ssss",
                $nombre,
                $apellido,
                $email,
                $password_segura
            );

            if ($insertar->execute()) {

                header("Location: login.php");
                exit;

            } else {

                $mensaje = "Ocurrió un error al registrarse.";

            }

        }

    }

}

include("includes/header.php");

?>


<div class="container mt-5">

    <div class="formulario">

        <h2 class="text-center">
            Crear cuenta
        </h2>

        <?php if ($mensaje != ""): ?>

            <div class="alert alert-danger">
                <?= htmlspecialchars($mensaje) ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="mb-3">

                <label>Nombre</label>

                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Apellido</label>

                <input
                    type="text"
                    name="apellido"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label>Contraseña</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

            </div>


            <button
                type="submit"
                class="btn btn-primary w-100">

                Registrarme

            </button>

        </form>

    </div>

</div>


<?php include("includes/footer.php"); ?>
