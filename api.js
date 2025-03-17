document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('login.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            window.location.href = 'index.php';
        } else {
            mostrarAlerta(data.mensaje, 'error');
        }
    });
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('registro.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            mostrarAlerta(data.mensaje, 'success');
            document.getElementById('registerForm').reset();
        } else {
            mostrarAlerta(data.mensaje, 'error');
        }
    });
});

function mostrarAlerta(mensaje, tipo) {
    const alerta = document.getElementById('alerta');
    alerta.textContent = mensaje;
    alerta.className = `alerta alerta-${tipo}`;
    setTimeout(() => {
        alerta.textContent = '';
        alerta.className = 'alerta';
    }, 3000);
}