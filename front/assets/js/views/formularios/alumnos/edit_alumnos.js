const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

console.log(id)


document.addEventListener('DOMContentLoaded', function() {
    obtenerDatos();
});



async function obtenerDatos() {


    return await customFetch('GET', `alumnos`, id , null)
        .then(response => {
            console.log(response)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log(response)
            return response.json();
        })
        .then(data => {
            // Rellenar los valores del formulario con los datos del profesor obtenidos de la API
            document.getElementById('dni').value = data.alumnos.dni;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('apellido').value = data.apellidos;
            document.getElementById('poblacion').value = data.poblacion;
            document.getElementById('email').value = data.email;
            document.getElementById('ingles').value = data.ingles;
            document.getElementById('euskera').value = data.euskera;
            document.getElementById('otraTitulacion').value = data.otra_titulacion;
            // document.getElementById('ciclo').value = data.ciclo.nombre;
            document.getElementById('vehiculo').checked = data.vehiculo;

            console.log(data)
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
};

document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    let bodyAlumnos = {
        id: id,
        dni: document.getElementById('dni').value,
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        poblacion: document.getElementById('poblacion').value,
        email: document.getElementById('email').value,
        ingles: document.getElementById('ingles').value,
        euskera: document.getElementById('euskera').value,
        otraTitulacion: document.getElementById('otraTitulacion').value,
        id_ciclo: document.getElementById('ciclo').value,
        vehiculo: document.getElementById('vehiculo').value
        
    }

    


    // Realizar la solicitud PUT para actualizar los datos
    customFetch('PUT', 'alumnos', null, bodyAlumnos)
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al actualizar los datos');
        }
        return response.json();
    })
    .then(data => {
        // Manejar la respuesta del servidor si es necesario
        console.log('Datos actualizados exitosamente:', data);

        // Redireccionar a la página de alumnos
        window.location.href = '../../../../alumnos.html';
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
