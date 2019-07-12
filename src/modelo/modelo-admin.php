<?php

//die(json_encode($_POST)); //para asegurarme lo que esta creando

$usuario=$_POST['usuario'];
$password=$_POST['password'];
$accion=$_POST['accion'];

if($accion==='crear'){ //crear administradores
    //hashear passwords
    $opciones=array(
        'cost'=>10 //o 12 mejor 10
    );

    $hash_password=password_hash($password,PASSWORD_BCRYPT,$opciones);

    //importar conexion
    include '../funciones/conexion.php';
    try{ //Realizar consulta a BD
//prepare statement
$statement=$conn->prepare("INSERT INTO usuario (usuario,password) VALUES (?,?)");
$statement->bind_param('ss',$usuario,$hash_password);
$statement->execute();

$respuesta=array(
    'respuesta'=>$statement->affected_rows,
    'error'=>$statement->error
);

$statement->close();
$conn->close();


    }catch(Exception $e){ //En caso de error tomar la excepcion
 $respuesta=array(
     'pass'=>$e->getMessage());
    }
echo json_encode($respuesta);
}

/*$arreglo=array(
'respuesta'=>'Desde Modelo'
);*/

//para asegurarme que los datos estan siendo recibidos en el PHP
//die(json_encode($arreglo)); //die es como un echo

?>