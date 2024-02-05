<?php
//variables de seccion para almacenar lo que va a comprar
session_start();

if(isset($_POST['btnAccion'])){
    switch($_POST['btnAccion']){
        case 'Agregar':
            if(is_numeric(($_POST['id']))){
                $ID=$_POST['id'];
                $mensaje.="ID Correcto".$ID."<br/>";
            }else{
                $mensaje.=" ID Incorrecto".$ID."<br/>";
            }
            if(is_string($_POST['nombre'])){
                $nombre=$_POST['nombre'];
            }else{
                $mensaje.="Algo pasa con el nombre"."<br/>"; break;
            }
            if(is_numeric($_POST['cantidad'])){
                $cantidad=$_POST['cantidad'];
                $mensaje.="OK cantidad".$cantidad."<br/>";
            }else{
                $mensaje.="Algo pasa con la cantidad"."<br/>"; break;
            }
            if(is_numeric($_POST['precio'])){
                $precio=$_POST['precio'];
                $mensaje.="OK precio".$precio."<br/>";
            }else{
                $mensaje.="Algo pasa con el precio"."<br/>"; break;
            }
        
        if(!isset($_SESSION['carrito'])){
            $producto = array(
                'id'=>$id,
                'nombre'=>$nombre,
                'cantidad'=>$cantidad,
                'precio'=>$precio,
            );
            $_SESSION['carrito'][0]=$producto;
        } else {
            $idProductos = array_column($_SESSION['carrito'], "id");

            if(in_array($id,$idProductos)){
                echo "<script>alert('El producto ya ha sido seleccionado... ');</script>";
            }else{
                $NumeroProductos = count($_SESSION['carrito']);
                $producto=array(
                    'id'=>$id,
                    'nombre'=>$nombre,
                    'cantidad'=>$cantidad,
                    'precio'=>$precio,
                );
                $_SESSION['carrito'][$NumeroProductos]=$producto;
            }
        }
        break;
        case 'Eliminar':
            if(is_numeric($_POST['id'])){
                $id=$_POST['id'];

                foreach($_SESSION['carrito'] as $indice=>$producto){
                    if($producto['id']==$id){
                        unset($_SESSION['carrito'][$indice]);
                        echo "<script>alert('Elemento Eliminado... ');</script>";
                    }
                }
            } else {
                echo "<script>alert('Id Incorrecto.. ');</script>";
            }
    }
}

?>