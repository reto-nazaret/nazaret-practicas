document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el comportamiento predeterminado del envío del formulario

    // Obtener los datos del formulario
    const formData = new FormData(this);

    // Crear un objeto JSON a partir de los datos del formulario
    const nuevoRegistro = {};
    formData.forEach(function(value, key) {
        nuevoRegistro[key] = value;
    });

    // Add bearer token to headers
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNzExOTc0NTc0fQ.QVNL2OVLCYN7PZBSQBwdstjos5AJul3j56pTDWwnjFg");
    myHeaders.append("Content-Type", "application/json");

    // Convert the nuevoRegistro object to a JSON string
    const raw = JSON.stringify(nuevoRegistro);

    // Set up request options
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };

    // Send data to the server using a fetch request
    fetch('https://65dee12cff5e305f32a0bfb3.mockapi.io/Profesores', requestOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al enviar los datos');
            }
            return response.json();
        })
        .then(data => {
            // Handle server response if necessary
            console.log('Datos enviados exitosamente:', data);

            // Redirect
            window.location.href = '../../../../CentrosDeTrabajo.html';
        })
        .catch(error => {
            console.error('Error:', error);
        });


});