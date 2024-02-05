<?php
session_start();

if (isset($_POST['id']) && isset($_POST['cantidad'])) {
  $id = $_POST['id'];
  $cantidad = $_POST['cantidad'];

  // Actualizar la cantidad en la sesión
  if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $indice => $producto) {
      if ($producto['id'] == $id) {
        $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
        break;
      }
    }
  }

  // Devolver la nueva cantidad como respuesta
  echo $cantidad;
}
?>
