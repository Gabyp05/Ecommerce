<?php

include 'templates/header.php';

// Obtener ordenes del usuario logeado
$current_user_id = $_SESSION['user-id'];

if (isset($_GET['id'])) {
    $numero_orden = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql_detalle_orden = "SELECT * FROM detalle_orden WHERE orden_id = '$numero_orden'";
    $resultado_detalle_orden = mysqli_query($connection, $sql_detalle_orden);

    // Obtener el total de la compra
    $orden_query = "SELECT * FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $orden_total = mysqli_fetch_assoc($orden_result);

    // Obtener el estatus de la orden
    $orden_query = "SELECT estatus_id FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $estatus_id = mysqli_fetch_assoc($orden_result)['estatus_id'];

     // Obtener el nombre del estatus desde la tabla estatus
     $status_query = "SELECT nombre FROM estatus WHERE id = $estatus_id";
     $status_result = mysqli_query($connection, $status_query);
     $status_nombre = mysqli_fetch_assoc($status_result)['nombre'];
} else {
    echo "No se ha proporcionado el número de orden.";
}
?>

<link rel="stylesheet" href="<?= ROOT_URL?>/css/carrito.css">
    <section id="cart-container" class="empty__page container" style="height: 100vh; place-content: center; display: grid; align-items: center; justify-content:center; justify-items:center; ">
        <div class="titulo">
            <h1 class="font-weight-bold pt-5">Orden #<?= $numero_orden ?></h1>
            <h1 class="font-weight-bold pt-5">Estatus: <span style="color:<?php if($status_nombre == 'Pendiente'){ echo 'red'; }
                                                        elseif($status_nombre == 'Pagado'){ echo 'green'; }
                                                        elseif($status_nombre == 'Entregado'){ echo 'green'; }
                                                        else{ echo 'orange'; }; ?>"><?= $status_nombre ?></span>
            </h1>
            <?php
            if ($orden_total['metodo_pago'] != 'Efectivo') {
                echo "<h1 class='font-weight-bold pt-5'> <a class='btnn' id='pagarBtn' style='color: #fff;' href='pagar.php?id=$numero_orden'>Pagar <i class='bx bxs-badge-dollar' style='color: #fff;'></i></a></h1>";
            }
            ?>
        </div>

        
        
            <table class="table-dark table-bordered text-center">
                
                <thead>
                    <tr>
                        <td>Producto</td>
                        <td>   </td>
                        <td>Cantidad</td>
                        <td>Precio Unitario</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>

                <?php
                    while ($fila = mysqli_fetch_assoc($resultado_detalle_orden)) {
                    // Obtener imagen del producto desde la tabla productos usando el nombre del producto
                    $producto = $fila['producto_id'];
                    $producto_query = "SELECT * FROM productos WHERE id='$producto'";
                    $producto_result = mysqli_query($connection, $producto_query);
                    $producto = mysqli_fetch_assoc($producto_result);
                    $total = $fila['cantidad'] * $producto['precio'];
                    $total_formateado = number_format($total, 2);

                    echo "<tr>";
                    echo "<td>" . $producto['nombre'] . "</td>";
                    echo "<td><img src='./img/" . $producto['imagen'] . "' width='50px' height='50px'></td>";
                    echo "<td>" . $fila['cantidad'] . "</td>";
                    echo "<td>" .'$'. $producto['precio'] . "</td>";
                    echo "<td>" . '$' . $total_formateado . "</td>";

                    echo "</tr>";
                    }

                    echo "</table>";
                    ?>
                </tbody>
            </table><br><br>
            <div class="total-price">
                <table class="table-bordered resumen" >           
                    <tr style="border:none;">
                        <td style="border:none;"><h1>Total a Pagar<h1></td>
                        <td style="border:none;"><h3>$<?= $orden_total['total']  ?></h3></td>
                    </tr>
                </table>
            </div>

    </section>

    
