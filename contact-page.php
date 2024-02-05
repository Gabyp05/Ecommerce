<?php 
require 'config/conexion.php';

//FETCH CURRENT USER FROM DATABASE
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

$count = 0;
if(isset($_SESSION['carrito'])){
   $count = count($_SESSION['carrito']);
}
?>
<link rel="stylesheet" href="<?= ROOT_URL?>/css/contact-page.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/FRUTALIA-LOGO-02-azul-3-32x32.png">
    <!-- <link rel="stylesheet" href="<?= ROOT_URL ?>registro.css"> -->
    <link rel="stylesheet" href="<?= ROOT_URL?>/css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL?>/css/contact-page.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <div class="header__user-actions">
                    <a href="<?= ROOT_URL ?>vistaCarrito.php"" class="header__action-btn">
                        <i class='bx bxs-cart cart-img'></i>
                        <span class="count" ><?php echo $count ?></span>
                    </a>                
                </div>
                
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'img/' . $avatar['avatar'] ?>">
                    </div>
                    <ul>
                        <li><p>Hey! <?php echo $avatar['nombre']?></p></li>
                        <li><a href="<?= ROOT_URL ?>vistaCarrito.php"><i class='bx bxs-cart-download' ></i></i>Mi Carrito</a></li>
                        <li><a href="<?= ROOT_URL ?>mis-ordenes.php"><i class='bx bxs-receipt' ></i>Mis Pedidos</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php"><i class='bx bx-log-out'></i>Cerrar Sesión</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="<?= ROOT_URL ?>login.php" id="btnn" class="btnn">Ingresar</a></li>
            <?php endif ?>
        </ul>
    </div>
</header>
<!-- <section class="form__section"> -->
    <div class="contenedor">
      <div class="form">
        <div class="contact-info">
          <h3 class="title">Envíanos un mensaje</h3>
          <p class="text">
            Déjanos tu mensaje y nos pondremos en contacto contigo lo más pronto posible!<br> Gracias.
          </p>

            <div class="info">
                <div class="information">
                <img src="images/location.png" class="icon" alt="" />
                <p>Calle Real de Sarría, Caracas - Venezuela</p>
                </div>
                <div class="information">
                <img src="images/email.png" class="icon" alt="" />
                <p>admin@frutalia.com</p>
                </div>
                <div class="information">
                <img src="images/phone.png" class="icon" alt="" />
                <p>+58 212 1234567</p>
                </div>
            </div>

            <div class="social-media">
                <p><br><br><br></p>
                <div class="social-icons">
                <a href="#">
                    <i class='bx bxl-facebook'></i>
                </a>
                <a href="#">
                    <i class='bx bxl-twitter'></i>
                </a>
                <a href="#">
                    <i class='bx bxl-instagram'></i>
                </a>
                </div>
            </div>
        </div>

            <div class="contact-form">

                <form action="#" method="POST" autocomplete="off">
                    <h3 class="title">Contáctanos</h3>
                    <div class="input-container">
                    <input type="text" name="name" class="input" placeholder="Nombre"/>
                    <span>Nombre</span>
                    </div>
                    <div class="input-container">
                    <input type="email" name="email" class="input" placeholder="Email" />
                    <span>Email</span>
                    </div>
                    <div class="input-container">
                    <input type="text" name="subject" class="input" placeholder="Asunto"/>
                    <span>Asunto</span>
                    </div>
                    <div class="input-container textarea">
                    <textarea name="message" class="input" placeholder="Mensaje"></textarea>
                    <span>Mensaje</span>
                    </div>
                    <input type="submit" value="Enviar" class="btn" />
                </form>
            </div>
      </div>
    </div>
<!-- </section> -->
</body>
</html>