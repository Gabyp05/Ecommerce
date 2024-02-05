<?php
require '../admin/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pagoId = $_POST['pagoId'];
    $nuevoEstatus = $_POST['nuevoEstatus'];

  
    // Actualizar el estatus en la tabla pagos
    $updateQuery = "UPDATE pagos SET estatus = '$nuevoEstatus' WHERE id = $pagoId"; 
    mysqli_query($connection, $updateQuery);

    // Obtener la orden_id del registro de pagos actualizado
    $getOrderIdQuery = "SELECT orden_id FROM pagos WHERE id = $pagoId";
    $result = mysqli_query($connection, $getOrderIdQuery);
    $row = mysqli_fetch_assoc($result);
    $ordenId = $row['orden_id'];

    // Actualizar el estatus de la orden relacionada 
    if($nuevoEstatus == 'Aprobado') {
    $updateOrderQuery = "UPDATE ordenes SET estatus_id = 2 WHERE id = $ordenId";
    mysqli_query($connection, $updateOrderQuery);
    } elseif($nuevoEstatus == 'Pendiente') {
    $updateOrderQuery = "UPDATE ordenes SET estatus_id = 1 WHERE id = $ordenId";
    mysqli_query($connection, $updateOrderQuery);
    }

}
?>
