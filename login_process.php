<?php
include('dbcon.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $plain_password = $_POST['pass'];

    // Verificar el usuario
    $query = "SELECT id, nombre, apellido, email, password, rol FROM usuarios WHERE email = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($plain_password, $user['password'])) {
            // Guardamos la información del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellido'] = $user['apellido'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir según el rol
            if ($user['rol'] == 'cliente') {
                header('Location: user_page.php'); // Redirigir al cliente
            } else {
                header('Location: admin_page.php'); // Redirigir al administrador
            }
            exit; // Detener el script para que no se ejecute el resto
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='index.php';</script>";
    }

    $stmt->close();
    $connection->close();
}
?>
