
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Obtener valores de nombre de usuario y contraseña
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Verificar que se ingresaron nombre de usuario y contraseña
    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    const urlencoded = new URLSearchParams();
    urlencoded.append("username", username);
    urlencoded.append("password", password);

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: urlencoded,
        redirect: "follow"
    };


    // Realizar la solicitud a la API de inicio de sesión
    fetch(ip + "?endpoint=login", requestOptions)
        .then((response) => response.json())
        .then((result) => {
            // console.log(result);
            if (result.loggedIn && result.usuario) {
                guardarDatosUsuario(result.usuario);
                window.location.href = "index.html";
            } else {
                // hacer una alerta diciendo que habia un error
                alert("Invalid username or password.");
                console.error("invalid credentials");
            }
        })
        .catch((error) => console.error("Error:", error));
});
