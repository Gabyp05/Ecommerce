<?php
require '../admin/config/database.php';

if(isset($_POST['submit'])){
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT); 
    $thumbnail = $_FILES['thumbnail'];
    
    //SET IS_FEATURED TO 0 IF UNCHECKED
    $is_featured = $is_featured == 1 ?: 0;

    // Validate form data
    if(!$nombre){
        $_SESSION['add-producto'] = "Escribe un nombre";
    } elseif (!$category_id){
        $_SESSION['add-producto'] = "Selecciona una categoría";
    } elseif (!$body){
        $_SESSION['add-producto'] = "Agrega una descripción";
    } elseif (!$thumbnail['name']){
        $_SESSION['add-producto'] = "Escoge una imagen para el producto";
    } else{
        //WORK ON THUMBNAIL
        //Rename the image
        $time = time(); // make each image name unique
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
                $_SESSION['add-producto'] = "La imagen debe ser menor a 2mb";
            }
        } else {
            $_SESSION['add-producto'] = "La imagen debe ser png, jpg o jpeg";
        }

        // Redirect back (with form data) to add-producto page if there is any problem
        if(isset($_SESSION['add-producto'])){
            $_SESSION['add-producto-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-producto.php');
            die();
        } else{
            //insert post into database
            $query = "INSERT INTO productos (nombre, descripción, id_categoria, precio, imagen) 
            VALUES ('$nombre', '$body', $category_id, $precio, '$thumbnail_name')";
            $result = mysqli_query($connection, $query);
            
            if(!mysqli_errno($connection)){
                $_SESSION['add-producto-success'] = "Producto agregado con exito!";
                header('location: ' . ROOT_URL . 'admin/productos.php');
                die();
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/add-producto.php');
die();