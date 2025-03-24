<aside id="sidebar">
    <div id="buscador" class="bloque">
        <h3>Buscar</h3>
        <form action="../php/buscar.php" method="POST"> 
            <input type="text" name="busqueda" />
            <input type="submit" value="Buscar" />
        </form>
    </div>
    
    <?php if (isset($_SESSION['usuario'])): ?>
        <div id="usuario-logueado" class="bloque">
            <h3>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h3>
            <a href="index.php?crear_entrada=1" class="boton boton-verde">Crear entradas</a>
            <a href="php/crear-categorias.php" class="boton">Crear categoría</a>
            <a href="mis-datos.php" class="boton boton-naranja">Mis datos</a>
            <a href="php/logout.php" class="boton boton-rojo">Cerrar sesión</a>
        </div>
    <?php else: ?>
        <div id="login" class="bloque">
            <h3>Inicia Sesión</h3>
            <div id="alerta-login" class="alerta"></div>
            
            <form id="loginForm" method="POST"> 
                <label for="email">Email</label>
                <input type="email" name="email" required />
                
                <label for="password">Contraseña</label>
                <input type="password" name="password" required />
                
                <input type="submit" value="Entrar" />
            </form>
        </div>
        
        <div id="register" class="bloque">
            <h3>Registrarse</h3>
            <div id="alerta-registro" class="alerta"></div>
            
            <form id="registerForm" method="POST"> 
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required />
                
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" required />
                
                <label for="email">Email</label>
                <input type="email" name="email" required />
                
                <label for="password">Contraseña</label>
                <input type="password" name="password" required />
                
                <input type="submit" name="submit" value="Registrar" />
            </form>
        </div>
    <?php endif; ?>
</aside>