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
			<th>Tipo de Documento</th>
			<th>Número de Documento</th>
			<th>Nombre</th>
			<th>Teléfono</th>
			<th>Dirección</th>
			<th>Email</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RCli_FD'] != '' && $_REQUEST['RCli_FH'] != ''){
					$fechaDesde = $_REQUEST['RCli_FD'];
					$fechaHasta = $_REQUEST['RCli_FH'];

					$query_select = "SELECT cli.idcliente, date(cli.fecha_add) as fecha_cli, cli.tipo_documento,
			 			cli.numero_documento, cli.nombre, cli.telefono, cli.direccion, cli.email
					FROM cliente as cli
		 			WHERE cli.estatus = 1 AND date(cli.fecha_add) >= date('$fechaDesde') and  date(cli.fecha_add) <= date('$fechaHasta') ORDER BY cli.fecha_add ASC";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['idcliente']; ?></td>
				<td><?php echo $data['fecha_cli']; ?></td>
				<td><?php echo $data['tipo_documento']; ?></td>
				<td><?php echo $data['numero_documento']; ?></td>
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
	header("Content-Disposition: attachment; filename=Reporte_Clientes_Rangos.xls");
	exit;
 ?>

