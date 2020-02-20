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
			<th>NroFactura</th>
			<th>Fecha Agg</th>
			<th>Nombre Cliente</th>
			<th>P.Base</th>
			<th>P.Iva</th>
			<th>Total</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RVentas_FD'] != '' && $_REQUEST['RVentas_FH'] != ''){
					$fechaDesde = $_REQUEST['RVentas_FD'];
					$fechaHasta = $_REQUEST['RVentas_FH'];

					$query_select = "SELECT fact.nrofactura, fact.fecha, cli.nombre, fact.pbase, fact.piva, fact.total_factura
					FROM factura as fact 
					JOIN cliente as cli on fact.idcliente = cli.idcliente
					WHERE fact.estatus = 1 and date(fact.fecha) >= date('$fechaDesde') and  date(fact.fecha) <= date('$fechaHasta')";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['nrofactura']; ?></td>
				<td><?php echo $data['fecha']; ?></td>
				<td><?php echo $data['nombre']; ?></td>
				<td><?php echo $data['pbase']; ?></td>
				<td><?php echo $data['piva']; ?></td>
				<td><?php echo $data['total_factura']; ?></td>
				
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
	header("Content-Disposition: attachment; filename=Reporte_Stock_Rangos.xls");
	exit;
 ?>

