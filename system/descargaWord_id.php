<?php 
	// Libreria Para descargar PDf-Excel-Word
	require_once "dompdfDownloderfile/dompdf_config.inc.php";
	// Conexion
	require_once "db_connection/connection.php";

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
			// header('location: ../');
			header('location: home.php');
		}

		$token_usuario = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

			# code...
		if ($token_usuario == '' || $idusuario == '') {
			# code...
			echo "No es posible generar/descargar el archivo.";
		}else{
				
			if ($_REQUEST['cli'] != '' && $_REQUEST['fact'] != '') {
						# code...
						$anulada = '';
						$idcliente = $_REQUEST['cli'];
						$nrofactura = $_REQUEST['fact'];

						$query_config   = mysqli_query($con,"SELECT * FROM configuracion");
						$result_config  = mysqli_num_rows($query_config);
						if($result_config > 0){
							$configuracion = mysqli_fetch_assoc($query_config);
						}

						echo $idcliente. "-" . $nrofactura;

						$query = mysqli_query($con,"SELECT f.nrofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.idcliente, f.estatus,
																 user.nombre as vendedor,
																 cli.numero_documento, cli.nombre as nombre_cliente, cli.telefono as telefono_cliente,cli.direccion as direccion_cliente
															FROM factura f
															INNER JOIN usuario AS user
															ON f.idusuario = user.idusuario
															INNER JOIN cliente AS cli
															ON f.idcliente = cli.idcliente
															WHERE f.nrofactura = '$nrofactura' AND f.idcliente = '$idcliente' AND f.estatus != 10");
						$result = mysqli_num_rows($query);
						if($result > 0){
							$factura = mysqli_fetch_assoc($query);
							$nrofactura = $factura['nrofactura'];

							if($factura['estatus'] == 2){
								$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
							}

							$query_productos = mysqli_query($con,"SELECT distinct(UPPER(articulo.nombre)) as descripcion,df.cantidad,df.precio_venta,df.precio_total
								FROM factura f
								INNER JOIN detalle_factura AS df
				                INNER JOIN articulo AS articulo
								INNER JOIN compras AS compras
																		
				                ON (f.nrofactura = df.nrofactura and compras.idarticulo = articulo.idarticulo and
									df.idarticulo = compras.idarticulo)
								WHERE f.nrofactura = '$nrofactura' ORDER BY articulo.nombre asc");

							$result_detalle = mysqli_num_rows($query_productos);

				}
			}

	}

	echo $anulada;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FACTURA</title>
    
</head>
<body>

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="info_empresa">
				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
				 ?>
				<div>
					<p class="h2"><h2><?php echo $configuracion['razon_social']; ?></h2></p>
					<p><b>Dirección:</b> <?php echo $configuracion['direccion']; ?></p>
					<p><b>Teléfono1:</b> <?php echo $configuracion['telefono1']; ?></p>
					<p><b>Teléfono2:</b> <?php echo $configuracion['telefono2']; ?></p>
					<p><b>Email: </b> <?php echo $configuracion['email']; ?></p>
				</div>
				<?php
					}
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<h3 style="text-align: center;"><b>Factura</b></h3>
					<p><b>No. Factura:</b> <strong><?php echo $factura['nrofactura']; ?></strong></p>
					<p><b>Fecha:</b> <?php echo $factura['fecha']; ?></p>
					<p><b>Hora:</b> <?php echo $factura['hora']; ?></p>
					<p><b>Vendedor:</b> <?php echo $factura['vendedor']; ?></p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente" class="table table-striped table-bordered">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<h3 style="text-align: left;border-bottom: 1px solid black;" ><b>Cliente</b></h3>
					<table class="datos_cliente">
						<tr>
							<td><label><b>Número de Documento: </b></label><label><?php echo $factura['numero_documento']; ?></label></td>
							<td><label><b>Teléfono: </b></label> <label><?php echo $factura['telefono_cliente']; ?></label></td>
						</tr>
						<tr>
							<td><label><b>Nombre: </b></label> <label><?php echo $factura['nombre_cliente']; ?></label></td>
							<td><label><b>Dirección: </b></label> <label><?php echo $factura['direccion_cliente']; ?></label></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<br>

	<table id="factura_detalle" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th width="50px" style="text-align: center;"><span class="h5">Cant</span>.</th>
					<th style="text-align: center;"><span class="h5">Descripción</span></th>
					<th style="text-align: center;" width="150px"><span class="h5">Precio Unitario</span>.</th>
					<th style="text-align: center;" width="150px"> <span class="h5">Precio Total</span></th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
			 ?>
				<tr>
					<td style="text-align: center;"><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<td style="text-align: center;"><?php echo $row['precio_venta']; ?></td>
					<td style="text-align: center;"><?php echo $row['precio_total']; ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

					$porc_iva  = ($iva/100);
					$porc_iva  = round($porc_iva,2);

					$subtot = $subtotal;
					$subtot  = round($subtot,2);

					$impuesto = $subtot*$porc_iva;
					$impuesto  = round($impuesto,2);

					$tot_fin = $subtot + $impuesto;
					$tot_fin  = round($tot_fin,2);
			?>
			</tbody>

			<hr>

			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" style="text-align: left;"><span><b>SUBTOTAL Q.</b></span></td>
					<td style="text-align: center;"><span><b>$<?php echo $subtot; ?></b></span></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: left;"><span><b>IVA</b> <b>(<?php echo $iva; ?> %)</b></span></td>
					<td style="text-align: center;"><span><b>$<?php echo $impuesto; ?></b></span></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: left;"><span><b>TOTAL</b></span></td>
					<td style="text-align: center;"><span><b>$<?php echo $tot_fin; ?></b></span></td>
				</tr>
		</tfoot>
	</table>

	<hr>

	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, pongase en contacto via telefónico.</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>

</div>

</body>
</html>

<?php 
	header("Content-Type: application/vnd.ms-word");
	header("Content-Disposition: attachment; filename=Factura_Venta_WORD_$nrofactura.doc");
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