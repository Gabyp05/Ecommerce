<?php
require '../admin/config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $numero_orden = $_POST['id'];
    $created_at = $_POST['created_at'];
    $metodo_pago = $_POST['metodo_pago'];
    $estatus_id = $_POST['estatus'];

    $query = "UPDATE ordenes SET id='$numero_orden', created_at='$created_at', metodo_pago='$metodo_pago', estatus_id='$estatus_id' WHERE id=$id";
    mysqli_query($connection, $query);

    header('location: ' . ROOT_URL . 'admin/ordenes.php');
    die();
}
?>
