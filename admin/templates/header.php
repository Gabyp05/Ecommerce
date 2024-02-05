<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= ROOT_URL?>/images/FRUTALIA-LOGO-02-azul-3-32x32.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
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