<?php 
include 'templates/header.php'; 

//obtener 6 productos desde la BD
$query = "SELECT * FROM productos ORDER BY id DESC LIMIT 6";
$productos = mysqli_query($connection, $query);
?>
    <!-- HOME -->
    <?php if(isset($_SESSION['user-id'])) : ?>
    <section class="home-user container" id="home">
        <div class="home-text">
            <h1>Disfruta de nuestras ofertas!<br>Compra ahora</h1>
            <a href="all-productos.php" class="btnn">Ver Todo</a>
        </div>
    </section>
    <?php else : ?>
    <section class="home container" id="home">
        <div class="home-text">
            <h1>Consigue las<br>mejores ofertas<br>aqui.</h1>
            <a href="#" class="btnn">Registrarse</a>
        </div>
    <?php endif ?>
    </section>
    <?php if(isset($_SESSION['user-id'])) : ?>
    <!-- ABOUT -->
        <section class="about container" id="about">
            <div class="grid">
                <div class="about-imgg">
                    <img src="images/NoFound.png">
                </div>
                <div class="about-text">
                    <span>Categoria</span>
                    <h2>Nuestro producto estrella</h2>
                    <p>Nombre del Producto</p>
                    <p>Descripción del producto estrella.</p>
                    <a href="#" class="btnn">Comprar</a>
                </div>
            </div>
        </section>
    <?php else : ?>
    <!-- ABOUT -->
        <section class="about container" id="about">
            <div class="about-img">
                <img src="images/About-frutalia.jpg">
            </div>
            <div class="about-text">
                <span>Nosotros</span>
                <h2>Más de 60 años creciendo contigo!</h2>
                <p>Frutalia es un empresa creada en el año 1962 con el objetivo de fabricar esencias, sabores y colorantes para la industria alimenticia en general; como panaderías, pastelerías, galleteras, heladerías y afines.</p>
                <p>A través de los años Frutalia crea nuevos productos como mezcla para helados, granizados, jarabes, entre otros: apliando así su gama de productos.</p>
                <a href="nosotros.php" class="btnn">Leer Más</a>
            </div>
        </section>
    <?php endif ?>
    <!-- SALES -->
    <section class="sales container" id="sales">
        <!-- box 1 -->
        <div class="box">
            <i class='bx bxs-star'></i>
            <h3>Productos de Calidad</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus, assumenda?</p>
        </div>
        <!-- box 2 -->
        <div class="box">
            <i class='bx bxs-truck' ></i>
            <h3>Delivery Gratis</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus, assumenda?</p>
        </div>
        <!-- box 3 -->
        <div class="box">
            <i class='bx bxs-offer' ></i>
            <h3>Precios Increíbles</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus, assumenda?</p>
        </div>
    </section>
    <!-- PROPERTIES -->
    <section class="properties container" id="properties">
        <div class="heading">
            <span>Recientes</span>
            <h2>Productos más vendidos</h2>
            <p>Hola! Estos productos te podrían interesar<br>Consigue las mejores ofertas.</p>
        </div>
        <div class="properties-container container">
        <?php while($producto = mysqli_fetch_assoc($productos)) : ?>
            <div class="box">
                <img src="<?=$producto['imagen']?>">
                <h3>$<?=$producto['precio']?></h3>
                <div class="content">
                    <div class="text">
                        <h3><?=$producto['nombre']?></h3>
                        <p><?=$producto['detalle']?></p>
                    </div>
                    <div class="icon">
                        <i class='bx bxs-cart-add' ></i>
                    </div>
                </div>
            </div>
            <?php endwhile ?>
        </div>
        <div class="feet">
            <a href="all-productos.php" class="btnn">Ver Todo</a>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include 'templates/footer.php'; ?>
    
</body>
</html>

