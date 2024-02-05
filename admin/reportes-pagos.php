<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

$query = "SELECT ordenes.*, users.nombre, users.apellido 
          FROM ordenes 
          INNER JOIN users ON ordenes.usuario_id = users.id 
          ORDER BY ordenes.id DESC";

$ordenes = mysqli_query($connection, $query);



while ($orden = mysqli_fetch_assoc($ordenes)) {
    $orden_id = $orden['id'];
    // Obtener nombre y apellido del usuario
    $nombre_usuario = $orden['nombre'];
    $apellido_usuario = $orden['apellido'];

}

$query = "SELECT * FROM pagos ORDER BY id DESC";
$pagos = mysqli_query($connection, $query);


?>
<main>
    <div class="titulo__pago">
        <br><h1>Reportes de Pagos</h1>
        <a href="<?= ROOT_URL ?>admin/pagos.php" target="_blank">
            <i class='bx bxs-file-pdf' style="font-size: 29px;"></i>
        </a>
    </div>
            
    <div class="recent-orders">
        <?php if(mysqli_num_rows($pagos)> 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>N° Orden</th>
                    <th>Banco</th>
                    <th>Monto</th>
                    <th>N° Referencia</th>
                    <th>Estatus</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
            <?php while($pago = mysqli_fetch_assoc($pagos)) : ?>
            <?php   
                $pagoId = $pago['id'];

                $query = "SELECT p.*, o.usuario_id, u.nombre, u.apellido
                        FROM pagos p
                        JOIN ordenes o ON p.orden_id = o.id 
                        JOIN users u ON o.usuario_id = u.id
                        WHERE p.id = $pagoId";
                $result = mysqli_query($connection, $query);
                $user = mysqli_fetch_assoc($result);   
            ?>
                <tr>
                    <td><?= $user['nombre'] . ' ' . $user['apellido'] ?></td>
                    <td><?= $pago['orden_id'] ?></td>
                    <td><?= $pago['banco'] ?></td>
                    <td><?= $pago['monto'] ?></td>
                    <td><?= $pago['referencia'] ?></td>
                    <td>
                        <select class="estatus-select" data-pago-id="<?= $pago['id'] ?>" style="color:<?php if($pago['estatus'] == 'Pendiente'){ echo 'red'; }
                                    elseif($pago['estatus'] == 'Aprobado'){ echo 'green'; }
                                    elseif($pago['estatus'] == 'En proceso'){ echo 'orange'; }
                                    else{ echo 'black'; }; ?>">
                            <option value="Pendiente" <?php if ($pago['estatus'] == 'Pendiente') echo 'selected' ?> style="color: black;">Pendiente</option>
                            <option value="Aprobado" <?php if ($pago['estatus'] == 'Aprobado') echo 'selected' ?> style="color: black;">Aprobado</option>
                            <option value="En proceso" <?php if ($pago['estatus'] == 'En proceso') echo 'selected' ?> style="color: black;">En proceso</option>
                        </select>
                    </td>
                </tr>
                <?php endwhile ?>
        </table>
 
        <?php endif ?>        
    </div>
</main>
<script>
    const estatusSelects = document.querySelectorAll('.estatus-select');
    estatusSelects.forEach(select => {
 
        select.addEventListener('change', function() {
            const pagoId = this.dataset.pagoId;
            const nuevoEstatus = this.value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'actualizar-estatus.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(`pagoId=${pagoId}&nuevoEstatus=${nuevoEstatus}`);
        });
    });
</script>

