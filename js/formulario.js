//eliminar cache= ctr+shift+r
//JS no puede insertar en la base de dats por si solo necesita AJAX o Node.js


//console.log('funciona');

eventListener(); //llamamos funcion

//creamos funcion
function eventListener() {
    document.querySelector('#formulario').addEventListener('submit', validarRegistro); //submit hace referencia al type del input

}

function validarRegistro(e) { //le pasamos el evento e
    e.preventDefault(); //preventDefault lo que hace es que no se envíe

    var usuario = document.querySelector('#usuario').value,
        password = document.querySelector('#password').value,
        tipo = document.querySelector('#tipo').value;

    if (usuario === '' || password === '') {
        swal({ //es una alerta de swwetaler2
            //la validacion falló
            type: 'error',
            title: 'Oopppss',
            text: 'Todos los campos son necesarios'
        })

    } else { //si ambos campos estan

        //datos que se envian al servidor
        var datos = new FormData(); //puede ser utilizado en lo que sea, es para estructurar el llamado a AJAX
        datos.append('usuario', usuario); //append para agregar datos al FormData
        datos.append('password', password);
        datos.append('accion', tipo);

        //console.log(datos.get('usuario'));

        //llamado AJAX
        var xhr = new XMLHttpRequest();

        //Abrir conexion
        xhr.open('POST', 'src/modelo/modelo-admin.php', true); //como lo enviamos, a donde lo enviamos, true=llamado asincrono

        //Retorna Datos
        xhr.onload = function () {

            if (this.status === 200) {
                //  console.log(JSON.parse(xhr.responseText)); //Json.parse toma el string y lo convierte en un objeto JS
                var respuesta = JSON.parse(xhr.responseText);

                console.log(respuesta);
                //si la respuesta es correcta
                if (respuesta.respuesta === 'correcto') {
                    //si es un nuevo usuario
                    if (respuesta.tipo === 'crear') {
                        swal({
                            title: 'Usuario Creado',
                            text: 'El usuario se creó correctamente',
                            type: 'success'
                        });
                    }else if (respuesta.tipo==='login') {
                        swal({
                            title:'Login Correcto',
                            text: 'Iniciando Sesión...',
                            type: 'success' 
                        }).then(resultado=>{//arrow function
                            //console.log(resultado);
                            if(resultado.value){
                                window.location.href='index.php';
                            }
                        })
                    }
                } else{
                    swal({
                        title: 'Error',
                        text: 'Ha ocurrido un problema',
                        type: 'error'
                    });
                }
            }
        }

        //Enviar la peticion
        xhr.send(datos);
    }
}