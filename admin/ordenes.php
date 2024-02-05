<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

$query = "SELECT * FROM ordenes ORDER BY id DESC";
$ordenes = mysqli_query($connection, $query);

$estatus_query = "SELECT * FROM estatus";
$estatus = mysqli_query($connection, $estatus_query);

?>

<main>
            <br><h1>Ordenes</h1>
    <div class="recent-orders">
        <!-- <h2>Lista de Ordenes</h2> -->
        <?php if(mysqli_num_rows($ordenes)> 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Número de Orden</th>
                    <th>Fecha</th>
                    <th>Método de Pago</th>
                    <th>Total</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
            <?php while($orden = mysqli_fetch_assoc($ordenes)) : ?>
                <?php 
                // Obtener nombre y apellido del usuario
                $usuario_id = $orden['usuario_id'];
                $usuario_query = "SELECT nombre, apellido FROM users WHERE id = $usuario_id";
                $usuario_result = mysqli_query($connection, $usuario_query);
                $nombre_usuario = mysqli_fetch_assoc($usuario_result);

                $status = $orden['estatus_id'];
                $status_query = "SELECT * FROM estatus WHERE id = $status";
                $status_result = mysqli_query($connection, $status_query);
                $status_nombre = mysqli_fetch_assoc($status_result);
                ?>
                <tr>
                    <td><?= $nombre_usuario['nombre'] . ' ' . $nombre_usuario['apellido'] ?></td>
                    <td><?= $orden['id'] ?></td>
                    <td><?= $orden['created_at'] ?></td>
                    <td><?= $orden['metodo_pago'] ?></td>
                    <td>$<?= $orden['total'] ?></td>
                    <td>
                        <span style="color:<?php if($status_nombre['nombre'] == 'Pendiente'){ echo 'red'; }
                        elseif($status_nombre['nombre'] == 'Pagado'){ echo 'green'; }
                        elseif($status_nombre['nombre'] == 'Entregado'){ echo 'green'; }
                        else{ echo 'orange'; }; ?>"><?= $status_nombre['nombre']; ?>
                        </span>
                    </td>
                    <td><a href="<?= ROOT_URL ?>admin/editar-orden.php?id=<?=$orden['id']?>" class="btn sm">Actualizar</a></td>
                    <td><a href="<?=ROOT_URL?>admin/detalle-orden.php?id=<?=$orden['id']?>" ><i class="uil uil-eye" style="font-size: 18px;"></i></a></td>
                </tr>
                <?php endwhile ?>
        </table>
 
        <?php endif ?>

        <!-- <span style="color:<?php if($status_nombre['nombre'] == 'Pendiente'){ echo 'orange'; }else{ echo 'green'; }; ?>"><?= $status_nombre['nombre']; ?></span>        -->
        
    </div>
</main>