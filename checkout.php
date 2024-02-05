<?php 
include 'templates/header.php'; 

session_start();
$query = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);


if (isset($_POST['crearOrden'])) {

    // Obtener los productos del carrito de la sesión
    $productos = $_SESSION['carrito'];
   
    // Calcular el total de productos y la cantidad total a pagar
    $total_productos = 0;
    $total_pagar = 0;
    foreach ($productos as $producto) {
      $total_productos += $producto['cantidad'];
      $total_pagar += $producto['precio'] * $producto['cantidad'];
    }
  
    $metodo_pago = $_POST['method'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $placed_on = date('Y-m-d');
  
    $id = $_SESSION['user-id'];
  
    // Insertar la orden en la tabla 'ordenes'
    $sql = "INSERT INTO ordenes (cantidad, total, estatus_id, usuario_id, metodo_pago, direccion, telefono, created_at) 
            VALUES ('$total_productos', '$total_pagar', 1, '$id', '$metodo_pago', '$direccion', '$telefono', '$placed_on')";
  
    if (mysqli_query($connection, $sql)) {
      $orden_id = mysqli_insert_id($connection);
  
      // Crear una variable para almacenar el contenido del bucle
    // $contenido = '';

    foreach ($productos as $producto) {
        if (isset($producto['id'])) {
            $producto_id = $producto['id'];
            $cantidad = $producto['cantidad'];

            // Insertar el producto en la tabla 'detalle_orden'
            $sql = "INSERT INTO detalle_orden (orden_id, producto_id, cantidad) 
                    VALUES ('$orden_id', '$producto_id', '$cantidad')";

            mysqli_query($connection, $sql);

            // Restar la cantidad del stock disponible
            $sql = "UPDATE productos 
                    SET stock = stock - $cantidad 
                    WHERE id = $producto_id";
            mysqli_query($connection, $sql);

            // Agregar el contenido del bucle a la variable
            // $contenido .= "Orden ID: $orden_id, Producto ID: $producto_id, Cantidad: $cantidad\n";
        }
    }

    // Guardar el contenido en un archivo .txt
    // file_put_contents('archivo.txt', $contenido);
  
      header("Location: success.php");
      unset($_SESSION['carrito']);
      exit();
    } else {
      echo "<script>
            alert('Error al crear la orden');
            </script> " . mysqli_error($connection);
    }
}

 

?>

    <link rel="stylesheet" href="<?= ROOT_URL?>/css/registro.css">
    <section class="form__section_cart">
    <div class="container form__section-container">
        <h3>Llena el formulario para completar la orden</h3><br> 
        <form action=""  method="post">
            <input type="text" name="nombre" value="<?= $user['nombre'] ?>">
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="text" name="usuario" value="<?= $user['usuario'] ?>">
            <input type="email"name="email" value="<?= $user['email'] ?>" placeholder="Correo">
            <div class="inputBox">
                <span>Método de Pago</span><br>
                <select name="method" class="box" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Pago Móvil">Pago Móvil</option>
                <option value="Transferencia">Transferencia</option>
                </select>
            </div>
            <input type="text" name="direccion" placeholder="Dirección">
            <input type="text" name="referencia" placeholder="Punto de Referencia" >
            <button type="submit" name="crearOrden" class="btn">Crear Orden</button>
        </form>
    </div>
</section>


<?php include 'templates/footer.php'; ?>