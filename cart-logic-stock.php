<?php 
require 'config/conexion.php';
// session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

//Desde el index
if(isset($_POST['addCart'])){
    $producto_id = $_POST['id'];
    $imagen_producto = $_POST['img'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $cantidad_producto = $_POST['cantidad'];

    // Realizar consulta a la base de datos para obtener el stock actual del producto
    $consulta_stock = "SELECT stock FROM productos WHERE id = $producto_id";
    // Ejecutar la consulta y obtener el resultado
    $resultado_consulta = mysqli_query($connection, $consulta_stock);

    // Verificar si la consulta se ejecutó correctamente
    if($resultado_consulta) {
        // Obtener los datos de la consulta
        $fila = mysqli_fetch_assoc($resultado_consulta);
        $stock_actual = $fila['stock'];

        // Verificar si hay suficiente stock disponible
        if($cantidad_producto <= $stock_actual) {
            // Restar la cantidad del producto agregado al carrito al stock disponible
            $nuevo_stock = $stock_actual - $cantidad_producto;

            // Actualizar el valor de la columna de stock en la tabla de productos
            $actualizar_stock = "UPDATE productos SET stock = $nuevo_stock WHERE id = $producto_id";
            // Ejecutar la consulta de actualización

            // Agregar el producto al carrito
            $_SESSION['carrito'][] = array(
                'id' => $producto_id,
                'img' => $imagen_producto,
                'nombre' => $nombre_producto,
                'precio' => $precio_producto,
                'cantidad'=> $cantidad_producto
            );
            header("location: index.php");
            
        } else {
            echo "
            <script>
            alert('No hay suficiente stock disponible');
            window.location.href='index.php'
            </script>
            ";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($connection);
    }
}

//Desde el detalle del producto
if(isset($_POST['comprar'])){
    $producto_id = $_POST['id'];
    $imagen_producto = $_POST['img'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $cantidad_producto = $_POST['cantidad'];

    // Realizar consulta a la base de datos para obtener el stock actual del producto
    $consulta_stock = "SELECT stock FROM productos WHERE id = $producto_id";
    // Ejecutar la consulta y obtener el resultado
    $resultado_consulta = mysqli_query($connection, $consulta_stock);

    // Verificar si la consulta se ejecutó correctamente
    if($resultado_consulta) {
        // Obtener los datos de la consulta
        $fila = mysqli_fetch_assoc($resultado_consulta);
        $stock_actual = $fila['stock'];

        // Verificar si hay suficiente stock disponible
        if($cantidad_producto <= $stock_actual) {
            // Restar la cantidad del producto agregado al carrito al stock disponible
            $nuevo_stock = $stock_actual - $cantidad_producto;

            // Actualizar el valor de la columna de stock en la tabla de productos
            $actualizar_stock = "UPDATE productos SET stock = $nuevo_stock WHERE id = $producto_id";
            // Ejecutar la consulta de actualización

            // Agregar el producto al carrito
            $_SESSION['carrito'][] = array(
                'id' => $producto_id,
                'img' => $imagen_producto,
                'nombre' => $nombre_producto,
                'precio' => $precio_producto,
                'cantidad'=> $cantidad_producto
            );
            header("location: " . ROOT_URL . "producto.php?id=" . $producto_id);
            
        } else {
            echo "
            <script>
            alert('No hay suficiente stock disponible');
            window.location.href='index.php'
            </script>
            ";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($connection);
    }
}

//Desde pagina de productos
if(isset($_POST['añadir'])){
    $producto_id = $_POST['id'];
    $imagen_producto = $_POST['img'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $cantidad_producto = $_POST['cantidad'];

    $check_producto = array_column( $_SESSION['carrito'], 'nombre');
    if(in_array($nombre_producto, $check_producto)){
        echo "
        <script>
        alert('El producto ya está en el carrito');
        window.location.href='all-productos.php'
        </script>
        ";
    }
    else {
        $_SESSION['carrito'][] = array(
            'id' => $producto_id,
            'img' => $imagen_producto,
            'nombre' => $nombre_producto,
            'precio' => $precio_producto,
            'cantidad'=> $cantidad_producto);
            header("location: all-productos.php");
    }
}

//Borrar producto del carrito
if(isset($_POST['remove'])){
    foreach($_SESSION['carrito'] as $key => $value){
        if($value['nombre'] === $_POST['item']){
            unset($_SESSION['carrito'][$key]);
            $_SESSION['carrito'] = array_values( $_SESSION['carrito'] );
            header('location:vistaCarrito.php');
        }
    }
}
//Actualizar cantidad del producto en el carrito
// if(isset($_POST['update'])){
//     $producto_id = $_POST['id'];
//     $imagen_producto = $_POST['img'];
//     $nombre_producto = $_POST['nombre'];
//     $precio_producto = $_POST['precio'];
//     $cantidad_producto = $_POST['cantidad'];

//     foreach($_SESSION['carrito'] as $key => $value){
//         if($value['nombre'] === $_POST['item']){
//             $_SESSION['carrito'][$key] = array(
//                 'id' => $producto_id,
//                 'img' => $imagen_producto,
//                 'nombre' => $nombre_producto,
//                 'precio' => $precio_producto,
//                 'cantidad'=> $cantidad_producto);
//                 header('location:vistaCarrito.php');
//         }
//     }
// }

if (isset($_POST['update'])) {
    $producto_id = $_POST['key']; // Obtén el identificador único del producto
    $nueva_cantidad = $_POST['cantidad']; // Obtén la nueva cantidad actualizada

    // Recorre la sesión $_SESSION['carrito'] y actualiza la cantidad del producto correspondiente
    foreach ($_SESSION['carrito'] as $key => $value) {
        if($value['nombre'] === $_POST['item']) {
            $_SESSION['carrito'][$key]['cantidad'] = $nueva_cantidad;
            break; // Termina el bucle una vez que se actualiza la cantidad
        }
    }
    header('location:vistaCarrito.php');
}


?>