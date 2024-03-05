//Obtener el id recibido
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');


document.addEventListener('DOMContentLoaded', function () {
    obtenerDatos();
});


       

async function obtenerDatos() {


    return await customFetch('GET', 'profesores', id , null)
        .then(response => {
            console.log(response)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log(response)
            return response.json();
        })
        .then(data => {
            document.getElementById('dni').value = data.dni;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('apellidos').value = data.apellidos;

            console.log(data)
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
};
document.addEventListener('DOMContentLoaded', function () {
    obtenerDatos();
});


document.getElementById('formulario').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    let bodyAlumnos = {
        id: id,
        dni: document.getElementById('dni').value,
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value    
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
        window.location.href = '../../../../profesores.html';
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

