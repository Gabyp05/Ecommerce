<?php 
require '../admin/config/database.php';
include '../admin/templates/header.php';

$current_admin_id= $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$users = mysqli_query($connection, $query);
?>
<main>
    <div class="titulo__pago">
        <br><h1>Usuarios Registrados</h1>
    </div>
            
    <div class="recent-orders">
    <?php if(mysqli_num_rows($users)> 0) : ?>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <!-- <th>Editar</th> -->
                    <th>Borrar</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = mysqli_fetch_assoc($users)) : ?>
                <tr>
                    <td><img src="<?= ROOT_URL . 'img/' . $user['avatar'] ?>" alt="Avatar" style="width: 40px;height: 40px;border-radius: 50%;"></td>
                    <td><?= "{$user['nombre']} {$user['apellido']}" ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['usuario'] ?></td>
                    <!-- <td><a href="<?= ROOT_URL?>admin/edit-user.php?id=<?= $user['id']?>" class="btn sm">Editar</a></td> -->
                    <td><a href="<?= ROOT_URL?>admin/delete-user.php?id=<?= $user['id']?>" class="btn sm danger">Borrar</a></td>
                    <td><?= $user['is_admin'] ? 'Si' : 'No' ?></td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
        <?php endif ?>        
    </div>
</main>