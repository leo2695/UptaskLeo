<?php //cuando importemos esto en cualquier pagina
function usuario_autenticado(){
if(!revisar_usuario()){ //si no hay un usuario entonces...
header('Location:login.php'); //si no me manda a login para que inice sesion
exit();
}
}

function revisar_usuario(){
return isset($_SESSION['nombre']);
}

session_start(); //funcion de PHP  //arrancamos sesion
usuario_autenticado(); //corremos el usuario

?>