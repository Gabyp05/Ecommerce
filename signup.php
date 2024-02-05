<?php 
require 'config/constants.php';

// GET BACK FORM DATA IF THERE WAS A REGISTRATION ERROR
$nombre = $_SESSION['signup-data']['nombre'] ?? null;
$apellido = $_SESSION['signup-data']['apellido'] ?? null;
$usuario = $_SESSION['signup-data']['usuario'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

// DELETE SIGNUP DATA SESSION
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
            <li><a href="<?= ROOT_URL ?>contact-page.php">Contacto</a></li>
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
        <h2>Registro de usuario</h2>
        <?php if (isset($_SESSION['signup'])) : ?>
        <div class="alert__message error">
            <p>
                <?= $_SESSION['signup'];
                unset($_SESSION['signup']);                            
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="nombre" value="<?= $nombre ?>" placeholder="Nombre">
            <input type="text" name="apellido" value="<?= $apellido ?>" placeholder="Apellido">
            <input type="text" name="usuario" value="<?= $usuario ?>" placeholder="Nombre de Usuario">
            <input type="email"name="email" value="<?= $email ?>" placeholder="Correo">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Contraseña">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirmar Contraseña">
            <div class="form__control">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Registrarse</button>
            <span>Ya tienes una cuenta? <a href="login.php">Ingresar</a></span>
        </form>
    </div>
</section>
</body>
</html>