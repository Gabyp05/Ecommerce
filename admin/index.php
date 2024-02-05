<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

//FETCH CURRENT USER FROM DATABASE
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

// Obtener ordenes del usuario logeado 
$query_orden = "SELECT * FROM ordenes ORDER BY id DESC LIMIT 8";
$ordenes = mysqli_query($connection, $query_orden);

//Total de ventas
$sql = "SELECT SUM(total) AS total_ventas FROM ordenes";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalVentas = $row["total_ventas"];
} else {
    $totalVentas = 0;
}

$sql_entregado = "SELECT SUM(total) AS total_ventas_entregado FROM ordenes WHERE estatus_id = 4";
$resultado = mysqli_query($connection, $sql_entregado);
if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $totalEntregado = $row["total_ventas_entregado"];
} else {
    $totalEntregado = 0;
}

$sql_pendiente = "SELECT SUM(total) AS total_pendiente FROM ordenes WHERE estatus_id = 1";
$resultado = mysqli_query($connection, $sql_pendiente);
if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $totalPendiente = $row["total_pendiente"];
} else {
    $totalPendiente = 0;
}

// Consulta para obtener el total de órdenes
$sql = "SELECT COUNT(*) AS total_ordenes FROM ordenes";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado de la consulta
    $row = mysqli_fetch_assoc($result);
    $total_ordenes = $row["total_ordenes"];
} else {
    echo "No se encontraron órdenes.";
}

// Consulta para obtener el total de órdenes entregadas
$consulta = "SELECT COUNT(*) AS total_entregado FROM ordenes WHERE estatus_id = 4";
$resultado = mysqli_query($connection, $consulta); 
if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado de la consulta
    $row = mysqli_fetch_assoc($resultado);
    $total_entregado = $row["total_entregado"];
}

?>
    
        <!-- ================= END OF ASIDE =================  -->
        <main>
            <h1>Dashboard</h1>

            <!-- <div class="date">
                <input type="date">
            </div> -->

            <div class="insights">
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Ventas</h3>
                            <h1>$<?= $totalVentas ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Último mes</small>
                </div>
                 <!-- ================= END OF SALES =================  -->
                <div class="expenses">
                    <span class="material-icons-sharp">bar_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Completados</h3>
                            <h1>$<?= $totalEntregado ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>62%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Último mes</small>
                </div>
             <!-- ================= END OF EXPENSES =================  -->
                <div class="income">
                    <span class="material-icons-sharp">stacked_line_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Ingreso Pendiente</h3>
                            <h1>$<?= $totalPendiente ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>44%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Último mes</small>
                </div>
                 <!-- ================= END OF INCOME =================  -->
            </div>
            <!-- ================= END OF INSIGHTS =================  -->

            <div class="recent-orders">
                <h2>Ordenes Recientes</h2>
                <?php if(mysqli_num_rows($ordenes)> 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Número de Orden</th>
                            <th>Fecha</th>
                            <th>Método de Pago</th>
                            <th>Estatus</th>
                            <th></th>
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
                            <td style="color:<?php if($status_nombre['nombre'] == 'Pendiente'){ echo 'red'; }
                        elseif($status_nombre['nombre'] == 'Pagado'){ echo 'green'; }
                        elseif($status_nombre['nombre'] == 'Entregado'){ echo 'green'; }
                        else{ echo 'orange'; }; ?>">
                                <?= $status_nombre['nombre'] ?>
                            </td>
                            <td class="primary"><a href="<?=ROOT_URL?>admin/detalle-orden.php?id=<?=$orden['id']?>">Detalles</a></td>
                        </tr>
                        <?php endwhile ?>
                </table>
                <?php endif ?>
                <a href="ordenes.php">Ver Todo</a>
            </div>
        </main>
        <!-- ================= END OF MAIN =================  -->

        <div class="right">
            <!-- <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo $avatar['nombre']?></b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="<?= ROOT_URL . 'img/' . $avatar['avatar'] ?>">
                    </div>
                </div>
            </div>

            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="images/profile-2.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of nigth lion tech GPS drome.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>
                </div>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="images/profile-3.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of nigth lion tech GPS drome.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>
                </div>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="images/profile-4.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of nigth lion tech GPS drome.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>
                </div>
            </div> -->
        
        <!-- ================= END OF RECENT UPDATES =================  -->

            <div class="sales-analytics">
                <!-- <h2>Sales Analytics</h2> -->
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">shopping_cart</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ORDENES RECIBIDAS</h3>
                            <small class="text-muted">Últimas 24 Horas</small>
                        </div>
                        <h5 class="success">+39%</h5>
                        <h3><?= $total_ordenes ?></h3>
                    </div>
                </div>
                <div class="item offline">
                    <div class="icon">
                        <span class="material-icons-sharp">local_mall</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>PEDIDOS ENTREGADOS</h3>
                            <small class="text-muted">Últimas 24 Horas</small>
                        </div>
                        <h5 class="success">+17%</h5>
                        <h3><?= $total_entregado ?></h3>
                    </div>
                </div>
                <div class="item customers">
                    <div class="icon">
                        <span class="material-icons-sharp">person</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>NUEVOS CLIENTES</h3>
                            <small class="text-muted">Últimas 24 Horas</small>
                        </div>
                        <h5 class="success">25%</h5>
                        <h3>849</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                    
                        <span class="material-icons-sharp">add</span>
                        <a href="add-producto.php"><h3>Agregar Producto</h3></a>
                    
                    </div>
                </div>
            </div>
        </div>
</div>
<?php include '../admin/templates/footer.php'; ?>