document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form[action='registro.php']").addEventListener("submit", function(e) {
        let nombre = document.querySelector("input[name='nombre']").value.trim();
        let email = document.querySelector("input[name='email']").value.trim();
        let password = document.querySelector("input[name='password']").value;
        
        if (nombre === "" || email === "" || password.length < 6) {
            alert("Todos los campos son obligatorios y la contraseña debe tener al menos 6 caracteres.");
            e.preventDefault();
        }
    });
    
    document.querySelector("form[action='login.php']").addEventListener("submit", function(e) {
        let email = document.querySelector("input[name='email']").value.trim();
        let password = document.querySelector("input[name='password']").value;
        
        if (email === "" || password === "") {
            alert("Por favor, complete todos los campos.");
            e.preventDefault();
        }
    });
});
