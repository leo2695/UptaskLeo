<!DOCTYPE html>
<html lang="en">

<?php 
include 'vista/head.php'; 
include 'src/funciones/funciones.php';
include 'src/funciones/conexion.php';

session_start();
/*echo "<pre>";
var_dump($_SESSION);
echo "<hr>";
var_dump($_GET);
echo "</pre>";*/

if(isset($_GET['cerrar_sesion'])){
   // echo "Si, presionaste en cerrar";
   $_SESSION=array(); //esto se encarga de cerrar la sesion
}/*else {
    echo "no";
}*/
?>


<body class="login">
    <div class="contenedor-formulario">
        <h1>UpTask</h1>
        <form id="formulario" class="caja-login" method="post">
            <div class="campo">
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="login">
                <input type="submit" class="boton" value="Iniciar Sesión">
            </div>

            <div class="campo">
                <a href="crear-cuenta.php">Crea una cuenta nueva</a>
            </div>
        </form>
    </div>

    <script src="js/sweetalert2.all.min.js"></script>


</body>
<?php 
include 'vista/footer.php'
?>
</html>