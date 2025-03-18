// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo, elemento) {
    const alerta = document.getElementById(elemento);
    alerta.textContent = mensaje;
    alerta.className = `alerta alerta-${tipo}`;
    setTimeout(() => {
        alerta.textContent = '';
        alerta.className = 'alerta';
    }, 3000);
}

// Manejar el formulario de inicio de sesión
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            mostrarAlerta(data.mensaje, 'success', 'alerta-login');
            setTimeout(() => {
                window.location.reload(); // Recargar la página para actualizar la barra lateral
            }, 1500);
        } else {
            mostrarAlerta(data.mensaje, 'error', 'alerta-login');
        }
    });
});

// Manejar el formulario de registro
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('php/registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            mostrarAlerta(data.mensaje, 'success', 'alerta-registro');
            document.getElementById('registerForm').reset(); // Limpiar el formulario
        } else {
            mostrarAlerta(data.mensaje, 'error', 'alerta-registro');
        }
    });
});