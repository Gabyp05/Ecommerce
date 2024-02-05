<?php 
require 'config/conexion.php';

if(isset($_POST['submit'])){
    //GET FORM DATA
    $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contraseña = filter_var($_POST['contraseña'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$usuario){
        $_SESSION['signin'] = "Nombre de usuario es requerido";
    } else if(!$contraseña){
        $_SESSION['signin'] = "La contraseña es requerida";
    } else{
        //FETCH USER FROM DATABASE
        $fetch_user_query = "SELECT * FROM users WHERE usuario='$usuario' OR email='$usuario'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_result) == 1){
            //CONVERT THE RECORD INTO ASSOC ARRAY
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['contraseña'];
            // COMPARE FORM PASSWORD WITH DATABASE PASSWORD
            if (password_verify($contraseña, $db_password)){
                //SET SESSION FOR ACCESS CONTROL
                $_SESSION['user-id'] = $user_record['id'];
                //SET SESSION IF USER IS AN ADMIN
                if($user_record['is_admin'] == 1){
                    $_SESSION['user_is_admin']= true;
                    header('location: ' . ROOT_URL . 'admin/');
                }elseif($user_record['is_admin'] == 0){
                    $_SESSION['user_is_admin']= false;
                    header('location: ' . ROOT_URL . 'index.php'); //CAMBIAR AL INDEX DE USUARIO NORMAL 
                }
            } else {
                $_SESSION['signin'] = "Por favor verifica los datos ingresados";
            }
        } else {
            $_SESSION['signin'] = "Usuario no encontrado";
        }
    }
    // IF ANY PROBLEM, REDIRECT BACK TO SIGNIN PAGE WITH LOGIN DATA
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'login.php');
        die();
    }
}else{
    header('location: ' . ROOT_URL . 'login.php');
    die();
}

?>