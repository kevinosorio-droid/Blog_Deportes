<!-- BARRA LATERAL -->
<aside id="sidebar">
    <div id="buscador" class="bloque">
        <h3>Buscar</h3>
        <form action="buscar.php" method="POST"> 
            <input type="text" name="busqueda" />
            <input type="submit" value="Buscar" />
        </form>
    </div>
    
    <?php if (isset($_SESSION['usuario'])): ?>
        <!-- Bloque para usuarios logueados -->
        <div id="usuario-logueado" class="bloque">
            <h3>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h3>
            <!-- Botones -->
            <a href="crear-entradas.php" class="boton boton-verde">Crear entradas</a>
            <a href="crear-categoria.php" class="boton">Crear categoría</a>
            <a href="mis-datos.php" class="boton boton-naranja">Mis datos</a>
            <a href="cerrar.php" class="boton boton-rojo">Cerrar sesión</a>
        </div>
    <?php else: ?>
        <!-- Bloque para usuarios no logueados -->
        <div id="login" class="bloque">
            <h3>Inicia Sesión</h3>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'login'): ?>
                
            <?php endif; ?>
            
            <form action="login.php" method="POST"> 
                <label for="email">Email</label>
                <input type="email" name="email" required />
                
                <label for="password">Contraseña</label>
                <input type="password" name="password" required />
                
                <input type="submit" value="Entrar" />
            </form>
        </div>
        
        <div id="register" class="bloque">
            <h3>Registrarse</h3>
            
            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exito'): ?>
              
            <?php elseif (isset($_GET['registro']) && $_GET['registro'] == 'error'): ?>
               
            <?php endif; ?>
            
            <form action="registro.php" method="POST"> 
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

<script src="js/auth.js"></script>