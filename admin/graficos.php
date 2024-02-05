<?php 
require '../admin/config/database.php';


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

$sql_entregado = "SELECT SUM(estatus_id) AS total_entregado FROM ordenes WHERE estatus_id = 4";
$resultado = mysqli_query($connection, $sql_entregado);
if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $totalEntregado = $row["total_entregado"];
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
// Consulta para obtener el total de órdenes pendientes
$consulta = "SELECT COUNT(*) AS total_pendiente FROM ordenes WHERE estatus_id = 1";
$resultado = mysqli_query($connection, $consulta); 
if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado de la consulta
    $row = mysqli_fetch_assoc($resultado);
    $total_pendiente = $row["total_pendiente"];
}
// Consulta para obtener el total de órdenes por entregar
$consulta = "SELECT COUNT(*) AS total_entregar FROM ordenes WHERE estatus_id = 2";
$resultado = mysqli_query($connection, $consulta); 
if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado de la consulta
    $row = mysqli_fetch_assoc($resultado);
    $total_entregar = $row["total_entregar"];
}

// PARA EL GRAFICO//

// Consulta para obtener el total de ventas
$sql = "SELECT SUM(total) AS total_ventas FROM ordenes";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalVentas = $row["total_ventas"];
} else {
    $totalVentas = 0;
}

// Consulta para obtener el total de ventas con estatus pendiente
$sql = "SELECT SUM(total) AS total_ventas FROM ordenes WHERE estatus_id = 1"; 

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalVentasPendiente = $row["total_ventas"];
} else {
    $totalVentasPendiente = 0;
}
// Liberar el resultado
mysqli_free_result($result);

// Consulta para obtener el total de ventas con estatus entregado
$sql = "SELECT SUM(total) AS total_ventas FROM ordenes WHERE estatus_id = 4"; 

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalVentasEntregado = $row["total_ventas"];
} else {
    $totalVentasEntregado = 0;
}

// Consulta para obtener el total de ventas con estatus Por entregar
$sql = "SELECT SUM(total) AS total_ventas FROM ordenes WHERE estatus_id = 3"; 

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalVentasPorEntregar = $row["total_ventas"];
} else {
    $totalVentasPorEntregar = 0;
}

// Liberar el resultado
mysqli_free_result($result);

// Obtener los datos de la base de datos // los productos
$productos = [];
$query = "SELECT * FROM productos";
$resultado = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($resultado)) {
    $productos[] = $row;
}

//nombre de los productos y stock
$productos_stock = "SELECT nombre, stock FROM productos";
$resultado_productoStock = mysqli_query($connection, $productos_stock);

$labels = array();
$data = array();
while ($row = mysqli_fetch_assoc($resultado_productoStock)) {
    $labels[] = $row['nombre'];
    $data[] = $row['stock'];
}

// Consulta SQL para obtener los nombres de los productos y el stock
$query = "SELECT nombre, stock FROM productos";
$resultado = mysqli_query($connection, $query);

// Arrays para almacenar los nombres de los productos y el stock
$productos = array();
$stock = array();

// Recorre los resultados y almacena los datos en los arrays
while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila['nombre'];
    $stock[] = $fila['stock'];
}

// Consulta SQL para obtener los datos de ventas históricas
$query = "SELECT created_at, total FROM ordenes";
$resultado = mysqli_query($connection, $query);

// Arrays para almacenar las fechas y los totales de ventas
$fechas = array();
$ventas = array();

// Recorre los resultados y almacena los datos en los arrays
while ($fila = mysqli_fetch_assoc($resultado)) {
    $fechas[] = $fila['created_at'];
    $ventas[] = $fila['total'];
}

$query= "SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad_productos
FROM categoria c
LEFT JOIN productos p ON c.id = p.id_categoria
GROUP BY c.nombre";
$resultado = mysqli_query($connection, $query);

$nombresCategorias = array();
$cantidadesProductos = array();

while ($fila = mysqli_fetch_assoc($resultado)) {
    $nombresCategorias[] = $fila['categoria'];
    $cantidadesProductos[] = $fila['cantidad_productos'];
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../images/FRUTALIA-LOGO-02-azul-3-32x32.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"/>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="grafico.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
<div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    
                    <img src="images/logo_frutalia180.png" alt="Logo">
                    <h2>FRUTALI<span class="frutalia">ADMIN</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="index.php" >
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="usuarios.php" >
                    <span class="material-icons-sharp">person</span>
                    <h3>Clientes</h3>
                </a>
                <a href="ordenes.php">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Ordenes</h3>
                </a>
                <a href="graficos.php">
                    <span class="material-icons-sharp">insights</span>
                    <h3>Gráficos</h3>
                </a>
                <a href="productos.php">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Productos</h3>
                </a>
                <a href="add-producto.php">
                    <span class="material-icons-sharp">add</span>
                    <h3>Agregar Producto</h3>
                </a>
                <a href="reportes-pagos.php">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Reportes de Pago</h3>
                </a>
                
                <a href="<?= ROOT_URL ?>logout.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Cerrar Sesión</h3>
                </a>
            </div>
        </aside>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Fetch the data from the database
    var totalVentas = <?php echo $totalVentas; ?>;
    var totalVentasPendiente = <?php echo $totalVentasPendiente; ?>;
    var totalVentasPagadas = totalVentas - totalVentasPendiente;

    // Create the chart
    var ctx = document.getElementById('ventasChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ordenes Pendientes', 'Ordenes Pagadas'],
            datasets: [{
                data: [totalVentasPendiente, totalVentasPagadas],
                backgroundColor: ['#FF6384', '#36A2EB'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB']
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Total de Ordenes'
            }
        }
    });
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Fetch the data from the database
    var totalVentasPendiente = <?php echo $total_pendiente; ?>;
    var totalVentasEntregado = <?php echo $totalEntregado; ?>;
    var totalVentasPorEntregar = <?php echo $total_entregar; ?>;

    // Create the chart
    var ctx = document.getElementById('estatusChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pendiente', 'Entregado', 'Por Entregar'],
            datasets: [{
                label: 'Total',
                data: [totalVentasPendiente, totalVentasEntregado, totalVentasPorEntregar],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            title: {
                display: false,
                text: 'Ordenes por Estatus'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('productosStockChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($data); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Stock de Productos'
                    }
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Obtén el contexto del lienzo
        var ctx = document.getElementById('grafico').getContext('2d');

        // Crea el gráfico de barras
        var grafico = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productos); ?>,
                datasets: [{
                    label: 'Stock',
                    data: <?php echo json_encode($stock); ?>,
                    backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }); });
    </script>
    <script>
         document.addEventListener('DOMContentLoaded', function() {
            // Obtén el contexto del lienzo
            var ctx = document.getElementById('graficoVenta').getContext('2d');

            // Crea el gráfico histórico de ventas
            var grafico = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($fechas); ?>,
                    datasets: [{
                        label: 'Ventas',
                        data: <?php echo json_encode($ventas); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 90,
                                minRotation: 90
                            }
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(context) {
                                var value = context.dataset.data[context.dataIndex];
                                return '$' + value;
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
         document.addEventListener('DOMContentLoaded', function() {
            // Obtén los datos de la consulta y almacénalos en arrays
            var categorias = <?php echo json_encode($nombresCategorias); ?>;
            var cantidadesProductos = <?php echo json_encode($cantidadesProductos); ?>;

            // Obtén el contexto del lienzo
            var ctx = document.getElementById('graficoCategorias').getContext('2d');

            // Crea el gráfico de categorías de productos
            var grafico = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: categorias,
                    datasets: [{
                        label: 'Cantidad de productos',
                        data: cantidadesProductos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
        <main>
            <div class="graficos">
                <h2>Status de Ordenes</h2>
                <canvas id="estatusChart"></canvas>
            </div>
            <!-- <div class="graficos">
                <h2>Stock de Productos</h2>
                <canvas id="productosStockChart"></canvas>
            </div> -->
            <div class="graficos">
                <h2>Stock de Productos</h2>
                <canvas id="grafico"></canvas>
            </div>
            <div class="graficos">
                <h2>Ingresos por Ventas</h2>
                <canvas id="graficoVenta"></canvas>
            </div>
            <div class="graficos">
                <h2>Productos por categoría</h2>
                <canvas id="graficoCategorias"></canvas>
            </div>
            
        </main>
        <!-- ================= END OF MAIN =================  -->

        
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>