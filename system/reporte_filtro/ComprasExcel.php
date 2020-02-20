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
			<th>Nombre Proveedor</th>
			<th>Nombre Articulo</th>
			<th>Tipo Comprobante</th>
			<th>Serie Comprobante</th>
			<th>Num Comprobante</th>
			<th>Cantidad</th>
			<th>Precio Compra</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RComp_FD'] != '' && $_REQUEST['RComp_FH'] != ''){
					$fechaDesde = $_REQUEST['RComp_FD'];
					$fechaHasta = $_REQUEST['RComp_FH'];

					$query_select = "SELECT rc.idRegistroCompras, rc.fecha_add as fecha, pro.nombre as nombre_proveedor, art.nombre as nombre_articulo,
					rc.tipo_comprobante, rc.serie_comprobante, rc.num_comprobante, rc.existencia as cantidad, rc.precio_compra
					FROM registro_compras as rc 
					JOIN proveedor as pro on rc.idproveedor = pro.idproveedor
					JOIN articulo as art on rc.idarticulo = art.idarticulo
					WHERE rc.estatus=1 and date(rc.fecha_add) >= date('$fechaDesde') and date(rc.fecha_add) <= date('$fechaHasta')";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['idRegistroCompras']; ?></td>
				<td><?php echo $data['fecha']; ?></td>
				<td><?php echo $data['nombre_proveedor']; ?></td>
				<td><?php echo $data['nombre_articulo']; ?></td>
				<td><?php echo $data['tipo_comprobante']; ?></td>
				<td><?php echo $data['serie_comprobante']; ?></td>
				<td><?php echo $data['num_comprobante']; ?></td>
				<td><?php echo $data['cantidad']; ?></td>
				<td><?php echo $data['precio_compra']; ?></td>
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
	header("Content-Disposition: attachment; filename=Reporte_Compras_Rangos.xls");
	exit;
 ?>

