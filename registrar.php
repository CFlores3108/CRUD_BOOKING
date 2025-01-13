<?php include('header.php'); ?>
<?php include('dbcon.php'); ?>

<div class="containerLogin">
    <form class="form" action="register_process.php" method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_pass">Confirmar Contraseña</label>
            <input type="password" name="confirm_pass" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Rol:</label><br>
            <label class="radio-inline">
                <input type="radio" name="role" value="cliente" required> Cliente
            </label>
            <label class="radio-inline">
                <input type="radio" name="role" value="administrador" required> Administrador
            </label>
        </div>
        <div class="form-group">
            <input type="submit" name="register" value="Registrar" class="btn btn-success">
        </div>
    </form>
</div>

<?php include('footer.php'); ?>
