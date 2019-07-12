<?php

$conn=new mysqli('localhost','root','root','uptask');

if($conn->connect_error){ //por si hubiera errores
    echo $conn->connect_error;
}
$conn->set_charset('utf8'); //para que si me salgan los acentos, por aquello de que no

//pdo es otra forma
?>