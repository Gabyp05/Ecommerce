<?php 
include 'templates/header.php'; 

//obtener 6 productos desde la BD
$query = "SELECT * FROM productos ORDER BY id DESC LIMIT 6";
$productos = mysqli_query($connection, $query);


$consulta = "SELECT p.* FROM detalle_orden AS do JOIN ordenes AS o ON do.orden_id = o.id JOIN productos AS p ON do.producto_id = p.id
GROUP BY p.id ORDER BY SUM(do.cantidad) DESC LIMIT 1";
$producto_estrella = mysqli_query($connection, $consulta);




?>
<style>
    .custom-confirm-button-class {
        color: var(--main-color); 
    }
</style>
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
            <a href="signup.php" class="btnn">Registrarse</a>
        </div>
    <?php endif ?>
    </section>
    <?php if(isset($_SESSION['user-id'])) : ?>
    <!-- ABOUT -->
        <section class="about container" id="about">
        <?php while($producto = mysqli_fetch_assoc($producto_estrella)) : ?>
            <div class="grid">
                <div class="about-imgg">
                    <img src="./img/<?=$producto['imagen']?>">
                </div>
                <?php 
                    $id_categoria=$producto['id_categoria'];
                    $categoria_query = "SELECT nombre FROM categoria WHERE id=$id_categoria";
                    $categoria_result = mysqli_query($connection, $categoria_query);
                    $categoria = mysqli_fetch_assoc($categoria_result);    
                ?>
                <div class="about-text">
                    <!-- <span><?=$categoria['nombre']?></span> -->
                    <span style="font-size: 2rem;"><i class='bx bxs-star' ></i><i class='bx bxs-star' ></i><i class='bx bxs-star' ></i><i class='bx bxs-star' ></i><i class='bx bxs-star' ></i></span>
                    <h2>Producto estrella:</h2>
                    <h1><?=$producto['nombre']?></h1>
                    <p><?=$producto['detalle']?></p>
                    <p><?=$producto['descripción']?></p>
                    <a href="<?=ROOT_URL?>producto.php?id=<?=$producto['id']?>" class="btnn">Comprar</a>
                </div>
            </div>
        <?php endwhile ?>
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
                <form action="cart-logic-stock.php" method="POST" enctype="multipart/form-data">
                    <div class="box <?php if ($producto['stock'] == 0) echo 'agotado'; ?>">
                        <?php if ($producto['stock'] == 0) : ?>
                            <h1 style="position: absolute; padding: 15px 25px;overflow: overlay;z-index: 2;">Agotado</h1>
                        <?php endif; ?>
                        <img style="height: 220px;" src="./img/<?=$producto['imagen']?>">
                        <?php if ($producto['stock'] > 0) : ?>
                            <h3>$<?= $producto['precio'] ?></h3>  
                        <?php endif; ?>
                        <div class="content producto">
                            <div class="text">
                                <h3><a href="<?=ROOT_URL?>producto.php?id=<?=$producto['id']?>" style="text-decoration: none;"><?=$producto['nombre']?></a></h3>
                                <p><?=$producto['detalle']?></p>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?php echo $producto['id'];?>">
                            <input type="hidden" name="nombre" id="nombre" value="<?php echo $producto['nombre'];?>">
                            <input type="hidden" name="precio" id="precio" value="<?php echo $producto['precio'];?>">
                            <?php if(isset($_SESSION['user-id']) && $producto['stock'] > 0) : ?>
                                <input type="number" name="cantidad" min="1" max="11" value="1" placeholder="Cantidad">
                                <div class="icon">
                                    <button style="border: none; cursor: pointer; background: transparent;" type="submit" name="addCart"><i class='bx bxs-cart-add' ></i></button>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="img" id="imagen" value="<?php echo $producto['imagen'];?>">
                        </div>
                    </div>
                </form>
            <?php endwhile ?>
        </div>

        <div class="feet">
            <a href="all-productos.php" class="btnn">Ver Todo</a>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include 'templates/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
    var addCartButtons = document.querySelectorAll('button[name="addCart"]');

    addCartButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
        // Verificar si el usuario está logeado
        var isLoggedIn = <?php echo isset($_SESSION['user-id']) ? : 'false'; ?>;

        if (!isLoggedIn) {
            event.preventDefault(); // Evitar que se envíe el formulario

            // Mostrar el mensaje modal utilizando SweetAlert2
            Swal.fire({
            title: 'Inicia sesión para agregar productos al carrito',
            text: 'Por favor, inicia sesión para poder agregar productos al carrito.',
            icon: 'warning',
            showCancelButton: false,
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'custom-confirm-button-class'
            }
            })
        }
        });
    });
    });
</script>

</body>
</html>

