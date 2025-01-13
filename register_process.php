<?php
include('dbcon.php');

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$plain_password = $_POST['pass'];
$confirm_password = $_POST['confirm_pass'];
$role = $_POST['role'];

// Verificar si las contraseñas coinciden
if ($plain_password !== $confirm_password) {
    echo "Las contraseñas no coinciden.";
    exit;
}

// Hashear la contraseña
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Insertar el usuario en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES (?, ?, ?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $email, $hashed_password, $role); // Vinculamos los valores

// Ejecutar la consulta
if ($stmt->execute()) {
    header('Location: index.php');
} else {
    echo "Error al registrar el usuario: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
