<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	// $tl_sniva   = 0;
	// $total 		= 0;
 //print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="factura/style.css">
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="factura/img/logoDASTU.png" width="200" height="200">
				</div>
			</td>
			<td class="info_empresa">
				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
				 ?>
				<div>
					<!-- <span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span> -->
					<p class="h2"><?php echo $configuracion['razon_social']; ?></p>
					<p><?php echo $configuracion['direccion']; ?></p>
					<p>Teléfono1: <?php echo $configuracion['telefono1']; ?></p>
					<p>Teléfono2: <?php echo $configuracion['telefono2']; ?></p>
					<p>Email: <?php echo $configuracion['email']; ?></p>
				</div>
				<?php
					}
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Factura: <strong><?php echo $factura['nrofactura']; ?></strong></p>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
					<p>Hora: <?php echo $factura['hora']; ?></p>
					<p>Vendedor: <?php echo $factura['vendedor']; ?></p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Número de Documento:</label><p><?php echo $factura['numero_documento']; ?></p></td>
							<td><label>Teléfono:</label> <p><?php echo $factura['telefono_cliente']; ?></p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p><?php echo $factura['nombre_cliente']; ?></p></td>
							<td><label>Dirección:</label> <p><?php echo $factura['direccion_cliente']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px"><span class="h5">Cant</span>.</th>
					<th class="textleft"><span class="h5">Descripción</span></th>
					<th class="text-center" width="150px"><span class="h5">Precio Unitario</span>.</th>
					<th class="text-center" width="150px"> <span class="h5">Precio Total</span></th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
			 ?>
				<tr>
					<td class="textcenter"><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<td class="textright"><?php echo $row['precio_venta']; ?></td>
					<td class="textright"><?php echo $row['precio_total']; ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

				// $impuesto 	= round($subtotal * ($iva / 100), 2);
				// $tl_sniva 	= round($subtotal - $impuesto,2 );
				// $total 		= round($tl_sniva + $impuesto,2);

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
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
					<td class="textright"><span class="h5"><b>$<?php echo $subtot; ?></b></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA (<?php echo $iva; ?> %)</span></td>
					<td class="textright"><span class="h5"><b>$<?php echo $impuesto; ?></b></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL</span></td>
					<td class="textright"><span class="h5"><b>$<?php echo $tot_fin; ?></b></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, pongase en contacto via telefónico.</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>

</div>

</body>
</html>