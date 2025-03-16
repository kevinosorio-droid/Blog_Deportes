document.addEventListener("DOMContentLoaded", function () {
    const formLogin = document.getElementById("formLogin");
    const alerta = document.getElementById("alerta");

    formLogin.addEventListener("submit", function (e) {
        e.preventDefault();
        alerta.style.display = "none";

        const formData = new FormData(formLogin);

        fetch("login.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                window.location.reload(); // Recarga la página si el login es exitoso
            } else {
                alerta.textContent = data.mensaje;
                alerta.classList.add("alerta-error");
                alerta.style.display = "block"; // Muestra la alerta de error
            }
        })
        .catch(error => console.error("Error en la petición:", error));
    });
});
