document.addEventListener('DOMContentLoaded', function () {
    obtenerDatos();
});

function obtenerDatos() {
    //Obtener el id recibido
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    return fetch(`https://65dee12cff5e305f32a0bfb3.mockapi.io/Profesores/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Rellenar los valores del formulario con los datos del profesor obtenidos de la API

            document.getElementById('alumno').value = data.alumno;
            document.getElementById('centro_trabajo').value = data.centro_trabajo;
            document.getElementById('responsable').value = data.responsable;
            document.getElementById('tutor').value = data.tutor;
            document.getElementById('tipo_practica').value = data.tipo_practica;
            document.getElementById('fecha_inicio').value = data.fecha_inicio;
            document.getElementById('fecha_fin').value = data.fecha_fin;
            document.getElementById('direccion').value = data.direccion;
            console.log(data)
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
};

document.getElementById('formulario').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Obtener los datos del formulario
    const formData = new FormData(this);

    // Crear un objeto JSON a partir de los datos del formulario
    const updatedData = {};
    formData.forEach(function (value, key) {
        updatedData[key] = value;
    });

    // Obtener el id del profesor de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Crear los headers
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNzA5MzQyNjgxfQ.1k0iXk_fz0XQ9eoRmMWi0yTvfuSUMs0t-cihpoJ-600");
    myHeaders.append("Content-Type", "application/json");

    // Realizar la solicitud PUT para actualizar los datos
    fetch(`https://65dee12cff5e305f32a0bfb3.mockapi.io/Profesores/${id}`, {
        method: 'PUT',
        headers: myHeaders, // Add headers here
        body: JSON.stringify(updatedData)
    })
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
            window.location.href = '../../../../contactos.html';
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

