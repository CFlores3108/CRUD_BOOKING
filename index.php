<?php include('header.php'); ?>
<?php include('dbcon.php'); ?>

<div class="containerLogin">
<form class="form" action="login_process.php" method="post">
    <div class="form-group">
        <label for="email">Correo</label>
        <input type="text" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" class="form-control">
    </div>
    <div class="form-group mt-3">
        <input type="submit" name="login" value="Login" class="btn btn-success">
    </div>
</form>
<div class="form-group mt-3 d-flex justify-content-center">
    <a href="registrar.php" class="btn btn-primary">Registrar un nuevo usuario</a>
</div>

</div>

<?php include('footer.php'); ?>