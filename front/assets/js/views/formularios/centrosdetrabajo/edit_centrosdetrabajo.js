//Obtener el id recibido
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');


document.addEventListener('DOMContentLoaded', function() {
    obtenerDatos();
});

function obtenerDatos() {
    return fetch(`https://65dee12cff5e305f32a0bfb3.mockapi.io/Profesores/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data)
            // Rellenar los valores del formulario con los datos del profesor obtenidos de la API
            document.getElementById('empresa').value = data.empresa;
            document.getElementById('denominacion').value = data.denominacion;
            document.getElementById('pais').value = data.pais;
            document.getElementById('territorio').value = data.territorio;
            document.getElementById('municipio').value = data.municipio;
            document.getElementById('codigoPostal').value = data.codigoPostal;
            document.getElementById('direccion').value = data.direccion;
            document.getElementById('telefono').value = data.telefono;
            document.getElementById('telefono2').value = data.telefono2;
            document.getElementById('fax').value = data.fax;
            document.getElementById('email').value = data.email;
            document.getElementById('actividad').value = data.actividad;
            document.getElementById('numeroDeTrabajadores').value = data.numeroDeTrabajadores;


        })
        .catch(error => {
            console.error('Error fetching data:', error);
        })
};

