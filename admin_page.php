<?php include('header.php'); ?>
<?php include('dbcon.php'); ?>

<div class="box1">
    <h2>Alojamientos</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Nuevo Alojamiento</button>
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
        </tr>
    </thead>
    <tbody>

        <?php
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
                ";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Consulta erronea");
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
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
                </tr>

        <?php
            }
        }

        ?>

        <tr>

        </tr>
    </tbody>
</table>

<!-- Modal -->
<form action="add_booking.php" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Reservación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Cliente -->
                    <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select name="cliente_id" class="form-control" id="cliente_id" required>
                            <option value="">Seleccionar Cliente</option>
                            <?php
                            $sql_clientes = "SELECT id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuarios WHERE rol = 'cliente'";
                            $result_clientes = $connection->query($sql_clientes);

                            // Verificar si hay resultados y cargarlos
                            while ($row = $result_clientes->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nombre_completo'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Alojamiento -->
                    <div class="form-group">
                        <label for="alojamiento_id">Alojamiento</label>
                        <select name="alojamiento_id" class="form-control" id="alojamiento_id" required>
                            <option value="">Seleccionar Alojamiento</option>
                            <?php
                                // Aquí cargarás los alojamientos desde la base de datos
                                $sql_alojamientos = "SELECT id, descripcion FROM alojamientos";
                                $result_alojamientos = $connection->query($sql_alojamientos);

                                // Verificar si hay resultados y cargarlos
                                while ($row = $result_alojamientos->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <!-- Fecha de Ingreso -->
                    <div class="form-group">
                        <label for="fecha_ingreso">Fecha de Ingreso</label>
                        <input type="date" name="fecha_ingreso" class="form-control" required>
                    </div>
                    <!-- Hora de Ingreso -->
                    <div class="form-group">
                        <label for="hora_ingreso">Hora de Ingreso</label>
                        <input type="time" name="hora_ingreso" class="form-control" id="hora_ingreso" required>
                    </div>
                    <!-- Fecha de Salida -->
                    <div class="form-group">
                        <label for="fecha_salida">Fecha de Salida</label>
                        <input type="date" name="fecha_salida" class="form-control" required>
                    </div>
                    <!-- Hora de Salida -->
                    <div class="form-group">
                        <label for="hora_salida">Hora de Salida</label>
                        <input type="time" name="hora_salida" class="form-control" id="hora_salida" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-success" name="add_booking" value="Reservar">
                </div>
            </div>
        </div>
    </div>
</form>

<?php include('footer.php'); ?>