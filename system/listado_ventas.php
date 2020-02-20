<?php 
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

 ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Listado-Ventas || Sistema-Accesorios D-ASTU</title>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>

		<?php include_once 'dataTable.php'; ?>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>

		<!-- JavaScript Functions -->
		<script type="text/javascript" src="js/functions.js"></script>

		<?php include_once 'modal.php'; ?>

		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u></i>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-user-friends"></i> Listado de Ventas</h3>
				<hr>

				<a href="nueva_venta.php" class="btn btn-info"><i class="fas fa-file-alt"></i> Nueva Venta</a>

				<br><br>

				<div>
					<h5 class="azul_chillon">Buscar por Fecha</h5>
					<form action="#" method="POST" class="form_search_date">
						<label><b>Desde:</b> </label>
						<input type="date" name="fecha_desde" id="fecha_desde" required>

						<label><b>Hasta:</b> </label>
						<input type="date" name="fecha_hasta" id="fecha_hasta" required>

						<button type="submit" class="btn_view btn_filtrar_ventas"><img src="img/search.png" width="24" height="24"></button>
						<a href="listado_ventas.php" style="background-color: orange;color:black;"> &nbsp;QUITAR FILTRO</a>

					</form>
				</div>
					
				<div>
					<h5 class="azul_chillon">Listar Ventas</h5>
						<div class="listar_ventas bd-verde bg-verde">
							<a href="listar_ventas/listar_ventasExcel.php">EXCEL</a>
						</div>
						<div class="listar_ventas bd-azul bg-azul">
							<a href="listar_ventas/listar_ventasWord.php">WORD</a>
						</div>
				</div>

				<?php 
					$filtrar_desde = '';
					$filtrar_hasta = '';

					if (!empty($_POST)) {
						# code...
						$filtrar_desde = $_POST['fecha_desde'];
						$filtrar_hasta = $_POST['fecha_hasta'];
					}
				 ?>

				 <br>

				<div>
					<table id="example" class="table table-striped table-bordered table-sm text-center" style="width:100%">
						<thead>
							<tr class="table-primary">
								<th>No. Fact</th>
								<th>Fecha/Hora</th>
								<th>Cliente</th>
								<th>Vendedor</th>
								<th>Estado</th>
								<th>Total Factura</th>
								<th>Acciones</th>
								<th>Exportar</th>
								
							</tr>
						</thead>
						<?php
							if ($filtrar_desde != '' && $filtrar_hasta != '') {
								# code...
									$query_get_ventas = "SELECT f.nrofactura, f.fecha, f.total_factura, f.idcliente, f.estatus,
								user.nombre as vendedor, cliente.nombre as cliente
								FROM factura AS f
								JOIN usuario AS user
								ON f.idusuario = USER.idusuario
								JOIN cliente AS cliente
								ON f.idcliente = cliente.idcliente
								WHERE f.estatus =1 and
								date(f.fecha) >= date('$filtrar_desde') and date(f.fecha) <= date('$filtrar_hasta')
								ORDER BY f.fecha ASC";
							}else{
								$query_get_ventas = "SELECT f.nrofactura, f.fecha, f.total_factura, f.idcliente, f.estatus,
								user.nombre as vendedor, cliente.nombre as cliente
								FROM factura AS f
								JOIN usuario AS user
								ON f.idusuario = USER.idusuario
								JOIN cliente AS cliente
								ON f.idcliente = cliente.idcliente
								WHERE f.estatus >= 0
								ORDER BY f.fecha ASC";
							}
							$query_get_ventas = mysqli_query($con, $query_get_ventas);
							$result_get_ventas = mysqli_num_rows($query_get_ventas);
						
						?>
						<tbody>
							<?php
							
								if($result_get_ventas > 0){
									while ($data_getVentas = mysqli_fetch_array($query_get_ventas)) {
									if($data_getVentas['estatus'] == 1){
										$estado = '<span class="pagada">Pagada</span>';
									}else{
										$estado = '<span class="anulada">Anulada</span>';
									}
							?>
							
							<tr class="row_<?php echo $data_getVentas['nrofactura']; ?>">
								<td><?php echo $data_getVentas['nrofactura'];?></td>
								<td><?php echo $data_getVentas['fecha']; ?></td>
								<td><?php echo $data_getVentas['cliente']; ?></td>
								<td><?php echo $data_getVentas['vendedor']; ?></td>
								<td><?php echo $estado;  ?></td>
								<td class="totalfactura">
									<span>$.</span><?php echo $data_getVentas['total_factura'];  ?>
								</td>
								
								<td>
									<div class="div_acciones">
										<div>
											<button class="btn_view view_factura btn btn-primary" type="button" cli="<?php echo $data_getVentas['idcliente'];  ?>" fact="<?php echo $data_getVentas['nrofactura'] ?>"><img src="img/look.png" width="26" height="26"></button>
											
										</div>
									</div>
									<?php
										if($_SESSION['rol'] == 'Admin'){
											if ($data_getVentas['estatus'] == 1) {
												# code...
											
									?>
									<div class="div_factura">
										<a class="btn_anular btn btn-danger anular_factura"  cli="<?php echo $data_getVentas['idcliente'];  ?>" fact="<?php echo $data_getVentas['nrofactura'] ?>" data-toggle="modal" data-target="#myModal_Anular_Fact" href="#"><img src="img/cancel.png" width="26" height="26"></a>
									</div>
									<?php
											}else{
									?>
									<div class="div_factura">
										<button type="button" class="btn_anular inactive btn btn-secondary"><img src="img/inactive_cancel.png" width="26" height="26"></button>
									</div>
									<?php
											}
										}
									?>
								</td>
								<td>
									<div class="exportar">
										<button class="btn btn-warning" onclick="downloadFile_Pdf(<?php echo $data_getVentas['idcliente'] ?>, <?php echo $data_getVentas['nrofactura'] ?>);"><img src="img/pdf-logo.png" width="32" height="32" alt="PDF"></button>

										<a class="btn btn-success" href="descargaExcel_id.php?cli=<?php echo $data_getVentas['idcliente']; ?>&fact=<?php echo $data_getVentas['nrofactura']; ?>"><img src="img/excel-logo.png"  alt="EXCEL" width="32" height="32"></a>
										
										<a class="btn btn-primary" href="descargaWord_id.php?cli=<?php echo $data_getVentas['idcliente']; ?>&fact=<?php echo $data_getVentas['nrofactura']; ?>"><img src="img/word-logo.png"  alt="WORD" width="32" height="32"></a>
									</div>
								</td>
								
							</tr>
							<?php
							}
							}
							?>
						</tbody>
						
					</table>
				</div>

				<section name="anularFactura" id="anularFactura">
					<div class="modal" id="myModal_Anular_Fact" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Anular Factura</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
			
							<form action="" method="POST" name="form_anular_fact" id="form_anular_fact" onsubmit="event.preventDefault(); anularFactura();" accept-charset="UTF-8">
								<h1><i class="fa fa-file-text-o" style="font-size: 35pt;"></i> Anular Factura</h1>
								<p class="alert alert-danger" role="alert">Realmente Desea Anular la Factura?</p>
							
								<br>
								<p><strong>No. Fact <span class="anuNroFactura" id="anuNroFactura"></span></strong></p>
								<p><strong>Total Fact. <span class="anuTotFact" id="anuTotFact"></span></strong></p>
								<p><strong>Fecha. <span class="anuFecha" id="anuFecha"></span></strong></p>

								<!-- Ocultos -->
								<input type="hidden" name="action" value="anularFactura" required>
								<input type="hidden" name="NroFactura" id="NroFactura" required>
								<br>
							
								<div class="alert alertAnuFact"></div>

								<button type="submit" class="btn btn-danger btn_new"><i class="fas fa-exclamation-circle"> Anular</i></button>

								<a href="#" type="button" data-dismiss="modal" class="btn btn-secondary closeModal" onclick="closeModal_Anular_Fact();"><i class=""></i> Cerrar</a>
							</form>
						</div>
						<!-- <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div> -->
					</div>
				</div>
			</div>
				</section>

				
			</div>
		</section>
		<!-- Footer -->
		<?php include_once 'footer.php'; ?>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
    	$('#example').DataTable({
    		"language": {
      			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    		}
    	});
	} );
</script>

<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>
 
 <style type="text/css">
 	.azul_chillon{
 		color: blue;
 		font-weight: bold;
 		background-color: lightgray;
 		padding: 0.25em;
 	}
 </style>