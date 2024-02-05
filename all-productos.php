<?php 
include 'templates/header.php'; 

//obtener todos los productos desde la BD
$query = "SELECT * FROM productos";
$productos = mysqli_query($connection, $query);


?>

        <div class="heading" style="margin-top: 8rem;">
            <h2>Todos los Productos</h2>
        </div>

        <section class="properties container" id="properties">
            <div class="properties-container container">
                <?php while ($producto = mysqli_fetch_assoc($productos)) : ?>
                <form action="cart-logic-stock.php" method="POST" enctype="multipart/form-data">
                    <div class="box <?php if ($producto['stock'] == 0) echo 'agotado'; ?>">
                    <?php if ($producto['stock'] == 0) : ?>
                        <h1 style="position: absolute; padding: 15px 25px; overflow: overlay; z-index: 2;">Agotado</h1>
                    <?php endif; ?>
                    <img src="./img/<?= $producto['imagen'] ?>">
                    <?php if ($producto['stock'] > 0) : ?>
                        <h3>$<?= $producto['precio'] ?></h3>  
                    <?php endif; ?>
                    <div class="content producto">
                        <div class="text">
                        <h3><a href="<?= ROOT_URL ?>producto.php?id=<?= $producto['id'] ?>" style="text-decoration: none;"><?= $producto['nombre'] ?></a></h3>
                        <p><?= $producto['detalle'] ?></p>
                        </div>
                        <?php if ($producto['stock'] > 0 && isset($_SESSION['user-id'])) : ?>
                        <input type="number" name="cantidad" min="1" max="11" value="1" placeholder="Cantidad">
                        <input type="hidden" name="id" id="id" value="<?php echo $producto['id']; ?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo $producto['precio']; ?>">
                        <input type="hidden" name="img" id="imagen" value="<?php echo $producto['imagen']; ?>">
                        <div class="icon">
                            <button style="border: none; cursor: pointer; background: transparent;" type="submit" name="añadir"><i class='bx bxs-cart-add'></i></button>
                        </div>
                        <?php endif; ?>
                    </div>
                    </div>
                </form>
                <?php endwhile ?>
            </div>
        </section>


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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<?php include 'templates/footer.php'; ?>