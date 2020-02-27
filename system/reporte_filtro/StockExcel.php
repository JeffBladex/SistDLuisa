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
			<th>Descripción Articulo</th>
			<th>Tipo Comprobante</th>
			<th>Serie Comprobante</th>
			<th>Num Comprobante</th>
			<th>Existencia</th>
			<th>P.Compra</th>
			<th>P.Venta</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RStock_FD'] != '' && $_REQUEST['RStock_FH'] != ''){
					$fechaDesde = $_REQUEST['RStock_FD'];
					$fechaHasta = $_REQUEST['RStock_FH'];

					$query_select = "SELECT stock.idcompras, stock.fecha_add as fecha, pro.nombre as nombre_proveedor, art.nombre as nombre_articulo,art.descripcion as descripcion_articulo, stock.tipo_comprobante, stock.serie_comprobante, stock.num_comprobante, stock.existencia, stock.precio_compra, stock.precio_venta
						FROM compras AS stock 
						JOIN proveedor AS pro on stock.idproveedor = pro.idproveedor
						JOIN articulo AS art on stock.idarticulo = art.idarticulo
						WHERE stock.estatus =1 AND date(stock.fecha_add) >= date('$fechaDesde') AND date(stock.fecha_add) <= date('$fechaHasta') ORDER BY stock.fecha_add ASC";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['idcompras']; ?></td>
				<td><?php echo $data['fecha']; ?></td>
				<td><?php echo $data['nombre_proveedor']; ?></td>
				<td><?php echo $data['nombre_articulo']; ?></td>
				<td><?php echo $data['descripcion_articulo']; ?></td>
				<td><?php echo $data['tipo_comprobante']; ?></td>
				<td><?php echo $data['serie_comprobante']; ?></td>
				<td><?php echo $data['num_comprobante']; ?></td>
				<td><?php echo $data['existencia']; ?></td>
				<td><?php echo $data['precio_compra']; ?></td>
				<td><?php echo $data['precio_venta']; ?></td>

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

