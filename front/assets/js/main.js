const ip = 'http://zndonosti.eus/back/';

// Verificar si el usuario está autenticado al cargar la página
window.addEventListener("DOMContentLoaded", function () {
    // Obtener el token de inicio de sesión almacenado en Local Storage
    // hay que añadir a la api un endpoint para verificar si el usuario esta logeado a partir de verificar el si el token es valido
    const token = localStorage.getItem("token");

    // Si no hay token, redirigir al usuario a la página de inicio de sesión
    if (!token) {
        window.location.href = "login.html";
    }
});

// customFetch('DELETE', 'profesores', {id: 3})

/* #region  customFetch anterior */
// async function customFetch(method, endpoint, params = null, body = null) {
//     // Obtener el token de localStorage
//     const token = localStorage.getItem("token");
//     // Crear los headers con el token de autorización
//     const myHeaders = new Headers();
//     myHeaders.append("Authorization", "Bearer " + token);
//     myHeaders.append("Content-Type", "application/json");
//     // Configurar la solicitud fetch
//     const requestOptions = {
//         method: method,
//         headers: myHeaders,
//         redirect: 'follow'
//     };
//     // Validar que el parámetro 'endpoint' esté presente
//     if (!endpoint) {
//         throw new Error("El parámetro 'endpoint' es obligatorio.");
//     }
//     // Construir la URL con el endpoint
//     let url = ip + endpoint;
//     // Si hay parámetros adicionales, añadirlos a la URL
//     if (params) {
//         url += '&' + new URLSearchParams(params);
//     }
//     // Si hay un cuerpo, añadirlo a la solicitud
//     if (body) {
//         requestOptions.body = JSON.stringify(body);
//     }
//     // Realizar la solicitud fetch
//     return fetch(url, requestOptions)
//         .then(response => response.json())
//         .catch(error => console.log('Error:', error));
// }
/* #endregion */

/* #region  customFetch nuevo */
// const token = localStorage.getItem("token");

// const myHeaders = new Headers();
// // myHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNzExOTc0NTc0fQ.QVNL2OVLCYN7PZBSQBwdstjos5AJul3j56pTDWwnjFg");
// myHeaders.append("Authorization", "Bearer " + token);
// myHeaders.append("Content-Type", "application/json");

// const apiUrl = "http://localhost/testApi/";

// async function customFetch(endpoint, method = "GET", options = {}) {
//   const requestOptions = {
//     method,
//     headers: myHeaders,
//     redirect: "follow",
//     ...options
//   };

//   if (options && options.body) {
//     requestOptions.body = JSON.stringify(options.body);
//   }

//   const queryParams = new URLSearchParams();
//   if (options && options.filter) {
//     queryParams.set("filter", JSON.stringify(options.filter));
//   }
//   if (options && options.id) {
//     queryParams.set("id", options.id);
//   }

//   const url = `${apiUrl}?endpoint=${endpoint}&${queryParams.toString()}`;

//   try {
//     const response = await fetch(url, requestOptions);
//     if (!response.ok) {
//       throw new Error(`HTTP error! status: ${response.status}`);
//     }
//     return await response.json();
//   } catch (error) {
//     console.error("Error:", error);
//     throw error;
//   }
// }
/* #endregion */

/* #region  customFetch nuevo2 */
async function customFetch(method, endpoint, params = {}, body = null) {
    // Construir la URL del endpoint con los parámetros si es necesario
    let url = 'http://localhost/testApi/index.php?endpoint=' + endpoint;
    if (Object.keys(params).length > 0) {
        url += '&' + new URLSearchParams(params);
    }

    // Obtener el token del localStorage
    const token = localStorage.getItem('token');

    // Configurar la solicitud
    let options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            // Incluir el token en el encabezado de autorización si está disponible
            'Authorization': token ? 'Bearer ' + token : ''
        }
    };

    // Añadir el cuerpo de la solicitud si es necesario
    if (body !== null) {
        options.body = JSON.stringify(body);
    }

    try {
        const response = await fetch(url, options);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
        // Aquí podrías manejar el error de alguna manera
        return { error: 'Hubo un error al procesar la solicitud.' };
    }
}
/* #endregion */

// // Ejemplo de uso
// customFetch('GET', 'example_endpoint', { page: 1 })
// .then(data => console.log(data))
// .catch(error => console.error('Hubo un error:', error));