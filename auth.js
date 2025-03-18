// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo) {
    const alerta = document.getElementById('alerta');
    alerta.textContent = mensaje;
    alerta.className = `alerta alerta-${tipo}`;
    setTimeout(() => {
        alerta.textContent = '';
        alerta.className = 'alerta';
    }, 3000);
}

// Validar y enviar el formulario de inicio de sesión
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
            mostrarAlerta(data.mensaje, 'success');
            setTimeout(() => {
                window.location.reload(); // Recargar la página para mostrar el mensaje de bienvenida
            }, 1500);
        } else {
            mostrarAlerta(data.mensaje, 'error');
        }
    });
});

// Validar y enviar el formulario de registro
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
            mostrarAlerta(data.mensaje, 'success');
            document.getElementById('registerForm').reset(); // Limpiar el formulario
        } else {
            mostrarAlerta(data.mensaje, 'error');
        }
    });
});