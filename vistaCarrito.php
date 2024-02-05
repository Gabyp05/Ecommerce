<?php 
include 'templates/header.php'; 

if(isset($_GET['vaciar'])){
  unset($_SESSION['carrito']);
  header("location: vistaCarrito.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= ROOT_URL?>/css/carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<style>
    .estilo-input {
        width: 60px;
        height: 30px;
        font-size: 16px;
        text-align:center;
        border: 0.5px solid #4252657d;
        border-radius: 50px;
    }

    table {
        text-align: center; /* Alinea el contenido de la tabla al centro */
        margin-left: auto; /* Centra la tabla horizontalmente */
        margin-right: auto;
    }
    th, td {
        vertical-align: middle; /* Alinea verticalmente el contenido de las celdas al centro */
    }

    .my-swal-container {
    width: 300px;
    height: 150px;
  }

  .my-swal-title {
    font-size: 24px;
  }

  .my-swal-content {
    font-size: 18px;
  }

</style>
<body>
    
    <?php if (empty($_SESSION['carrito'])) { ?>
      <section class="empty__page" style="height: 70vh; place-content: center; display: grid; align-items: center; justify-content:center; justify-items:center; ">
          <img src="images/carrito.png"><br>
          <div class="alert__message carrritovacio">
                <?= "El carrito está vacío" ?>
            </div>
          <a href="all-productos.php" class="btnn" style="color:#fff;">Ver Productos</a>
      </section>
      
    <?php } else { ?>
    <section id="cart-container" class="container"><br>
    <h2 class="font-weight-bold pt-5">Mi Carrito</h2>
    <div class="vaciar-carrito">
        <h4>Vaciar Carrito<h4>
        <a class='vaciar' name='vaciar' href="vistaCarrito.php?vaciar" style='background: none;border: none; font-size:20px;'><i class='bx bx-minus-circle'></i></a>
    </div> 
        <table class="table-dark table-bordered text-center">
            <thead>
                <tr>
                    
                    <td>Borrar</td>
                    <td>Imagen</td>
                    <td>Producto</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
	                  <td>Actualizar</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>               
                <?php 
                    // session_start();
                    $ptotal = 0;
                    $total = 0;
                    if(isset($_SESSION['carrito'])){
                        foreach($_SESSION['carrito'] as $key => $value){
                         
                            $ptotal = $value['precio'] * $value['cantidad'];
                            $total += $value['precio'] * $value['cantidad']; $ptotal = $value['precio'] * $value['cantidad'];
                            $ptotal_formateado = number_format($ptotal, 2);
                            $envio = 0;
                            echo "
                                <form action= 'cart-logic-stock.php' method='POST'>
                                    <tr>
                                    <td style='display:none;'> $key </td>
                                    
                                    <td><button name='remove' style='background: none;border: none;'><i class='bx bxs-trash'></i></button></td>
                                    <td><input type='hidden' name='img' value='$value[img]'><img src='./img/$value[img]' alt='$value[nombre]' width='50px' height='50px'></td>
                                    <td><input type='hidden' name='nombre' value='$value[nombre]'>$value[nombre]</td>
                                    <td><input type='hidden' name='precio' value='$value[precio]'>$value[precio]</td>
                                    <td><input type='' name='cantidad' value='$value[cantidad]' class='estilo-input'></td>
                                    <td><button class='actualizar' name='update'style='background: none;border: none;'><i class='bx bx-refresh'></i></button></td>
                                    <td>$ptotal_formateado</td>
                                    <td style='display:none;'><input type='hidden' name='item' value='$value[nombre]'></td>
                                    </tr>
                                </form>
                            ";                            
                        }
                    }
                ?>
            </tbody>
        </table><br><br>
         
        <?php $envio = 0; ?>
        <div class="total-price">
        

          <table class="table-bordered resumen" >
            <tr style="border:none;">
              <td style="border:none;"><h1>Subtotal<h1></td>
              <td style="border:none;"><?php echo number_format($total,2) ?></td>
            </tr>
            <tr style="border-bottom:2px solid #b6b3b3;">
              <td style="border:none;"><h1>Delivery<h1></td>
              <td style="border:none;">Gratis</td>
            </tr>            
            <tr style="border:none;">
              <td style="border:none;"><h1>Total a Pagar<h1></td>
              <td style="border:none;"><h4><?php echo number_format($total + $envio,2)  ?></h4></td>
            </tr>
          </table>
          <a href="checkout.php" type="submit" name="crearOrden" class="boton">Crear orden</a>

          
        </div>

    </section>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<?php include 'templates/footer.php'; ?>
</body>
</html>
<script>
    document.getElementById('miBoton').addEventListener('click', function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        iconColor: '#5CB176',
        customClass: {
          container: 'my-swal-container',
          title: 'my-swal-title',
          content: 'my-swal-content',
        }
      });

      Toast.fire({
        icon: 'success',
        background: '#C6F0C2',
        title: 'Producto agregado al carrito'
      });
    });
</script>

<script>
    document.getElementById('agregado').addEventListener('click', function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        iconColor: '#F29D41',
        customClass: {
          icon: 'swal2-icon-warning',
          popup: 'swal2-toast-warning',
          title: 'swal2-title-warning',
          container: 'my-swal-container',
          title: 'my-swal-title',
          content: 'my-swal-content',
        }
      });

      Toast.fire({
        icon: 'warning',
        background: '#FAE7B9',
        title: 'El producto ya existe en el carrito'
      });
    });
</script>

<script>
    var actualizarBotones = document.querySelectorAll('.actualizar');

    actualizarBotones.forEach(function(boton) {
      boton.addEventListener('click', function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          },
          iconColor: '#7b79ff',
          customClass: {
            icon: 'swal2-icon-info',
            popup: 'swal2-toast-warning',
            title: 'swal2-title-warning',
            container: 'my-swal-container',
            title: 'my-swal-title',
            content: 'my-swal-content',
          }
        });

        Toast.fire({
          icon: 'info',
          background: '#d9d8ff',
          title: 'Cantidad actualizada'
        });

        setTimeout(function() {
          window.location.reload();
        }, 1600);
      });
    });
</script>


