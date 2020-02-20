<?php 
	// Libreria Para descargar PDf-Excel-Word
	require_once "../dompdfDownloderfile/dompdf_config.inc.php";
	// Conexion
	require_once "../db_connection/connection.php";

	ob_start();

	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$factura = 0;

	$idcliente = 0;
	$nrofactura = 0;

	session_start();
		if(empty($_SESSION['active']))
		{
			header('location: ../');
			// header('location: home.php');
		}

		$token_usuario = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

			# code...
		if ($token_usuario == '' || $idusuario == '') {
			# code...
			echo "No es posible generar/descargar el archivo.";
		}else{
				
						# code...
						$query = "SELECT f.nrofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.total_factura,f.pbase,f.piva, f.idcliente, f.estatus,
							user.nombre as vendedor, cliente.nombre as cliente
							FROM factura AS f
							JOIN usuario AS user
							ON f.idusuario = USER.idusuario
							JOIN cliente AS cliente
							ON f.idcliente = cliente.idcliente
							WHERE f.estatus >= 0
							ORDER BY f.fecha ASC";

						$query_datosFactura = mysqli_query($con,$query);
						$datosFactura_num_rows = mysqli_num_rows($query_datosFactura);

						
				}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FACTURA/EXCEL</title>
	
    
</head>
<body>
	<div>
		<table style="text-align: center;">
			<thead>
				<th>No.Fact</th>
				<th>Fecha/Hora</th>
				<th>Cliente</th>
				<th>Vendedor</th>
				<th>Estado</th>
				<th>P.Unitario</th>
				<th>P.Iva</th>
				<th>Total Factura</th>
			</thead>
			<tbody>
				<?php
					if ($datosFactura_num_rows > 0) {
							# code...
					while ($data_datosFactura = mysqli_fetch_array($query_datosFactura)) {
				?>

				<?php 
					if ($data_datosFactura['estatus'] ==  1) {
						# code...
						$estatus = 'pagada';
					}else{
						$estatus = 'anulada';
					}
				 ?>

				<tr>
					<td><?php echo $data_datosFactura['nrofactura']; ?></td>
					<td><?php echo $data_datosFactura['fecha']; ?> <?php echo $data_datosFactura['hora']; ?></td>
					<td><?php echo $data_datosFactura['cliente']; ?></td>
					<td><?php echo $data_datosFactura['vendedor']; ?></td>
					<td><?php echo $estatus; ?></td>
					<td><?php echo $data_datosFactura['pbase']; ?></td>
					<td><?php echo $data_datosFactura['piva']; ?></td>
					<td><?php echo $data_datosFactura['total_factura']; ?></td>
				</tr>

				<?php 
						}
					}
				 ?>

			</tbody>
		</table>
	</div>

</body>
</html>

<?php 
	header("Content-Type: application/vnd.ms-word");
	header("Content-Disposition: attachment; filename=Reporte_Ventas.doc");
	exit;
 ?>

<style type="text/css">
	*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

p, label, table{
	font-family: 'Arial';
	font-size: 9pt;
}


.h2{
	font-family: 'Arial';
	font-size: 16pt;
}
.h3{
	font-family: 'Arial';
	font-size: 12pt;
	display: block;
	background: #0a4661;
	color: #FFF;
	text-align: center;
	padding: 3px;
	margin-bottom: 5px;
}

.h4{
	font-family: 'Arial';
	font-size: 14pt;
	display: block;
	color: #000;
	text-align: center;
	padding: 3px;
}

.h5{
	font-size: 10pt;
}

#page_pdf{
	width: 95%;
	margin: 15px auto 10px auto;
}

#factura_head, #factura_cliente, #factura_detalle{
	width: 100%;
	margin-bottom: 10px;
}
.logo_factura{
	width: 25%;
}
.info_empresa{
	width: 50%;
	text-align: center;
}
.info_factura{
	width: 25%;
}
.info_cliente{
	width: 100%;
}
.datos_cliente{
	width: 100%;
}
.datos_cliente tr td{
	width: 50%;
}
.datos_cliente{
	padding: 10px 10px 0 10px;
}
.datos_cliente label{
	width: 75px;
	display: inline-block;
}
.datos_cliente p{
	display: inline-block;
}

.textright{
	text-align: right;
}
.textleft{
	text-align: left;
}
.textcenter{
	text-align: center;
}
.round{
	border-radius: 10px;
	border: 1px solid #0a4661;
	overflow: hidden;
	padding-bottom: 15px;
}
.round p{
	padding: 0 15px;
}

#factura_detalle{
	border-collapse: collapse;
}
#factura_detalle thead th{
	background: #058167;
	color: #FFF;
	padding: 5px;
}
#detalle_productos tr:nth-child(even) {
    background: #ededed;
}
#detalle_totales span{
	font-family: 'Arial';
}
.nota{
	font-size: 10pt;
}
.label_gracias{
	font-family: verdana;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	margin-top: 20px;
}
.anulada{
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translateX(-50%) translateY(-50%);
}

.bold{
	font-weight: bold;
}

.border_bottom{
	border-bottom: solid 1px black;
}

</style>