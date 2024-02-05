<?php

include 'templates/header.php';

// $current_user_id = $_SESSION['user-id'];


if (isset($_GET['id'])) {
    $numero_orden = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql_detalle_orden = "SELECT * FROM detalle_orden WHERE orden_id = '$numero_orden'";
    $resultado_detalle_orden = mysqli_query($connection, $sql_detalle_orden);

    // Obtener el total de la compra
    $orden_query = "SELECT * FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $orden_total = mysqli_fetch_assoc($orden_result);
    
    // Obtener el estatus de la orden
    $orden_query = "SELECT estatus_id FROM ordenes WHERE id='$numero_orden'";
    $orden_result = mysqli_query($connection, $orden_query);
    $estatus_id = mysqli_fetch_assoc($orden_result)['estatus_id'];

     // Obtener el nombre del estatus desde la tabla estatus
     $status_query = "SELECT nombre FROM estatus WHERE id = $estatus_id";
     $status_result = mysqli_query($connection, $status_query);
     $status_nombre = mysqli_fetch_assoc($status_result)['nombre'];
} else {
    echo "No se ha proporcionado el número de orden.";
}
?>

?>
<link rel="stylesheet" href="<?= ROOT_URL?>/css/pago.css">
<!-- <section id="cart-container" class="empty__page container" style="height: 60vh; place-content: center; display: grid; align-items: center; justify-content:center; justify-items:center; "> -->
 


<section id="tabla-pago" class="form__section">
        <div class="container form__section-container carta">
            <div class="tabla-info">
                <p id="mensaje">Seleccione un banco para ver los datos bancarios...</p>
                <table id="infoBanco">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>RIF</th>
                            <th>Número de Cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
            </div>
            <div class="titulo">
                <h2>Registro de pago</h2>
            </div>
           
            <form action="pagar-logic.php"  method="post" id="formularioPago">
                <input type="hidden" name="orden_id" value="<?= $numero_orden ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="banco">Banco a donde realizará el pago:</label>
                        <select id="banco" name="banco" class="form-control">
                            <option value="">Seleccione un banco</option>
                            <option value="Banesco">Banesco</option>
                            <option value="Banco Venezuela">Banco Venezuela</option>
                            <option value="Bancamiga">Bancamiga</option>
                            <option value="Pago Móvil">Pago Móvil</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="monto">Monto:</label>
                        <input type="text" id="monto" name="monto" class="form-control" value="<?= $orden_total['total'] ?>"  required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="referencia">Referencia de la transferencia:</label>
                        <input type="text" id="referencia" name="referencia" class="form-control" placeholder="Últimos 8 dígitos..." required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha">Fecha de la transferencia:</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                    <div class="hline hline-100"></div>
                    <div class="rows">
                        <div class="form-group-col-md-6 mb-2">
                            <button type="submit" name="submit">Enviar</button>
                        </div>
                        <div class="form-group-col-md-6 mb-2">
                            <button type="button" name="cancelar" onclick="goBack()">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var bancoSelect = document.getElementById('banco');
            var infoBanco = document.getElementById('infoBanco');
            var mensajeFila = document.getElementById('mensajeFila');
            var formularioPago = document.getElementById('formularioPago');
    
            var datosBanco = {
                "Banesco": {
                    "Nombre": "Laboratorios Frutalia",
                    "RIF": "J-00021566-9",
                    "Número de Cuenta": "0135 5678 90 0000123456"
                },
                "Banco Venezuela": {
                    "Nombre": "Laboratorios Frutalia",
                    "RIF": "J-00021566-9",
                    "Número de Cuenta": "0102 1497 70 0000177453"
                },
                "Bancamiga": {
                    "Nombre": "Laboratorios Frutalia",
                    "RIF": "J-00021566-9",
                    "Número de Cuenta": "0172 0786 12 000018561"
                },
                "Pago Móvil": {
                    "Nombre": "Laboratorios Frutalia",
                    "RIF": "J-00021566-9",
                    "Número de Cuenta": "(BDV - 0102) 0414 010 0069"
                },
                "": {
                    "Nombre": "",
                    "RIF": "",
                    "Número de Cuenta": ""
                },
            };
    
            function mostrarTabla() {
                var bancoSeleccionado = bancoSelect.value;
                var mensaje = document.getElementById('mensaje');
                if (bancoSeleccionado) {
                    var datos = datosBanco[bancoSeleccionado];
                    var tbody = document.querySelector('#infoBanco tbody');
                    tbody.innerHTML = `
                        <tr>
                            <td>${datos.Nombre}</td>
                            <td>${datos.RIF}</td>
                            <td>${datos["Número de Cuenta"]}</td>
                        </tr>
                    `;
                    infoBanco.style.display = 'table';
                    mensaje.style.display = 'none';
                } else {
                    infoBanco.style.display = 'none';
                    mensaje.style.display = 'block';
                }
            }

    
            // Mostrar tabla al cargar la página
            mostrarTabla();
    
            bancoSelect.addEventListener('change', mostrarTabla);
    
           
        });

        function goBack() {
            window.history.back();
        }
    </script>

<!-- </section>  -->