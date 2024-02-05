<?php 
include 'config/conexion.php';
session_start();

// Verificar si el botón "crearOrden" ha sido presionado
if (isset($_POST['crearOrden'])) {
   
    // Insertar los productos del carrito en la tabla "ordenes"
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $value) {
            $numero_orden = "SP_" . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $user_id = $_SESSION['user-id'];
            $cantidad_productos = $value['cantidad'];
            $total_pagar = $value['precio'] * $value['cantidad'];

            $sql = "INSERT INTO ordenes (numero_orden, users_id, cantidad_productos, total_pagar) 
            VALUES ('$numero_orden', '$user_id', '$cantidad_productos', '$total_pagar')";

            if (mysqli_query($conn, $sql)) {
                echo "Producto insertado en la tabla ordenes: " . $value['nombre'] . "<br>";
            } else {
                echo "Error al insertar el producto en la tabla ordenes: " . mysqli_error($conn);
            }
        }
    }

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $value) {
            $orden_id = mysqli_insert_id($connection);
            $id = $_SESSION['user-id'];
            $cantidad_productos = $value['cantidad'];
            $total_pagar = $value['precio'] * $value['cantidad'];
            $metodo_pago = $_POST['method'];
            $direccion = $_POST['direccion'];
            $placed_on = date('d-M-Y');

            $sql = "INSERT INTO ordenes (numero_orden, users_id, cantidad_productos, total_pagar, metodo_pago, direccion, created_at) 
            VALUES ('$numero_orden', '$id', '$cantidad_productos', '$total_pagar', '$metodo_pago', '$direccion', '$placed_on')";

            if (mysqli_query($connection, $sql)) {
                echo "<script>
                alert('Producto insertado en la tabla ordenes');</script>";
            } else {
                echo "Error al insertar el producto en la tabla ordenes: " . mysqli_error($connection);
            }
        }
    }

    // Después de insertar la orden en la tabla "ordenes"
    $orden_id = mysqli_insert_id($connection);
    // Recorre los productos del carrito
    foreach ($productos as $producto) {
        $nombre_producto = $producto['nombre'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio'];
        $precio_total = $cantidad * $precio_unitario;
        // Inserta el producto en la tabla "detalle_orden"
        $sql_detalle = "INSERT INTO detalle_orden (numero_orden, producto, cantidad, precio_unitario, precio_total) 
                        VALUES ('$numero_orden', '$nombre_producto', '$cantidad', '$precio_unitario', '$precio_total')";
        mysqli_query($connection, $sql_detalle);
    }
    // Obtén el número de orden de la URL
    $numero_orden = $_GET['numero_orden'];
    // Realiza una consulta a la tabla "detalle_orden" para obtener los productos de la orden
    $sql_detalle = "SELECT * FROM detalle_orden WHERE numero_orden = '$numero_orden'";
    $resultado_detalle = mysqli_query($connection, $sql_detalle);
    // Muestra los detalles de la orden en una tabla
    echo "<table>";
    echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th></tr>";
    while ($row = mysqli_fetch_assoc($resultado_detalle)) {
        echo "<tr>";
        echo "<td>" . $row['producto'] . "</td>";
        echo "<td>" . $row['cantidad'] . "</td>";
        echo "<td>" . $row['precio_unitario'] . "</td>";
        echo "<td>" . $row['precio_total'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";


    // Cerrar la conexión a la base de datos
    mysqli_close($connection);
}


?>