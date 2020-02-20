<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- Scripts -->
	<?php include_once '../scripts.php'; ?>
<img class="anulada" src="img/anulado.png" alt="Anulada">
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/logo.png">
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="h2">
						<label class="h2 color_azul_navy">SISTEMA VENTAS</label>
						<label class="h2"> - </label>
						<label class="h2 color_rojo">ACCESORIOS ASTUDILLO</label>
					</span>
					<p class="h4"><span class="bold">Dirección:</span> Av huancavilca y Ayacucho</p>
					<p class="h4"><span class="bold">Teléfono:</span> +(593)987272270  - (2)102030</p>
					<p class="h4"><span class="bold">Email:</span> lastudillo5@hotmail.com</p>
				</div>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3 color_blanco"><span class="h4">Factura</span></span>
					<p class="h5 bold">No. Factura: <strong><span class="h5">000001</span></strong></p>
					<p class="h5 bold">Fecha: <span class="h5"><?php echo getFecha(); ?></span></p>
					<p class="h5 bold">Hora: <span class="h5"><?php echo getHora(); ?></span></p>
					<p class="h5 bold">Vendedor: <span class="h5">Administrador</span></p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3 color_blanco"><span class="h4">Cliente</span></span>
					<table class="datos_cliente">
						<tr>
							<td><label>Nit:</label><p>54895468</p></td>
							<td><label>Teléfono:</label> <p>7854526</p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p>Angel Arana Cabrera</p></td>
							<td><label>Dirección:</label> <p>Calzada Buena Vista</p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA (12%)</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL Q.</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, pongase en contacto via telefonico.</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>

</div>

</body>
</html>


<style type="text/css">
.color_azul_navy{
		color: darkblue;
	}
.color_rojo{
		color: red;
}

.color_blanco{
	color: white;
}

.bold{
	font-weight: bold;
}

</style>