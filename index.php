<!DOCTYPE html>
<html lang="en">

<?php
include 'src/funciones/sesion.php';
include 'vista/head.php';
include 'src/funciones/funciones.php';
include 'src/funciones/conexion.php';
include 'vista/header.php';

//Obtener el id de la URL
if (isset($_GET['id_proyecto'])) {
    // echo "si";

    $id_proyecto = $_GET['id_proyecto'];
} else {
    // echo "no";
}
?>


<body>

    <div class="contenedor">
        <?php include 'vista/sidebar.php' ?>

        <main class="contenido-principal">
            <?php
            $proyecto = obtenerNombreProyecto($id_proyecto);

            if ($proyecto) : ?>
                <h1>Proyecto:
                    <?php
                    foreach ($proyecto as $nombre) :
                        ?>
                        <span><?php echo $nombre['nombre']; ?></span>

                    <?php endforeach;  ?>
                </h1>

                <form action="#" class="agregar-tarea">
                    <div class="campo">
                        <label for="tarea">Tarea:</label>
                        <input type="text" placeholder="Nombre Tarea" class="nombre-tarea" autofocus="autofocus">
                    </div>
                    <div class="campo enviar">
                        <input type="hidden" value="<?php echo $id_proyecto ?>" id="id_proyecto">
                        <input type="submit" class="boton nueva-tarea" value="Agregar">
                    </div>
                </form>
            <?php
            else : //se le puede poner dos puntos tambien
                //si no hay proyectos seleccionados
                echo "<p>Selecciona un proyecto de la lista de Proyectos</p>";
            endif;
            ?>
            <h2>Listado de tareas:</h2>

            <div class="listado-pendientes">
                <ul>
                    <?php //obtiene las tareas del proyecto actual
                    $tareas = obtenerTareasProyecto($id_proyecto);
/*echo"<pre>";
var_dump($tarea);
echo"</pre>";*/

                    if ($tareas->num_rows > 0) { //si hay tareas //num_rows se fija en la cantidad de tareas que hay
                        foreach ($tareas as $tarea) : ?>
                            <!--<pre><?php //var_dump($tarea); //para recordar de donde viene cada nombre 
                                    ?></pre>-->
                            <li id="tarea:<?php echo $tarea['id'] ?>" class="tarea">
                                <p><?php echo $tarea['nombre'] ?></p>
                                <div class="acciones">
                                    <i class="far fa-check-circle <?php echo($tarea['estado']==='1'?'completo':'')//operador ternario es un if en una sola linea?>"></i>
                                    <i class="fas fa-trash"></i>
                                </div>
                            </li>

                        <?php endforeach;
                    } else { //si no hay tareas
                        echo "<p class='lista-vacia'> No hay tareas aquí </p>";
                    }
                    ?>

                </ul>
            </div>

            <div class="avance">
            <h2>Avance del Proyecto: </h2>
            <div class="barra-avance" id="barra-avance">
            <div class="porcentaje" id="porcentaje">
            </div>
            </div>
            </div>
        </main>
    </div>
    <!--.contenedor-->


    <script src="js/sweetalert2.all.min.js"></script>


</body>
<?php
include 'vista/footer.php'
?>

</html>