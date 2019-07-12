<?php

function obtenerPaginaActual()
{ //este metodo es como para ponerlo en el class= para que tome el estilo de la pagina en que este
    $archivo = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace(".php", "", $archivo);
    return $pagina;
}
