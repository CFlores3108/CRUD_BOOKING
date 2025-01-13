<?php
include('dbcon.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$reserva_id = $_GET['id'];

$query = "SELECT cliente_id FROM reservaciones WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $reserva_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: user_page.php?status=error&message=Reservación no encontrada');
    exit;
}

$reserva = $result->fetch_assoc();
if ($reserva['cliente_id'] != $user_id) {
    header('Location: user_page.php?status=error&message=No tienes permiso para eliminar esta reservación');
    exit;
}

$query = "DELETE FROM reservaciones WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $reserva_id);

if ($stmt->execute()) {
    header('Location: user_page.php?status=success&message=Reservación eliminada correctamente');
} else {
    header('Location: user_page.php?status=error&message=Error al eliminar la reservación');
}

$stmt->close();
$connection->close();
?>
