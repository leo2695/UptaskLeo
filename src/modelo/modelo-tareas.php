<?php
//echo json_encode($_POST);

$accion=$_POST['accion'];
$id_proyecto=(int) $_POST['id_proyecto']; //le agrego el (int) para asegurarnos de tener un INT
$tarea=$_POST['tarea'];
$estado=$_POST['estado']; //agrego estado para poder leer que viene en la tarea
//creo una nueva variable porque el id que ocupo para la BD no es el de proyecto
$id_tarea=(int) $_POST['id'];

//echo json_encode($_POST);

if ($accion === 'crear') { //crear administradores
    //importar conexion
    include '../funciones/conexion.php';
    try { //Realizar consulta a BD
        //prepare statement
        $statement = $conn->prepare("INSERT INTO tareas (nombre,id_proyecto) VALUES (?,?)");
        $statement->bind_param('si', $tarea,$id_proyecto);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado'=>$statement->insert_id,
                'tipo' => $accion,
                'tarea'=>$tarea
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

if($accion==='actualizar'){
   // echo json_encode($_POST);

    //importar conexion
    include '../funciones/conexion.php';
    try { //Realizar consulta a BD
        //prepare statement
        $statement = $conn->prepare("UPDATE tareas SET estado=? WHERE id=?");
        $statement->bind_param('ii', $estado,$id_tarea);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $respuesta = array(
                'respuesta' => 'correcto'

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

if($accion==='eliminar'){
    // echo json_encode($_POST);
 
     //importar conexion
     include '../funciones/conexion.php';
     try { //Realizar consulta a BD
         //prepare statement
         $statement = $conn->prepare("DELETE FROM tareas WHERE id=?");
         $statement->bind_param('i',$id_tarea);
         $statement->execute();
 
         if ($statement->affected_rows > 0) {
             $respuesta = array(
                 'respuesta' => 'correcto'
 
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