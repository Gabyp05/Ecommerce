<?php include 'templates/header.php'; 

// Obtener ordenes del usuario logeado 
$current_user_id = $_SESSION['user-id'];
$query = "SELECT * FROM ordenes WHERE usuario_id=$current_user_id ORDER BY id DESC";
$ordenes = mysqli_query($connection, $query);



?>
<link rel="stylesheet" href="<?= ROOT_URL?>/css/carrito.css">
    <section id="cart-container" class="empty__page container" style="height: 70vh; place-content: center; display: grid; align-items: center; justify-content:center; justify-items:center; ">
        <h1 class="font-weight-bold pt-5">Mis pedidos</h1><br>
        
        <?php if(mysqli_num_rows($ordenes)> 0) : ?>
            <table class="table-dark table-bordered text-center">
                <thead>
                    <tr>
                        <td>No. Orden</td>
                        <td>Total</td>
                        <td>Fecha de compra</td>
                        <td>Método de Pago</td>
                        <td>Estatus</td>
                        <td>Ver</td>
                        <td>Imprimir</td>
                    </tr>
                </thead>
                <tbody>
                    <?php while($orden = mysqli_fetch_assoc($ordenes)) : ?>
                    <?php 
                        $status = $orden['estatus_id'];
                        $status_query = "SELECT * FROM estatus WHERE id = $status";
                        $status_result = mysqli_query($connection, $status_query);
                        $status_nombre = mysqli_fetch_assoc($status_result); 
                    ?>
                    <tr>
                        <td><?= $orden['id'] ?></td>
                        <td>$<?= $orden['total'] ?></td>
                        <td><?= $orden['created_at'] ?></td>
                        <td><?= $orden['metodo_pago'] ?></td>
                        <td>
                            <span style="color:<?php if($status_nombre['nombre'] == 'Pendiente'){ echo 'red'; }
                            elseif($status_nombre['nombre'] == 'Pagado'){ echo 'green'; }
                            elseif($status_nombre['nombre'] == 'Entregado'){ echo 'green'; }
                            else{ echo 'orange'; }; ?>"><?= $status_nombre['nombre']; ?>
                            </span>
                        </td>
                        <td><a href="<?=ROOT_URL?>ver.php?id=<?=$orden['id']?>" ><i class="uil uil-eye"></i></a></td>
                        <td><a href="<?= ROOT_URL ?>recibo.php?id=<?=$orden['id']?>" target="_blank"><i class='bx bxs-file-pdf' style="font-size: 25px;"></i></a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert__message error">
                <?= "Aún no has realizado una orden de compra" ?>
            </div>
            <a href="all-productos.php" class="btnn" style="color:#fff;">Ver Productos</a>
        <?php endif ?>
    </section>
      
    
    
    
    
    

<?php include 'templates/footer.php'; ?>