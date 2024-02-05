<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';


//FECTH CATEGORIES FROM DATABASE
$query = "SELECT * FROM categoria";
$categorias = mysqli_query($connection, $query);

//get back form data if form was invalid
$nombre = $_SESSION['add-producto-data']['nombre'] ?? null;
$body = $_SESSION['add-producto-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-producto-data']);


?>


<!-- ================= END OF ASIDE =================  -->
<main>
    <h1>Productos</h1>
    <!-- ================= END OF INSIGHTS =================  -->

    

    <div class="producto">
        <div class=" form__section-container">
            <h2>Agregar Producto</h2>
            <?php if(isset($_SESSION['add-producto'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-producto']; 
                    unset($_SESSION['add-producto']);
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-producto-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="nombre"  placeholder="Nombre del Producto">
                <input type="text" name="precio"  placeholder="Precio del Producto">
                <label for="category">Seleccionar Categoría</label>
                <select name="category">
                    <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="5" name="body" placeholder="Descripción" value="<?= $descripcion ?>"></textarea>
                <div class="form__control">
                    <label for="thumbnail">Agregar Imagen</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Agregar</button>
            </form>
        </div>
    </div>
</main>
<!-- ================= END OF MAIN =================  -->

        


<?php 
include 'templates/footer.php';
?>