<?php
require '../admin/config/database.php';

if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $category_id = filter_var($_POST['categoria'], FILTER_SANITIZE_NUMBER_INT); 
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    
    // Validate form data
    if(!$nombre){
        $_SESSION['editar-producto'] = "Escribe un nombre";
    } elseif (!$category_id){
        $_SESSION['editar-producto'] = "Selecciona una categoría";
    } elseif (!$body){
        $_SESSION['editar-producto'] = "Agrega una descripción";
    } elseif (!$stock){
        $_SESSION['editar-producto'] = "Ingresa una cantidad de Stock para el producto";
    }else{
        //delete existing thumbnail if new thumbnail is available
        if($thumbnail['name']){
            // Verificar si $previous_thumbnail_name está definida antes de utilizarla
            if(isset($previous_thumbnail_name)){
                $previous_thumbnail_path = '../img/' . $previous_thumbnail_name;
                if($previous_thumbnail_path){
                    unlink($previous_thumbnail_path);
                }
            }

            //WORK ON NEW THUMBNAIL
            //Rename image
            $time = time(); 
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../img/' . $thumbnail_name;

            //make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if(in_array($extension, $allowed_files)){
                // make sure image is not too big. (2mb+)
                if($thumbnail['size'] < 2_000_000){
                    //upload thumbnail
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else{
                    $_SESSION['editar-producto'] = "La imagen debe ser menor a 2mb";
                }
            } else {
                $_SESSION['editar-producto'] = "La imagen debe ser png, jpg o jpeg";
            }
        }

        // Redirect back (with form data) to editar-producto page if there is any problem
        if(isset($_SESSION['editar-producto'])){
            $_SESSION['editar-producto-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/editar-producto.php');
            die();
        } else{

            //set thumbnail name if a new one uploaded. else keep old thumbnail name
            $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
            //insert post into database
            $query = "UPDATE productos SET nombre='$nombre', descripción='$body', id_categoria='$category_id', precio='$precio', stock='$stock', imagen='$thumbnail_to_insert' WHERE id=$id";
            $result = mysqli_query($connection, $query);
            
            if(!mysqli_errno($connection)){
                $_SESSION['editar-producto-success'] = "Producto actualizado con exito!";
                header('location: ' . ROOT_URL . 'admin/editar-producto.php');
                die();
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/editar-producto.php');
die();