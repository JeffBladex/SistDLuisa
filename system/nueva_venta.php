<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

 	session_start();
 	require_once "./db_connection/connection.php";

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Registro-Nueva_Compras|| Sistema-Accesorios D-ASTU</title>
</head>
<body>
	<!-- Scripts -->
	<?php include_once 'scripts.php'; ?>
		<!-- Header -->
	<?php include_once 'header.php'; ?>

	<!-- FontAwesome - Online -->
	<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>
	<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>

	<!-- JavaScript Functions -->
	<script type="text/javascript" src="js/functions.js"></script>

	<section id="container">

		<div class="title_page">
			<h1><i class="fas fa-address-book"></i> Nueva Venta</h1>
		</div>

		<div class="datos_cliente">
			<div class="action_cliente">
				<h4>Datos Cliente</h4> &nbsp; &nbsp;
				<a href="#" class="btn btn-warning btn_new btn_new_cliente"><i class="fas fa-user-plus"> Nuevo Cliente</i></a>
			</div>

			<br> 	
			<h4 style="color:darkblue;"><b>Datos Cliente</b></h4>

			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" onsubmit="event.preventDefault();">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" name="idcliente" id="idcliente" value="" required>
					<div class="">
						<label><b>Número de Documento: </b></label>
						<input type="text" class="border border-primary border-redondear text-center" size="25" name="num_identificacion_cliente" id="num_identificacion_cliente">
					</div>

					<div class="">
						<label><b>Tipo de Documento: </b></label>
						<select name="tipo_documento" id="tipo_documento" class="border border-primary border-redondear" disabled required>
							<option value="1">Cédula</option>
							<option value="2">Ruc</option>
						</select>
					</div>

					<div class="">
						<label><b>Nombre: </b></label>
						<input type="text" class="border border-primary border-redondear text-center" size="70" name="nom_cliente" id="nom_cliente" disabled required>
					</div>
					<div class="">
						<label><b>Teléfono: </b></label>
						<input type="text" class="border border-primary border-redondear text-center" size="30" name="tel_cliente" id="tel_cliente" disabled required>
					</div>
					<div class="">
						<label><b>Dirección: </b></label>
						<input type="text" class="border border-primary border-redondear text-center" size="70" name="dir_cliente" id="dir_cliente" disabled>
					</div>
					<div id="div_registro_cliente" class="">
						<button type="submit" class="btn btn-success btn_save_cliente"><i class="far fa-save fa-lg"> Guardar</i></button>
						<a href="#" type="button" class="link_clean btn btn-light"><i class="fas fa-skull-crossbones fa-lg" onclick="Limpiar_Datos_Cliente();"> Limpiar</i></a>
					</div>
			</form>
		</div>

		<br>

		<div class="datos_venta">
			<h4 style="color:darkblue;"><b>Datos de Venta</b></h4>
			<div class="datos">
				<div class="wd50">
					<label><b>Vendedor:</b></label>
					<p class="vendedor"><?php echo $_SESSION['nombre']; ?></p>
				</div>
				<div class="wd50">
					<label class="ocultar"><b>Secuencia de Ventas:</b></label>
					<input type="number" name="txt_secuencia_venta" id="txt_secuencia_venta" value="0" class="text-center resaltar_verde_claro ocultar" min="1" disabled>
				</div>
				<div class="wd50">
					<label><b>Acciones:</b></label>
					<div id="acciones_venta">
						<a href="#" class="btn btn-danger text-center btn_anular_venta" id="btn_anular_venta"><i class="fas fa-ban fa-lg"> Anular</i></a>
						<a href="#" class="btn btn-success text-center btn_preocesar_venta" id="btn_procesar_venta" style="display: none;"><i class="far fa-arrow-alt-circle-right fa-lg"> Procesar</i></a>

					</div>

					<div class="acciones_exportacion">
						<label><b>Acciones Exportación:</b></label> <br>
						<a href="#" class="btn btn-warning text-center btn_expo_pdf" id="btn_expo_pdf" ><i class="far fas fa-check-circle"> Exp.Pdf</i></a>

						<a href="factura/generaExcel.php" target="_blank" class="btn btn-success text-center btn_expo_excel" id="btn_expo_excel"><i class="far fas fa-check-circle"> Exp.Excel</i></a>

						<a href="factura/generaWord.php" target="_blank" class="btn btn-primary text-center btn_expo_word" id="btn_expo_word"><i class="far fas fa-check-circle"> Exp.Word</i></a>

					</div>
				</div>

			</div>
		</div>

		<br>

		<?php 
			$query_Articulos_en_Stock = "SELECT DISTINCT(UPPER(articulo.nombre)) AS nombre_articulo
			FROM compras as compras JOIN articulo as articulo 
			ON compras.idarticulo = articulo.idarticulo
			WHERE compras.existencia>0 AND compras.estatus=1 ORDER BY articulo.nombre asc";
			$query_Articulos_en_Stock = mysqli_query($con, $query_Articulos_en_Stock);
			
		 ?>

		<table class="table table-striped table-bordered table-sm text-center table_venta" style="width:100%" onchange="viewProcesar();">
			<thead class="text-center">
				<tr class="table-primary">
					<th width="100px">Código-Artículo</th>
					<th width="100px">Articulo:</th>
					<!-- <th>Descripción</th> -->
					<th>Existencia</th>
					<th width="100px">Cantidad</th>
					<th class="text-center">Precio Min</th>
					<th class="text-center">Precio Max</th>
					<th class="text-center">Precio Pagar</th>
					<th class="text-center">Precio Total</th>

					<th>Acción</th>
				</tr>

				<tr>
					<td><input class="border border-primary border-redondear resaltar_amarillo text-center" type="text" name="txt_cod_articulo" id="txt_cod_articulo" size="15"></td>

					<!-- Nombre Del Articulo -->
					<!-- <td>
						<select name="Articulo_List" id="Articulo_List" class="border border-primary border-redondear resaltar_amarillo text-center">

						<?php 

						$result_num_rows_art = mysqli_num_rows($query_Articulos_en_Stock);

						if($result_num_rows_art > 0){
							$c = 0;
							while ($data_art_stock = mysqli_fetch_array($query_Articulos_en_Stock)) {
								# code...
						?>
								<option value="<?php echo $data_art_stock['nombre_articulo']; ?>"><?php echo $data_art_stock['nombre_articulo'];?></option>
						
						<?php 
								 $c = c + 1;
								}

							}
						 ?>

						</select>

					</td> -->

					<td id="ArticuloGet">-</td>


					<!-- <td id="txt_descripcion">-</td> -->
					<td id="txt_existencia">-</td>

					<td><input class="text-center border border-primary border-redondear text-center" type="number" name="txt_cant_articulo" id="txt_cant_articulo" size="10" value="0" min="1" step="1" disabled></td>

					<td id="txt_precio_min" class="text-right">0.00</td>
					<td id="txt_precio_max" class="text-right">0.00</td>

					<td><input class="text-center border border-primary border-redondear text-center" type="text" name="txt_precio_pagar" id="txt_precio_pagar" size="10" value="0" min="0.00" disabled></td>

					<!-- <td id="txt_precio_pagar" class="text-right">0.00</td>
 -->
					<td id="txt_precio_total" class="text-right">0.00</td>

					<td><a href="#" id="add_Articulo_Venta" class="link_add"><i class="fas fa-plus color-verde"></i><label class="color-verde">Agregar</label></a></td>
				</tr>

				<tr class="table-primary">
					<th>Código-Artículo</th>
					<th colspan="3">Descripción</th>

					<th>Cantidad</th>
					<!-- <th class="text-right"></th> -->
					<th class="text-center"></th>
					<th class="text-center">Precio Pagar</th>
					<th class="text-center">Total</th>
					<!-- <th>Acción</th> -->
				</tr>
			</thead>

			<tbody id="detalle_venta" class="text-center">
				<!-- <tr>
					<td>1</td>
					<td colspan="2">Mouse Usb</td>
					<td class="text-center">1</td>
					<th class="text-right"></th>
					<th class="text-right"></th>
					<td class="text-right">100.00</td>
					<td class="text-right">100.00</td>
					<td class="">
						<a href="#" class="link_delete" onclick="event.preventDefault(); delete_articulo_detalle(1);"><i class="fas fa-trash-alt"></i></a>
					</td>
				</tr>

				<tr>
					<td>1</td>
					<td colspan="2">Teclado Usb</td>
					<td class="text-center">1</td>
					<th class="text-right"></th>
					<th class="text-right"></th>
					<td class="text-right">150.00</td>
					<td class="text-right">150.00</td>
					<td class="">
						<a href="#" class="link_delete" onclick="event.preventDefault(); delete_articulo_detalle(1);"><i class="fas fa-trash-alt"></i></a>
					</td>
				</tr> -->

				<!-- CONTENIDO AJAX -->
			</tbody>

			<tfoot id="detalle_totales">
				<!-- <tr>
					<td colspan="7" class="text-right"><b>SUBTOTAL $</b></td>
					<td class="text-right">250.00</td>
				</tr>
				<tr>
					<td colspan="7" class="text-right"><b>IVA(12%) $</b></td>
					<td class="text-right">50.00</td>
				</tr>
				<tr>
					<td colspan="7" class="text-right"><b>TOTAL $</b></td>
					<td class="text-right">300.00</td>
				</tr> -->

				<!-- CONTENIDO AJAX -->



			</tfoot>

		</table>



	</section>

</body>
</html>

<style type="text/css">
	.color-verde{
		color: green;
	}

	.link_add:hover{
		color: darkgreen;
		border-bottom: dotted;
	}

	.link_delete:hover{
		color: blue;
		border-bottom: dotted;
	}

	.vendedor{
		color: blue;
	}

	.resaltar_amarillo{
		background-color: #ffff33;
	}

	.resaltar_verde_claro{
		background-color: lightgreen;
	}

	.ocultar{
		display: none;
	}

</style>

<!-- <script type="text/javascript">
	$(document).ready(function(){
			var action = 'getUltimoValordeSecuencia_Venta';
			var ultimo_val_secuencia = $('#txt_secuencia_venta').val();

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, secuencia:ultimo_val_secuencia},

			success: function(response){
				console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);
					var secuencia_Activa = parseInt(info_success.secuencia);

					searchForDetalle(secuencia_Activa);
				}
			},

			error: function(error){
				console.log(error) ;
			}

		})

	});
</script> -->