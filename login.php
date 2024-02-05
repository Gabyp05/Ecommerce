<?php 
include 'templates/header.php';

$usuario= $_SESSION['signin-data']['usuario'] ?? null;
$contraseña = $_SESSION['signin-data']['contraseña'] ?? null;

unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/FRUTALIA-LOGO-02-azul-3-32x32.png">
    <link rel="stylesheet" href="<?= ROOT_URL?>/css/registro.css">
    <link rel="stylesheet" href="<?= ROOT_URL?>/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="nav container">
        <!-- LOGO -->
        <a href="<?= ROOT_URL ?>index.php" class="logo"><i class='bx bx-store'></i>frutalia</a>
        <!-- MENU ICON -->
        <input type="checkbox" name="" id="menu">
        <label for="menu"><i class='bx bx-menu' id="menu-icon"></i></label>
        <!-- NAV LIST -->
        <ul class="navbar">
            <li><a href="<?= ROOT_URL ?>index.php">Inicio</a></li>
            <li><a href="<?= ROOT_URL ?>nosotros.php">Nosotros</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="<?= ROOT_URL ?>all-productos.php">Productos</a></li>
            <?php if(isset($_SESSION['user-id'])) : ?>
            <li><a href="<?= ROOT_URL ?>carrito.php"><i class='bx bxs-cart' ></i></a></li>
            <li><a href="<?= ROOT_URL ?>logout.php" class="btnn">Cerrar Sesión</a></li>
            <?php else : ?>
            <!-- LOGIN BUTTON -->
            <li><a href="<?= ROOT_URL ?>login.php" id="btnn" class="btnn">Ingresar</a></li>
            <?php endif ?>
        </ul>
    </div>
</header>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Accede a tu cuenta</h2>
        <?php if(isset($_SESSION['signup-success'])) : ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']); 
                    ?>
                </p>
            </div>
        <?php elseif(isset($_SESSION['signin'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']); ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL?>login-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="usuario" value="<?= $usuario ?>" placeholder="Nombre de Usuario">
            <input type="password" name="contraseña" value="<?= $contraseña ?>" placeholder="Contraseña">
            <button type="submit" name="submit" class="btn">Ingresar</button>
            <span>No tienes una cuenta? <a href="signup.php">Registrarse</a></span>
        </form>
    </div>
</section>
