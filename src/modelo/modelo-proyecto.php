<?php
//echo json_encode($_POST);

$accion=$_POST['accion'];
$proyecto=$_POST['proyecto'];

//echo json_encode($_POST);

if ($accion === 'crear') { //crear administradores
    //importar conexion
    include '../funciones/conexion.php';
    try { //Realizar consulta a BD
        //prepare statement
        $statement = $conn->prepare("INSERT INTO proyectos (nombre) VALUES (?)");
        $statement->bind_param('s', $proyecto);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado'=>$statement->insert_id,
                'tipo' => $accion,
                'nombre_proyecto'=>$proyecto
                //'respuesta'=>$statement->affected_rows, //nos dice si se creo algo
                // 'error'=>$statement->error
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }




        $statement->close();
        $conn->close();
    } catch (Exception $e) { //En caso de error tomar la excepcion
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}

?>