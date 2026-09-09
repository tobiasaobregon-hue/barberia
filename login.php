<?php

session_start();

include("includes/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $consulta = $conexion->prepare(
        "SELECT id, nombre, apellido, password
         FROM usuarios
         WHERE email = ?"
    );

    $consulta->bind_param("s", $email);

    $consulta->execute();

    $resultado = $consulta->get_result();

    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        if (
            password_verify(
                $password,
                $usuario["password"]
            )
        ) {

            $_SESSION["usuario_id"] = $usuario["id"];

            $_SESSION["nombre"] =
                $usuario["nombre"];

            $_SESSION["apellido"] =
                $usuario["apellido"];

            header("Location: index.php");
            exit;

        } else {

            $mensaje = "Contraseña incorrecta.";

        }

    } else {

        $mensaje = "No existe una cuenta con ese email.";

    }

}

include("includes/header.php");

?>


<div class="container mt-5">

    <div class="formulario">

        <h2 class="text-center">
            Iniciar sesión
        </h2>


        <?php if ($mensaje != ""): ?>

            <div class="alert alert-danger">
                <?= htmlspecialchars($mensaje) ?>
            </div>

        <?php endif; ?>


        <form method="POST">

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

                Iniciar sesión

            </button>

        </form>


        <p class="text-center mt-3">

            ¿No tenés cuenta?

            <a href="registro.php">
                Registrate
            </a>

        </p>

    </div>

</div>


<?php include("includes/footer.php"); ?>
