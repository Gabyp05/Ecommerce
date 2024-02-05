<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

if (isset($_GET['id'])) {
    $numero_orden = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql_detalle_orden = "SELECT * FROM detalle_orden WHERE orden_id = '$numero_orden'";
    $resultado_detalle_orden = mysqli_query($connection, $sql_detalle_orden);
    
    // Obtener el estatus de la orden
    $orden_query = "SELECT estatus_id FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $estatus_id = mysqli_fetch_assoc($orden_result)['estatus_id'];

    // Obtener el nombre del estatus desde la tabla estatus
    $status_query = "SELECT nombre FROM estatus WHERE id = $estatus_id";
    $status_result = mysqli_query($connection, $status_query);
    $status_nombre = mysqli_fetch_assoc($status_result)['nombre'];

    //obtener los productos
    $sql_detalle = "SELECT detalle_orden.*, productos.nombre 
                          FROM detalle_orden 
                          INNER JOIN productos ON detalle_orden.producto_id = productos.id 
                          WHERE detalle_orden.id = '$numero_orden'";
    $resultado_detalle = mysqli_query($connection, $sql_detalle_orden);

    // Obtener el total de la compra
    $orden_query = "SELECT * FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $orden_total = mysqli_fetch_assoc($orden_result);
   
} else {
    echo "No se ha proporcionado el número de orden.";
}


?>

<main>
    <br>
    <h2>Orden #<?= $numero_orden ?></h2><br>
    <h2>Estado: <span style="color:<?php if($status_nombre == 'Pendiente'){ echo 'red'; }
                                    elseif($status_nombre == 'Pagado'){ echo 'green'; }
                                    elseif($status_nombre == 'Entregado'){ echo 'green'; }
                                    else{ echo 'orange'; }; ?>"><?= $status_nombre ?></span>
    </h2>


    <div class="recent-orders"> 
        <table style="font-size: 16px;">
            
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th><a href="<?= ROOT_URL ?>admin/orden-pdf.php?id=<?=$numero_orden?>" target="_blank"><i class='bx bxs-file-pdf' style="font-size: 25px;"></i></a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($resultado_detalle_orden)) : ?>
                <?php 
                //obtener imagen del producto desde la tabla productos usando el nombre del producto
                $producto = $row['producto_id'];
                $producto_query = "SELECT * FROM productos WHERE id='$producto'";
                $producto_result = mysqli_query($connection, $producto_query);
                $producto = mysqli_fetch_assoc($producto_result);
                $total = $row['cantidad'] * $producto['precio'];
                $total_formateado = number_format($total, 2);
                ?>
                <tr>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $row['cantidad'] ?></td>
                    <td>$<?= $producto['precio'] ?></td>
                    <td>$<?= $total_formateado ?></td>
                </tr>
                
                <?php endwhile ?>
                
            </tbody><br>
            <tr style="border:none;">
                <td></td>
                <td></td>
                <td style="border:none;"><h1>Total:<h1></td>
                <td style="border:none;"><h1><?= number_format($orden_total['total'],2)  ?></h1></td>
            </tr>
            
        
    </div>
    
</main>