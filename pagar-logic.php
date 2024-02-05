<?php 
require 'config/conexion.php';

if (isset($_POST['submit'])) {
    $orden_id = filter_var($_POST['orden_id'], FILTER_SANITIZE_NUMBER_INT);
    $banco = filter_var($_POST['banco'], FILTER_SANITIZE_SPECIAL_CHARS);
    $monto = $_POST["monto"];
    $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_NUMBER_INT);
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO pagos(orden_id, banco, monto, referencia, fecha, estatus) VALUES(?, ?, ?, ?, ?, 'Pendiente')";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "issis", $orden_id, $banco, $monto, $referencia, $fecha);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: pago-success.php");
        exit();
    } else {
        echo "Error al insertar en la bd";
    }
}

