<?php 
require 'config/conexion.php';

//GET SIGN UP FORM DATA  IF SIGNUP BUTTON WAS CLICKED

if(isset($_POST['submit'])){
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
    $apellido = filter_var($_POST['apellido'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    //VALIDACIONES
    if(!$nombre){
        $_SESSION['signup'] = "Por favor ingresa tu nombre";
    }else if (!$apellido){
        $_SESSION['signup'] = "Por favor ingresa tu apellido";
    }else if (!$usuario){
        $_SESSION['signup'] = "Por favor ingresa tu nombre de usuario";
    }else if (!$email){
        $_SESSION['signup'] = "Por favor ingresa tu correo";
    }else if (strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = "La contraseña debe ser de 8 o más caracteres";
    }else if (!$avatar['name']){
        $_SESSION['signup'] = "Por favor añade un avatar";
    }else{
        //CONFIRMAR SI LAS CONTRASEÑAS NO HACEN MATCH
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Las contraseñas no coinciden";
        } else{
            //HASH CONTRASEÑA
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            
            //CHECKEAR SI USUARIO O CORREO YA EXISTEN EN LA DB
            $user_check_query = "SELECT * FROM users WHERE usuario='$usuario' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['signup'] = "El usuario o correo ya existe";
            }else{
                //AVATAR
                $time = time(); //make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'img/'. $avatar_name;

                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention,$allowed_files)){
                    //make sure images is not too large (1mb+)
                    if($avatar['size'] < 1000000){
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup'] = "La imagen es muy grande. Debe ser menor a 1mb";
                    }
                } else{
                    $_SESSION['signup'] = "El archivo debe ser png, jpg o jpeg";
                }
            }
        }
    }

    // REDIRECCIONAR A LA PÁG DE REGISTRO SI HAY UN PROBLEMA
    if(isset($_SESSION['signup'])){
        // PASS FORM DATA BACK TO SIGNUP PAGE
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else{
        //INSERTAR NUEVO USUARIO EN LA TABLA users
        $insert_user_query = "INSERT INTO users SET nombre='$nombre', apellido='$apellido', usuario='$usuario', email='$email', contraseña='$hashed_password', avatar='$avatar_name', is_admin=0";
        $insert_user_result = mysqli_query($connection,$insert_user_query);

        if(!mysqli_errno($connection)){
            //REDIRECCIONAR A LA PAG DE LOGIN CON MENSAJE DE EXITO
            $_SESSION['signup-success'] = "Registro exitoso. Por favor inicia sesión";
            header('location: ' . ROOT_URL . 'login.php');
            die();
        }
    }

} else{
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}

?>