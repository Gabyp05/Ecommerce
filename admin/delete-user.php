<?php
require '../admin/config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //Obtener usuario de la BD
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    //MAKE SURE WE GOT BACK ONLY ONE USER
    if(mysqli_num_rows($result) == 1){
        $avatar_name = $user['avatar'];
        $avatar_path = '../img/'.$avatar_name;
        //Borrar la imagen 
        if($avatar_path){
            unlink($avatar_path);
        }
    }

    // BORRAR USUARIO DE LA BASE DE DATOS
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    if(mysqli_errno($connection)){
        $_SESSION['delete-user'] = "Error en eliminar a {$user['nombre']} {$user['apellido']}";
    } else {
        $_SESSION['delete-user-success'] = "Se ha eliminado a {$user['nombre']} {$user['apellido']}.";
    }

}

header('location: ' . ROOT_URL . 'admin/usuarios.php');
die();