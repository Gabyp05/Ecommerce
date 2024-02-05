<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

//obtener todos los productos desde la BD
$query = "SELECT * FROM productos";
$productos = mysqli_query($connection, $query);




?>


        <!-- ================= END OF ASIDE =================  -->
        <main>
            <h1>Productos</h1>
            <!-- ================= END OF INSIGHTS =================  -->

            

            <div class="recent-orders" >
                <h2>Lista de Productos</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($producto = mysqli_fetch_assoc($productos)) : ?>
                        <?php 
                            $id_categoria=$producto['id_categoria'];
                            $categoria_query = "SELECT nombre FROM categoria WHERE id=$id_categoria";
                            $categoria_result = mysqli_query($connection, $categoria_query);
                            $categoria = mysqli_fetch_assoc($categoria_result);    
                        ?>
                        <tr>
                            <td><?=$producto['nombre']?></td>
                            <td>$<?=$producto['precio']?></td>
                            <td><?=$categoria['nombre']?></td>
                            <td><?=$producto['stock']?></td>
                            <td style="display: flex;align-items: center;"><a href="<?= ROOT_URL ?>admin/editar-producto.php?id=<?=$producto['id']?>" class="btn sm">Editar</a>
                            <a href="#" class="btn sm danger">Borrar</a></td>
                        </tr>
                    <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- ================= END OF MAIN =================  -->

        


<?php 
include 'templates/footer.php';
?>