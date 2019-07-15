<?php

//die(json_encode($_POST)); //para asegurarme lo que esta creando
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$accion = $_POST['accion'];

if ($accion === 'crear') { //crear administradores
    //hashear passwords
    $opciones = array(
        'cost' => 10 //o 12 mejor 10
    );

    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

    //importar conexion
    include '../funciones/conexion.php';

    try { //Realizar consulta a BD
        //prepare statement
        $statement = $conn->prepare("INSERT INTO usuario (usuario,password) VALUES (?,?)");
        $statement->bind_param('ss', $usuario, $hash_password);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'tipo' => $accion
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
    echo json_encode($_POST);
}

/*$arreglo=array(
'respuesta'=>'Desde Modelo'
);*/

//para asegurarme que los datos estan siendo recibidos en el PHP
//die(json_encode($arreglo)); //die es como un echo


if ($accion === 'login') { //crear administradores

    //importar conexion
    include '../funciones/conexion.php';
    try { //Seleccionar el administrador de la base de datos

        //Prepare Statements
        $statement = $conn->prepare("SELECT usuario, id, password FROM usuario WHERE usuario=?"); //selecciona esas cosas
        $statement->bind_param('s', $usuario); //pasa el usuario
        $statement->execute();

        //Loggear el usuario
        $statement->bind_result($nombre_usuario, $id_usuario, $pass_usuario); //retorna el usuario, id y password
        $statement->fetch();
        if ($nombre_usuario) {
            //el usuario existe, verificar password
            if (password_verify($password, $pass_usuario)) {
                //Iniciar Sesion
                session_start();
                $_SESSION['nombre']=$usuario;
                
                //Login Correcto
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre'=>$nombre_usuario,
                    'tipo'=>$accion
                );
            } else {
                //Login incorrecto, enviar error
                $respuesta = array(
                    'resultado' => 'Password Incorrecto'
                );
            }

            /*$respuesta=array(
    'respuesta'=>'correcto',
    'nombre'=>$nombre_usuario,
    'pass'=>$pass_usuario
    
    //'respuesta'=>$statement->affected_rows, //nos dice si se creo algo
   // 'error'=>$statement->error
);*/
        } else {
            $respuesta = array(
                'error' => 'Usuario No Existe'
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
