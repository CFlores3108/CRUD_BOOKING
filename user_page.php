<?php
include('header.php');
include('dbcon.php');
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtener el id del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Consultar el nombre del cliente desde la base de datos
$sql = "SELECT nombre, apellido FROM usuarios WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre, $apellido);
$stmt->fetch();
$stmt->close();

// Mostrar el nombre del cliente
$full_name = $nombre . " " . $apellido;
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <h2>Bienvenido, <?php echo htmlspecialchars($full_name); ?>!</h2>
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
        </form>
    </div>

    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Direccion</th>
                <th>Precio</th>
                <th>Fecha Ingreso</th>
                <th>Hora Ingreso</th>
                <th>Fecha Salida</th>
                <th>Hora Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // Consultar las reservaciones del cliente logueado
            $query = "
                SELECT 
                    r.id AS reserva_id,
                    CONCAT(u.nombre, ' ', u.apellido) AS nombre_cliente,
                    a.descripcion AS alojamiento_descripcion,
                    a.direccion AS alojamiento_direccion,
                    a.precio AS alojamiento_precio,
                    r.fecha_ingreso,
                    r.hora_ingreso,
                    r.fecha_salida,
                    r.hora_salida
                FROM 
                    reservaciones r
                JOIN 
                    usuarios u ON r.cliente_id = u.id
                JOIN 
                    alojamientos a ON r.alojamiento_id = a.id
                WHERE 
                    r.cliente_id = ?
            ";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die("Consulta erronea");
            } else {
                while ($row = $result->fetch_assoc()) {
            ?>

                    <tr>
                        <td><?php echo $row['reserva_id']; ?></td>
                        <td><?php echo $row['nombre_cliente']; ?></td>
                        <td><?php echo $row['alojamiento_descripcion']; ?></td>
                        <td><?php echo $row['alojamiento_direccion']; ?></td>
                        <td><?php echo $row['alojamiento_precio']; ?></td>
                        <td><?php echo $row['fecha_ingreso']; ?></td>
                        <td><?php echo $row['hora_ingreso']; ?></td>
                        <td><?php echo $row['fecha_salida']; ?></td>
                        <td><?php echo $row['hora_salida']; ?></td>
                        <td>
                            <form action="delete_booking.php" method="post" style="display:inline;">
                                <input type="hidden" name="reserva_id" value="<?php echo $row['reserva_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>

            <?php
                }
            }
            ?>

        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
