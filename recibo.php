<?php

	# Incluyendo librerias necesarias #
	require "fpdf/code128.php";
    include "config/conexion.php";
    // Consulta de la bd //
    $orden_id = $_GET['id'];
    $query = "SELECT * FROM ordenes WHERE id = $orden_id";
    $ordenes = mysqli_query($connection, $query);

    while($orden = mysqli_fetch_assoc($ordenes)){
         // Obtener nombre y apellido del usuario
         $usuario_id = $orden['usuario_id'];
         $usuario_query = "SELECT nombre, apellido FROM users WHERE id = $usuario_id";
         $usuario_result = mysqli_query($connection, $usuario_query);
         $nombre_usuario = mysqli_fetch_assoc($usuario_result);
    }
    $nombre = $nombre_usuario['nombre'];
    $apellido = $nombre_usuario['apellido'];


    $query = "SELECT direccion FROM ordenes WHERE id = $orden_id";
    $resultado = mysqli_query($connection, $query);
    $direccion = mysqli_fetch_assoc($resultado)['direccion'];

	$query = "SELECT telefono FROM ordenes WHERE id = $orden_id";
    $resultado = mysqli_query($connection, $query);
    $telefono = mysqli_fetch_assoc($resultado)['telefono'];


    if (isset($_GET['id'])) {
        $numero_orden = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $sql_detalle_orden = "SELECT * FROM detalle_orden WHERE orden_id = '$numero_orden'";
        $resultado_detalle_orden = mysqli_query($connection, $sql_detalle_orden);
        
        // Obtener el estatus de la orden
        $orden_query = "SELECT estatus_id FROM ordenes WHERE id='$numero_orden'";
        $orden_result = mysqli_query($connection, $orden_query);
        $estatus_id = mysqli_fetch_assoc($orden_result)['estatus_id'];
    
        // Obtener el nombre del estatus desde la tabla estatus
        $status_query = "SELECT nombre FROM estatus WHERE id = $estatus_id";
        $status_result = mysqli_query($connection, $status_query);
        $status_nombre = mysqli_fetch_assoc($status_result)['nombre'];
    
        //obtener los productos
        $sql_detalle = "SELECT detalle_orden.*, productos.nombre 
                              FROM detalle_orden 
                              INNER JOIN productos ON detalle_orden.producto_id = productos.id 
                              WHERE detalle_orden.id = '$numero_orden'";
        $resultado_detalle = mysqli_query($connection, $sql_detalle_orden);
    
        // Obtener el total de la compra
        $orden_query = "SELECT * FROM ordenes WHERE id='$numero_orden'";
        $orden_result = mysqli_query($connection, $orden_query);
        $orden_total = mysqli_fetch_assoc($orden_result);
       
    } else {
        echo "No se ha proporcionado el número de orden.";
    }


	$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('images/frutalia_b_n.png',155,10,45,45,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',16);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper("Laboratorios Frutalia C.A")),0,0,'L');

	$pdf->Ln(9);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(29,29,29);
	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","RIF: J-00021566-9"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Calle Real de Sarría, Caracas"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Teléfono: 0414 123 45 78"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: admin@frutalia.com"),0,0,'L');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1","Fecha de emisión:"),0,0);
	$pdf->SetTextColor(60,60,60);
	$pdf->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", date("d/m/Y")), 0, 0, 'L');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",'Orden #' . $orden_id),0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",'Estatus: ' . $status_nombre),0,0,'L');
	$pdf->Ln(7);

	

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(29,29,29);
	$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1","Cliente:"),0,0);
	$pdf->SetTextColor(60,60,60);
	$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1","$nombre $apellido"),0,0,'L');
    $pdf->SetTextColor(29,29,29);
	$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1","Tel: "),0,0,'L');
	$pdf->SetTextColor(60,60,60);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","$telefono"),0,0);
	$pdf->SetTextColor(39,39,51);

	$pdf->Ln(7);

	$pdf->SetTextColor(29,29,29);
	$pdf->Cell(17,7,iconv("UTF-8", "ISO-8859-1","Dirección:"),0,0);
	$pdf->SetTextColor(60,60,60);
	$pdf->Cell(120,7,iconv("UTF-8", "ISO-8859-1","$direccion"),0,0);

	$pdf->Ln(9);

	# Tabla de productos #
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(34,136,255);
	$pdf->SetDrawColor(34,136,255);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1","DESCRIPCIÓN"),1,0,'C',true);
	$pdf->Cell(20,8,iconv("UTF-8", "ISO-8859-1","CANT."),1,0,'C',true);
	$pdf->Cell(40,8,iconv("UTF-8", "ISO-8859-1","PRECIO UNITARIO"),1,0,'C',true);
	$pdf->Cell(34,8,iconv("UTF-8", "ISO-8859-1","TOTAL"),1,0,'C',true);
	

	$pdf->Ln(8);

	
	$pdf->SetTextColor(39,39,51);
               
    
    

    while ($row=$resultado_detalle_orden->fetch_assoc()) {
        $producto = $row['producto_id'];
        $producto_query = "SELECT * FROM productos WHERE id='$producto'";
        $producto_result = mysqli_query($connection, $producto_query);
        $producto = mysqli_fetch_assoc($producto_result);
        $total = $row['cantidad'] * $producto['precio'];
        $total_formateado = number_format($total, 2);

        $producto_nombre = $producto['nombre'];
        $cantidad = $row['cantidad'];
        $precio = $producto['precio'] ;
        

	/*----------  Detalles de la tabla  ----------*/
	$pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1","$producto_nombre"),'L',0,'C');
	$pdf->Cell(20,7,iconv("UTF-8", "ISO-8859-1","$cantidad"),'L',0,'C');
	$pdf->Cell(40,7,iconv("UTF-8", "ISO-8859-1","$$precio"),'L',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$$total_formateado"),'LR',0,'C');
	$pdf->Ln(7);
	/*----------  Fin Detalles de la tabla  ----------*/

    }
	
	$pdf->SetFont('Arial','B',9);
	
	# Impuestos & totales #
	$pdf->Cell(103,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),'T',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $" . $orden_total['total']),'T',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(103,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","IVA (16%)"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $0.00"),'',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(103,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');

    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),'T',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $" . $orden_total['total']),'T',0,'C');

	$pdf->Ln(7);

	

	$pdf->Ln(7);



	$pdf->Ln(7);

	

	$pdf->Ln(12);

	$pdf->SetFont('Arial','',9);

	$pdf->SetTextColor(60,60,60);
	$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen IVA. Para poder realizar un reclamo o devolución debe presentar esta factura ***"),0,'C',false);

	$pdf->Ln(9);

    $factura_id = "COD-ORF-0000" . $numero_orden;
	# Codigo de barras #
	$pdf->SetFillColor(39,39,51);
	$pdf->SetDrawColor(23,83,201);
	$pdf->Code128(72,$pdf->GetY(),"$factura_id ",70,20);
	$pdf->SetXY(12,$pdf->GetY()+21);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","$factura_id "),0,'C',false);

	# Nombre del archivo PDF #
    $nombre_archivo = "Factura_Nro_" . $numero_orden . ".pdf";
	$pdf->Output("I","$nombre_archivo",true);

?>