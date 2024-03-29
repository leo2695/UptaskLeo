<!DOCTYPE html>
<html lang="en">

<?php include 'vista/head.php'; 
include 'src/funciones/funciones.php';
include 'src/funciones/conexion.php'?>

<body class="crear-cuenta">

    <div class="contenedor-formulario">
        <h1>UpTask <span>Crear Cuenta</span></h1>
        <form id="formulario" class=" caja-login" method="post">
            <div class="campo">
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="crear">
                <input type="submit" class="boton" value="Crear cuenta">
            </div>
            <div class="campo">
                <a href="login.php">Inicia Sesión Aquí</a>
            </div>
        </form>
    </div>
    <script src="js/sweetalert2.all.min.js"></script>
</body>

<?php 
include 'vista/footer.php'
?>

</html>