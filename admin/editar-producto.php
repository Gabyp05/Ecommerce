<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

// Obtener el ID del producto de la URL
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM productos WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $producto = mysqli_fetch_assoc($result);
} else{
    header('location: ' . ROOT_URL . 'admin/productos.php');
    die();
}

//FECTH CATEGORIES FROM DATABASE
$query = "SELECT * FROM categoria";
$categorias = mysqli_query($connection, $query);

//get back form data if form was invalid
$nombre = $_SESSION['add-producto-data']['nombre'] ?? null;
$body = $_SESSION['add-producto-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-producto-data']);

?>

<main>
    <h1>Productos</h1>
    <!-- ================= END OF INSIGHTS =================  -->

    

    <div class="producto">
        <div class=" form__section-container">
            <h2>Editar Producto</h2>
            <?php if(isset($_SESSION['editar-producto'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['editar-producto']; 
                    unset($_SESSION['editar-producto']);
                    ?>
                </p>
            </div>
            <?php endif ?>
            <?php if(isset($_SESSION['editar-producto'])) : ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['editar-producto-success']; 
                    unset($_SESSION['editar-producto-success']);
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/editar-producto-logic.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                <input type="hidden" name="previous_thumbnail_name" value="<?= $producto['imagen'] ?>">
                <input type="text" name="nombre"  placeholder="Nombre del Producto" value=" <?= $producto ['nombre'] ?>">
                <input type="text" name="precio"  placeholder="Precio del Producto" value=" <?= $producto ['precio'] ?>">
                <label for="category">Seleccionar Categoría</label>
                <select name="categoria">
                <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                <option value="<?= $categoria['id'] ?>" <?php if ($categoria['id'] == $producto['id_categoria']) echo 'selected' ?>>
                    <?= $categoria['nombre'] ?>
                </option>
                <?php endwhile ?>
                </select>
                <label for="body">Descripción</label>
                <textarea rows="5" name="body" placeholder="Descripción"><?= $producto['descripción'] ?></textarea>
                <label for="stock">Agrega la cantidad en Stock</label>
                <input type="text" name="stock" placeholder="Cantidad en Stock" value=" <?= $producto ['stock'] ?>">
                <div class="form__control">
                    <label for="thumbnail">Cambiar Imagen</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Actualizar</button>
            </form>
        </div>
    </div>
</main>