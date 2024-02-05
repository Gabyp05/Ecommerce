<?php

	# Incluyendo librerias necesarias #
	require "../fpdf/code128.php";
    include "../config/conexion.php";
    // Consulta de la bd //
    $query = "SELECT ordenes.*, users.nombre, users.apellido 
          FROM ordenes 
          INNER JOIN users ON ordenes.usuario_id = users.id 
          ORDER BY ordenes.id DESC";

    $ordenes = mysqli_query($connection, $query);

    while ($orden = mysqli_fetch_assoc($ordenes)) {
        $orden_id = $orden['id'];
        // Obtener nombre y apellido del usuario
        $nombre_usuario = $orden['nombre'];
        $apellido_usuario = $orden['apellido'];
        $cliente = $nombre_usuario . " " . $apellido_usuario;
    }


	$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(13,10,10);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('../images/frutalia_b_n.png',155,10,45,45,'PNG');

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
    $pdf->Ln(10);
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(39,39,51);
    $pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper("Listado de Pagos recibidos")),0,0,'L');
	$pdf->Ln(15);

  

	// Establecer encabezados de la tabla
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,10,iconv("UTF-8", "ISO-8859-1",'Cliente'),1,0,'C');
    $pdf->Cell(25,10,iconv("UTF-8", "ISO-8859-1",'N° Orden'),1,0,'C');
    $pdf->Cell(40,10,iconv("UTF-8", "ISO-8859-1",'Banco'),1,0,'C');
    $pdf->Cell(25,10,'Monto',1,0,'C');
    $pdf->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'N° Referencia'),1,0,'C');
    $pdf->Cell(30,10,'Estatus',1,1,'C');
    
    // Consultar la base de datos
    $query = "SELECT * FROM pagos ORDER BY id DESC";
    $resultado = mysqli_query($connection, $query);

    // Recorrer los resultados y agregar filas a la tabla
    $pdf->SetFont('Arial','',12);
    while ($fila = mysqli_fetch_assoc($resultado)) {

        $pagoId = $fila['id'];
        $query = "SELECT p.*, o.usuario_id, u.nombre, u.apellido
                FROM pagos p
                JOIN ordenes o ON p.orden_id = o.id 
                JOIN users u ON o.usuario_id = u.id
                WHERE p.id = $pagoId";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
        $cliente = $user['nombre'].' '. $user['apellido'];

        $numero_orden = $fila['orden_id'];
        $banco = $fila['banco'];
        $monto = $fila['monto'];
        $numero_referencia = $fila['referencia'];
        $estatus = $fila['estatus'];

        $pdf->Cell(40,10,iconv("UTF-8", "ISO-8859-1",$cliente),1,0,'C');
        $pdf->Cell(25,10,$numero_orden,1,0,'C');
        $pdf->Cell(40,10,iconv("UTF-8", "ISO-8859-1",$banco),1,0,'C');
        $pdf->Cell(25,10,$monto,1,0,'C');
        $pdf->Cell(30,10,$numero_referencia,1,0,'C');
        $pdf->Cell(30,10,$estatus,1,1,'C');
    }

 
	# Nombre del archivo PDF #
    $nombre_archivo = "Reporte_pago" .  ".pdf";
	$pdf->Output("I","$nombre_archivo",true);

?>