<?php 
// session_start();
require 'constants.php';

//Conexion con la base de datos

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_errno($connection)){
    die(mysqli_error($connection));
}
?>