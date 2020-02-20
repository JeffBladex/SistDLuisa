<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>REPORTE EXCEL FILTRO</title>

	<?php include_once '../functions.php'; ?>
	<?php include_once '../bootstrap.php'; ?>

	<?php 
		// Conexion
		require_once "../db_connection/connection.php";
		require_once "../dompdfDownloderfile/dompdf_config.inc.php";

		ob_start();
	 ?>
</head>
<body>
			<span><strong>Fecha de Creación de Archivo:</strong> <?php echo getFecha();?></span><br>
			<span><strong>Fecha de Creación de Archivo:</strong> <?php echo getHora();?></span><br>
	<table style="text-align: center;" class="text-center">
		<thead style="text-align: center;">
			<th>ID</th>
			<th>Fecha Agg</th>
			<th>Código Proveedor</th>
			<th>Nombre</th>
			<th>Teléfono</th>
			<th>Dirección</th>
			<th>Email</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RProv_FD'] != '' && $_REQUEST['RProv_FH'] != ''){
					$fechaDesde = $_REQUEST['RProv_FD'];
					$fechaHasta = $_REQUEST['RProv_FH'];

					$query_select = "SELECT prov.idproveedor, date(prov.fecha_add) as fecha_prov, prov.cod_proveedor, prov.nombre, prov.telefono, prov.direccion,
						prov.email
						FROM proveedor as prov
						WHERE prov.estatus = 1 AND date(prov.fecha_add) >= date('fechaDesde') AND date(prov.fecha_add) <= date('$fechaHasta') ORDER BY fecha_add ASC";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['idproveedor']; ?></td>
				<td><?php echo $data['fecha_prov']; ?></td>
				<td><?php echo $data['cod_proveedor']; ?></td>
				<td><?php echo $data['nombre']; ?></td>
				<td><?php echo $data['telefono']; ?></td>
				<td><?php echo $data['direccion']; ?></td>
				<td><?php echo $data['email']; ?></td>
			</tr>

			<?php 
						}

		 			}
		 		}
			 ?>

		</tbody>
	</table>
</body>
</html>

<?php 
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Reporte_Proveedores_Rangos.xls");
	exit;
 ?>

