//console.log('funciona');
eventListener();

//variable global para que este disponible en todas las secciones
var listaProyectos = document.querySelector('ul#proyectos');

function eventListener() {
    //Document Ready
    document.addEventListener('DOMContentLoaded', function () {
        actualizarProgreso();
    })

    //boton para crear proyecto
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);


    //boton para nueva tarea
    document.querySelector('.nueva-tarea').addEventListener('click', agregarTarea);

    //botones para las acciones de las tareas
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas); //delegation
}

function nuevoProyecto(e) {
    e.preventDefault();
    //   console.log('Presiono Nuevo Proyecto');

    //crea input para el nombre del proyecto
    var nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML = '<input type="text" id="nuevo-proyecto">';
    listaProyectos.appendChild(nuevoProyecto);


    //seleccionar el id con el nuevoProyecto
    var inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    //al presionar Enter crear el proyecto
    inputNuevoProyecto.addEventListener('keypress',
        function (e) {
            //console.log(e); //para ver el evento osea cuando presiono teclas ver los datos me fijo en keyCode o en el wich
            var tecla = e.wich || e.keyCode;
            if (tecla === 13) {
                //console.log('ENTER')
                guardarProyectoDB(inputNuevoProyecto.value)
                listaProyectos.removeChild(nuevoProyecto); //aqui ya puedo remover el input porque el dato que metí ya ha sido recibido por la funcion de guardarDB
            }

        });
}

//lo guarda en el DOM y en la DB
function guardarProyectoDB(nombreProyecto) {
    //console.log(nombreProyecto);

    //inyectar HTML
    /*var nuevoProyecto=document.createElement('li');
    nuevoProyecto.innerHTML= //vamos a usar stringLiterals para crear un template mas avanzado nueva funcion de ES6
    `
    <a href="#">
    ${nombreProyecto}
    </a>

    `;
    listaProyectos.appendChild(nuevoProyecto);*/

    //AJAX
    //crear llamado
    var xhr = new XMLHttpRequest();

    //enviar datos por formdata
    var datos = new FormData();
    datos.append('proyecto', nombreProyecto);
    datos.append('accion', 'crear');

    //abrir conexion
    xhr.open('POST', 'src/modelo/modelo-proyecto.php', true);

    //cargar
    xhr.onload = function () {
        if (this.status === 200) {
            //       console.log(JSON.parse(xhr.responseText)); //Json.parse para verlo como objeto y no como string

            //obtener datos de respuesta
            var respuesta = JSON.parse(xhr.responseText);
            var proyecto = respuesta.nombre_proyecto,
                id_proyecto = respuesta.id_insertado,
                tipo = respuesta.tipo,
                resultado = respuesta.respuesta;

            //comprobar la insercion
            if (resultado === 'correcto') {
                //Exitoso
                if (tipo === 'crear') {
                    //Creo proyecto nuevo
                    //inyectar en HTML
                    var nuevoProyecto = document.createElement('li');
                    nuevoProyecto.innerHTML = //vamos a usar stringLiterals para crear un template mas avanzado nueva funcion de ES6
                        `
    <a href="index.php?id_proyecto=${id_proyecto}" id="proyecto:${id_proyecto}">
    ${proyecto}
    </a>

    `;
                    //agregar al html
                    listaProyectos.appendChild(nuevoProyecto);
                    swal({
                        title: 'Proyecto Creado',
                        text: 'El proyecto ' + proyecto + ' se creó correctamente',
                        type: 'success'
                    }).then(resultado => { //arrow function
                        //console.log(resultado);
                        if (resultado.value) {
                            //para poder agregar tareas al momento de crear el proyecto
                            //redireccionar a la nueva URL
                            window.location.href = 'index.php?id_proyecto=' + id_proyecto;
                        }
                    })
                } else { //actualizo o elimino proyecto

                }
            } else { //error
                swal({
                    type: 'error',
                    tittle: 'Error',
                    text: 'Ocurrió un Error'
                })
            }
        }
    }

    //enviar el request
    xhr.send(datos);
}

//Agregar nueva tarea al proyecto actual
function agregarTarea(e) {
    e.preventDefault();
    // console.log('Click Enviar');

    var nombreTarea = document.querySelector('.nombre-tarea').value;
    //validar que no este vacio el campo de tarea
    if (nombreTarea === '') {
        swal({
            title: 'Error',
            text: 'No ha agregado tareas...',
            type: 'error'
        })
    } else { //la tarea tiene algo se interta en PHP

        //crear llamado AJX
        var xhr = new XMLHttpRequest();

        //formdata
        var datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', document.querySelector('#id_proyecto').value);

        //abrir conexion
        xhr.open('POST', 'src/modelo/modelo-tareas.php', true);

        //ejecutarlo y respuesta
        xhr.onload = function () {
            if (this.status === 200) {
                //todo correcto
                var respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);

                //Asignar valores
                var resultado = respuesta.respuesta,
                    tarea = respuesta.tarea,
                    id_insertado = respuesta.id_insertado,
                    tipo = respuesta.tipo;

                if (respuesta.respuesta === 'correcto') {
                    //se agregó correctamente
                    if (tipo === 'crear') { //lanzamos alerta
                        swal({
                            title: 'Tarea Agregada',
                            text: 'Se agrego la tarea ' + tarea + ' correctamente',
                            type: 'success'
                        });
                        //para corregir que se quite donde dice que no hay tareas
                        //seleccionar el parrafo con lista vacia
                        var parrafoListaVacia = document.querySelectorAll('.lista-vacia'); //lenght 0 es que el elemento no exite en HTML y 1 que si
                        if (parrafoListaVacia.length > 0) {
                            document.querySelector('.lista-vacia').remove(); //y si queremos que aparezca de nuevo tenemos que ir a eliminarTarea();
                        }
                        //construir template
                        var nuevaTarea = document.createElement('li');

                        //agregamos el ID
                        nuevaTarea.id = 'tarea: ' + id_insertado;

                        //agregar la clase tarea
                        nuevaTarea.classList.add('tarea');

                        //construir el html //ES6
                        nuevaTarea.innerHTML = ` 
    <p>${tarea}</p>
    <div class="acciones">
    <i class="far fa-check-circle"></i>
    <i class="fas fa-trash"></i>
    </div>
    `;

                        //agregarlo al DOM
                        var listado = document.querySelector('.listado-pendientes ul');
                        listado.appendChild(nuevaTarea);

                        //limpiar formulario
                        document.querySelector('.agregar-tarea').reset();

                        //actualizar barra de progreso
                        actualizarProgreso();
                    }
                } else { //hubo un error
                    swal({
                        title: 'Error',
                        text: 'Error desconocido...',
                        type: 'error'
                    });
                }
            }
        }

        //enviar consulta
        xhr.send(datos);
    }
}

//cambia el estado de las tarea o las elimina
function accionesTareas(e) {
    e.preventDefault();

    //console.log('Diste click'); //agarra donde di click
    //console.log(e.target); //delegation es como un contenedor grande para asi poder comparar con un if en donde se dio click
    if (e.target.classList.contains('fa-check-circle')) {
        // console.log('Click en el circulo');
        if (e.target.classList.contains('completo')) {
            e.target.classList.remove('completo');

            cambiarEstadoTarea(e.target, 0);
        } else {
            e.target.classList.add('completo');
            cambiarEstadoTarea(e.target, 1); //le paso un 0 y 1 para establecer el estado
        }
    }
    /* else {
            //console.log('Click en otro lado');
        }*/

    if (e.target.classList.contains('fa-trash')) {
        //  console.log('Click en borrar');
        swal({
            title: 'Estás seguro?',
            text: 'No podrá recuperar esta información',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, estoy seguro de eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var tareaEliminar = e.target.parentElement.parentElement; //traversing

                //Borrar de la Base de Datos
                eliminarTareaBD(tareaEliminar);

                //Borrar del HTML //hago este primero porque es mas facil
                //console.log(tareaEliminar);
                tareaEliminar.remove();
                swal(
                    'Eliminado',
                    'Su archivo ha sido borrado',
                    'success'
                )
            }
        })
    }
    /*else{
        console.log('Click en otro lado');
    }*/
}

//Completa o descompleta una tarea
function cambiarEstadoTarea(tarea, estado) { //el estado es el 0 y 1 que le agregue arriba al dar click
    //console.log(tarea);
    //console.log(tarea.parentElement.parentElement.id.split(':')); //split para separar el id que dice tarea:x
    var idTarea = tarea.parentElement.parentElement.id.split(':');
    //console.log(idTarea[1]);//[1] para acceder a una determinada posicion del array que se creo con el split


    //crear llamado ajax
    var xhr = new XMLHttpRequest();

    //info
    var datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'actualizar');

    //console.log(estado);
    datos.append('estado', estado);

    //conexion
    xhr.open('POST', 'src/modelo/modelo-tareas.php', true);

    //cargar
    xhr.onload = function () {
        if (this.status === 200) {
            //          console.log(JSON.parse(xhr.responseText));
            var respuesta = JSON.parse(xhr.responseText);
            //   console.log(respuesta);
            //actualizar barra de progreso
            actualizarProgreso();
        }
    }

    //enviar
    xhr.send(datos);
}

//Elimina las tareas de la Base de Datos
function eliminarTareaBD(tarea) {
    // console.log(tarea);

    var idTarea = tarea.id.split(':');


    //crear llamado ajax
    var xhr = new XMLHttpRequest();

    //info
    var datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'eliminar');

    //conexion
    xhr.open('POST', 'src/modelo/modelo-tareas.php', true);

    //cargar
    xhr.onload = function () {
        if (this.status === 200) {
            // console.log(JSON.parse(xhr.responseText));
            // var respuesta = JSON.parse(xhr.responseText);
            //   console.log(respuesta);

            //comprobar que haya tareas
            var listaTareasRestantes = document.querySelectorAll('li.tarea');
            if (listaTareasRestantes.length === 0) { //en caso de que no haya nada
                document.querySelector('.listado-pendientes ul').innerHTML =
                    "<p class='lista-vacia'> No hay tareas aquí </p>"
            }
            //actualizar barra de progreso
            actualizarProgreso();
        }
    }

    //enviar
    xhr.send(datos);
}

//Actualiza el avance del Proyecto
function actualizarProgreso() {
    //console.log('desde actualizarProgreso');

    //obtener todas las tareas
    const tareas = document.querySelectorAll('li.tarea'); //

    //obtener tareas completas
    const tareasCompletas = document.querySelectorAll('i.completo');
    //console.log(tareas.length);
    //console.log(tareasCompletas.length);

    //determinar avance
    const avance = Math.round((tareasCompletas.length / tareas.length) * 100); //Math.round redondear

    //asignar avance a barra
    const porcentaje = document.querySelector('#porcentaje');
    porcentaje.style.width = avance + '%';
    // console.log(avance);

    //mostrar alerta de 100%
    if(avance===100){
        swal({
            title: 'Proyecto Finalizado',
            text: 'Tareas Completadas ',
            type: 'success'
        });
    }
}