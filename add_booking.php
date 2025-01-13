<?php
    include 'dbcon.php';
    if(isset($_POST['add_booking'])){
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $hora_ingreso = $_POST['hora_ingreso'];
        $fecha_salida = $_POST['fecha_salida'];
        $hora_salida = $_POST['hora_salida'];
        $cliente_id = $_POST['cliente_id'];
        $alojamiento_id = $_POST['alojamiento_id'];

        $query = "
                    INSERT INTO `reservaciones` (`fecha_ingreso`, `hora_ingreso`, `fecha_salida`, `hora_salida`, `cliente_id`, `alojamiento_id`)
                    VALUES ('$fecha_ingreso', '$hora_ingreso', '$fecha_salida', '$hora_salida', '$cliente_id', '$alojamiento_id');
        ";

        $result = mysqli_query($connection, $query);

        if(!$result){
            die("Fallo query");
        }

    }
?>