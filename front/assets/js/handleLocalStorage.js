// Función para guardar los datos de usuario en Local Storage
function guardarDatosUsuario(usuario) {
    localStorage.setItem('token', usuario.token);
    localStorage.setItem('username', usuario.username);
    localStorage.setItem('nombre', usuario.nombre);
    localStorage.setItem('apellidos', usuario.apellidos);
    localStorage.setItem('idTipoUsuario', usuario.usuario_tipo.id);
}

// Función para obtener los datos de usuario del Local Storage
function obtenerDatosUsuario() {
    const token = localStorage.getItem('token');
    const username = localStorage.getItem('username');
    const nombre = localStorage.getItem('nombre');
    const apellidos = localStorage.getItem('apellidos');
    const idTipoUsuario = localStorage.getItem('idTipoUsuario');

    if (token && username && nombre && apellidos && idTipoUsuario) {
        return {
            token: token,
            username: username,
            nombre: nombre,
            apellidos: apellidos,
            idTipoUsuario: idTipoUsuario
        };
    } else {
        return null;
    }
}

// Función para eliminar los datos de usuario del Local Storage al hacer logout
function eliminarDatosUsuario() {
    localStorage.removeItem('token');
    localStorage.removeItem('username');
    localStorage.removeItem('nombre');
    localStorage.removeItem('apellidos');
    localStorage.removeItem('idTipoUsuario');
}

// Ejemplo de uso para guardar los datos al hacer login
// guardarDatosUsuario('token123', 'usuario123', 'Juan', 'Pérez', '1');

// Ejemplo de uso para obtener los datos de usuario
// const datosUsuario = obtenerDatosUsuario();
// if (datosUsuario) {
//     console.log('Datos de usuario obtenidos:', datosUsuario);
// } else {
//     console.log('No hay datos de usuario.');
// }

// Ejemplo de uso para eliminar los datos al hacer logout
// eliminarDatosUsuario();
