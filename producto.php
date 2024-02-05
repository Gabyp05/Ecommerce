<?php 
include 'templates/header.php'; 

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM productos WHERE id=$id";
    $productos = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'index.php');
    die();
}

?>
<link rel="stylesheet" href="<?= ROOT_URL?>/css/detalle-producto.css">
<!-- ========= ARCHIEVEMENTS ========= -->
<section class="about__achievements">
<?php while($producto = mysqli_fetch_assoc($productos)) : ?>
    <div class="product-details-container">
    <div class="product-image">
        <img src="./img/<?=$producto['imagen']?>" alt="Imagen del producto">
    </div>
    <form action="cart-logic-stock.php" method="POST" enctype="multipart/form-data">
        <div class="product-info">
        <input type="hidden" name="id" id="id" value="<?php echo $producto['id'];?>">
        <input type="hidden" name="nombre" id="nombre" value="<?php echo $producto['nombre'];?>">
        <input type="hidden" name="precio" id="precio" value="<?php echo $producto['precio'];?>">
        <input type="hidden" name="img" id="imagen" value="<?php echo $producto['imagen'];?>">
            <h3>Detalles del producto</h3>
            <h1><?=$producto['nombre']?></h1>
            <h3>Precio: $<strong><?=$producto['precio']?></strong></h3>
            <h3 style="font-size: 14px;">Detalle:</h3>
            <p><?=$producto['detalle']?></p>
            <h3 style="font-size: 14px;">Descripción:</h3>
            <p><?=$producto['descripción']?></p>

            <div class="botones"> 
                <?php if(isset($_SESSION['user-id'])) : ?>
                    <h3>Agregar al carrito</h3>
                <input type="number" name="cantidad" min="1" max="11" value="1" placeholder="Cantidad">
                <button class='agregar' style="border: none; cursor: pointer; background: transparent;" type="submit" name="comprar"><i class='bx bxs-cart-add' ></i></button>
                <?php endif ?>
            </div>
        </div>
    </form>
    </div>
<?php endwhile ?>
</section>
<!-- ========= END OF ARCHIEVEMENTS ========= -->

<?php include 'templates/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
    var botonesAgregar = document.querySelectorAll('.agregar');

    botonesAgregar.forEach(function(boton) {
      boton.addEventListener('click', function(event) {

        

        Swal.fire({
          icon: 'success',
          title: 'Producto agregado al carrito',
          showConfirmButton: false,
          timer: 2000
        })
      });
    });
</script>
</body>
</html>