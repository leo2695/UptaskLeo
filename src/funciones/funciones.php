<?php
//obtiene la pagina actual que se ejecuta
function obtenerPaginaActual()
{ //este metodo es como para ponerlo en el class= para que tome el estilo de la pagina en que este
    $archivo = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace(".php", "", $archivo);
    return $pagina;
}

//CONSULTAS

//Obtener todos los proyectos
function obtenerProyectos()
{
    include 'conexion.php';
    try {
        return $conn->query('SELECT id, nombre FROM proyectos'); 
     }catch(Exception $e){
         echo"Error: ".$e->getMessage();
        return false;
    }
}

//Obtener el nombre del proyecto
function obtenerNombreProyecto($id=null){ //tiene que recibir un id pero en caso de que no se le pasara mejor ponemos null
include 'conexion.php';

try {
return $conn->query("SELECT nombre FROM proyectos WHERE id={$id}"); //aqui utilizo comillas dibles "" para poder inyectar js
 }catch(Exception $e){
     echo"Error: ".$e->getMessage();
    return false;
}

}

//obtener clases del Proyecto
function obtenerTareasProyecto($id=null){ //tiene que recibir un id pero en caso de que no se le pasara mejor ponemos null
    include 'conexion.php';
    
    try {
    return $conn->query("SELECT id,nombre,estado FROM tareas WHERE id_proyecto={$id}"); //aqui utilizo comillas dibles "" para poder inyectar js
     }catch(Exception $e){
         echo"Error: ".$e->getMessage();
        return false;
    }
    
    }


?>