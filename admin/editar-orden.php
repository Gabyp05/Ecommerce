<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

// Obtener el ID de la orden de la URL
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM ordenes WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $orden = mysqli_fetch_assoc($result);
} else{
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// Obtener los datos de estatus de la base de datos
$estatus_query = "SELECT * FROM estatus";
$estatus = mysqli_query($connection, $estatus_query);

?>

<main>
    <div class="recent-orders">
        <div class="form__section-container">
            <h2>Editar Orden</h2><br>
            <form action="actualizar-orden.php" method="POST">
                <input type="hidden" name="id" value="<?= $orden['id'] ?>">
                <h2 for="numero_orden">Número de Orden:</h2>
                <input style="max-width: 60px;" type="text" name="numero_orden" value="<?= $orden['id'] ?>">
                <h2 for="created_at">Fecha:</h2>
                <input style="max-width: 120px;" type="text" name="created_at" value="<?= $orden['created_at'] ?>">
                <h2 for="metodo_pago">Método de Pago:</h2>
                <input style="max-width: 130px;" type="text" name="metodo_pago" value="<?= $orden['metodo_pago'] ?>">
                <h2 for="estatus">Estatus:</h2>
                <select style="max-width: 120px;" name="estatus">
                    <?php while ($estado = mysqli_fetch_assoc($estatus)) : ?>
                        <option value="<?= $estado['id'] ?>" <?php if($estado['id'] == $orden['estatus_id']) echo 'selected'; ?>>
                            <?= $estado['nombre'] ?>
                        </option>
                    <?php endwhile ?>
                </select><br>
                <input type="submit" value="Actualizar" class="btn">
            </form>
        </div>
    </div>
</main>


