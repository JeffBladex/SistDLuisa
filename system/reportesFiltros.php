<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Reportes Filtro || Sistema-Accesorios D-ASTU</title>

	<!-- FontAwesome Cdn -->
	<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>
	<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>
	
</head>
<body>
	<!-- Scripts -->
	<?php include_once 'scripts.php'; ?>

	<!-- Header -->
	<?php include_once 'header.php'; ?>

	<?php include_once 'modal.php'; ?>

	<!-- Incluyendo functions.js -->
	<script type="text/javascript" src="js/functions.js"></script>

	<section id="container">
		<!-- Clientes -->
		<div class="ReporteClientes_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RClientes text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE CLIENTES X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRClientes_R" id="FechaDesdeRClientes_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRClientes_R" id="FechaHastaRClientes_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<!-- <input type="submit" name="Btn_ClientesR" id="Btn_ClientesR" class="btn btn-primary color_yellow" value="DESCARGAR"> -->
						<a href="#" class="btn btn-primary btn_RClientes_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		<!-- Proveedores -->
		<div class="ReporteProveedores_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RProveedores text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE PROVEEDORES X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRProveedores_R" id="FechaDesdeRProveedores_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRProveedores_R" id="FechaHastaRProveedores_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<a href="#" class="btn btn-primary btn_RProveedores_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		<!-- Articulos -->
		<div class="ReporteArticulos_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RArticulos text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE ARTICULOS X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRArticulos_R" id="FechaDesdeRArticulos_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRArticulos_R" id="FechaHastaRArticulos_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<a href="#" class="btn btn-primary btn_RArticulos_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		<!-- Compras -->
		<div class="ReporteCompras_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RCompras text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE COMPRAS X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRCompras_R" id="FechaDesdeRCompras_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRCompras_R" id="FechaHastaRCompras_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<a href="#" class="btn btn-primary btn_RCompras_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		<!-- Stock -->
		<div class="ReporteStock_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RStock text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE STOCK X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRStock_R" id="FechaDesdeRStock_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRStock_R" id="FechaHastaRStock_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<a href="#" class="btn btn-primary btn_RStock_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		<!-- Ventas -->
		<div class="ReporteVentas_Filtro">
			<form method="POST" action="">
				<div class="row">
					<div class="col-sm-8 RVentas text-center">
						<h3 class="F_monospace color_navy bold title">GENERAR REPORTE DE VENTAS X RANGO</h3>
						<hr>
						<img src="img/download-icon.png" width="50" height="50"> &nbsp; &nbsp;
						<label><strong>Fecha Desde:</strong></label>
						<input type="date" name="FechaDesdeRVentas_R" id="FechaDesdeRVentas_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp;

						<label><strong>Fecha Hasta:</strong></label>
						<input type="date" name="FechaHastaRVentas_R" id="FechaHastaRVentas_R" class="border border-primary rounded-pill rounded-lg" required> &nbsp; &nbsp;

						<a href="#" class="btn btn-primary btn_RVentas_R color_yellow bold"> DESCARGAR</a>
					</div>
				</div>
			</form>
		</div>

		<br>
		
	</section>

	<section>
		<!-- The Modal-Cliente -->
			<div class="modal" id="myModalRClientes">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>

			<!-- The Modal-Proveedores -->
			<div class="modal" id="myModalRProveedores">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>

			<!-- The Modal-Articulos -->
			<div class="modal" id="myModalRArticulos">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>

			<!-- The Compras -->
			<div class="modal" id="myModalRCompras">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>

			<!-- The Stock -->
			<div class="modal" id="myModalRStock">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>

			<!-- The Ventas -->
			<div class="modal" id="myModalRVentas">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title"><strong class="color_crimson">ALERTA !!!</strong></h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			       	<h5 class="color_navy">SELECCIONE UN RANGO DE FECHAS, PARA GENERAR EL REPORTE PRIMERO</h5 >
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>

			    </div>
			  </div>
			</div>


	</section>
	
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		// Si Click en Clientes 
		$('.btn_RClientes_R').click(function(){
			var fechaDesdeClientes = '';
			var fechaHastaClientes = '';

			// Recuperando Los valores
			fechaDesdeClientes = $('#FechaDesdeRClientes_R').val();
			fechaHastaClientes = $('#FechaHastaRClientes_R').val();

			if (fechaDesdeClientes != '' && fechaHastaClientes != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/ClienteExcel.php?RCli_FD="+fechaDesdeClientes+"&RCli_FH="+fechaHastaClientes;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRClientes').modal('show');
			}	
		});

		// Si Click en Proveedores 
		$('.btn_RProveedores_R').click(function(){
			var fechaDesdeProveedores = '';
			var fechaHastaProveedores = '';

			// Recuperando Los valores
			fechaDesdeProveedores = $('#FechaDesdeRProveedores_R').val();
			fechaHastaProveedores = $('#FechaHastaRProveedores_R').val();

			if (fechaDesdeProveedores != '' && fechaHastaProveedores != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/ProveedoresExcel.php?RProv_FD="+fechaDesdeProveedores+"&RProv_FH="+fechaHastaProveedores;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRProveedores').modal('show');
			}	
		});

		// Si Click en Articulos 
		$('.btn_RArticulos_R').click(function(){
			var fechaDesdeArticulos = '';
			var fechaHastaArticulos = '';

			// Recuperando Los valores
			fechaDesdeArticulos = $('#FechaDesdeRArticulos_R').val();
			fechaHastaArticulos = $('#FechaHastaRArticulos_R').val();

			if (fechaDesdeArticulos != '' && fechaHastaArticulos != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/ArticulosExcel.php?RArt_FD="+fechaDesdeArticulos+"&RArt_FH="+fechaHastaArticulos;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRArticulos').modal('show');
			}	
		});

		// Si Click en Compras 
		$('.btn_RCompras_R').click(function(){
			var fechaDesdeCompras = '';
			var fechaHastaCompras = '';

			// Recuperando Los valores
			fechaDesdeCompras = $('#FechaDesdeRCompras_R').val();
			fechaHastaCompras = $('#FechaHastaRCompras_R').val();

			if (fechaDesdeCompras != '' && fechaHastaCompras != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/ComprasExcel.php?RComp_FD="+fechaDesdeCompras+"&RComp_FH="+fechaHastaCompras;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRCompras').modal('show');
			}	
		});

		// Si Click en Stock 
		$('.btn_RStock_R').click(function(){
			var fechaDesdeStock = '';
			var fechaHastaStock = '';

			// Recuperando Los valores
			fechaDesdeStock = $('#FechaDesdeRStock_R').val();
			fechaHastaStock = $('#FechaHastaRStock_R').val();

			if (fechaDesdeStock != '' && fechaHastaStock != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/StockExcel.php?RStock_FD="+fechaDesdeStock+"&RStock_FH="+fechaHastaStock;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRStock').modal('show');
			}	
		});

		// Si Click en Ventas 
		$('.btn_RVentas_R').click(function(){
			var fechaDesdeVentas = '';
			var fechaHastaVentas = '';

			// Recuperando Los valores
			fechaDesdeVentas = $('#FechaDesdeRVentas_R').val();
			fechaHastaVentas = $('#FechaHastaRVentas_R').val();

			if (fechaDesdeVentas != '' && fechaHastaVentas != '') {
				window.location.href = "http://localhost/sistema_ventas_luisa/system/reporte_filtro/VentasExcel.php?RVentas_FD="+fechaDesdeVentas+"&RVentas_FH="+fechaHastaVentas;
			}else{
				// var msg = "Seleccione un Rango de Fecha Primero";
				$('#myModalRVentas').modal('show');
			}	
		});

	});
</script>

<style type="text/css">
	div.ReporteClientes_Filtro, div.ReporteProveedores_Filtro,  div.ReporteArticulos_Filtro, div.ReporteCompras_Filtro, div.ReporteStock_Filtro, div.ReporteVentas_Filtro {
		margin-left: 1em;
	}

	div.ReporteClientes_Filtro form, div.ReporteProveedores_Filtro form, div.ReporteArticulos_Filtro form, div.ReporteCompras_Filtro form, div.ReporteStock_Filtro form, div.ReporteVentas_Filtro form{

	}

	.RClientes, .RProveedores, .RArticulos, .RCompras, .RStock, .RVentas{
		border: solid 0.25em black;
		padding: 0.5em;
	}

	.F_monospace{
		font-family: monospace;
	}

	.color_navy{
		color: navy;
	}

	.color_yellow{
		color: yellow !important;
	}

	.color_crimson{
		color: crimson;
	}

	.bold{
		font-weight: bold;
	}

	.border-primary{
		border-width: medium;
	}

</style>

