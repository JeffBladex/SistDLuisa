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
			<th>Nombre Categoria</th>
			<th>Código Articulo</th>
			<th>Nombre</th>
			<th>Descripción</th>
		</thead>

		<tbody style="text-align: center;">
			<?php
				if($_REQUEST['RArt_FD'] != '' && $_REQUEST['RArt_FH'] != ''){
					$fechaDesde = $_REQUEST['RArt_FD'];
					$fechaHasta = $_REQUEST['RArt_FH'];

					$query_select = "SELECT art.idarticulo, art.fecha_add as fecha, cat.nombre AS nombre_categoria, art.codigo, art.nombre AS nombre_articulo, art.descripcion
					FROM articulo AS art JOIN categoria as cat on art.idcategoria = cat.idcategoria
					WHERE art.estatus =1 and date(art.fecha_add) >= date('$fechaDesde') and date(art.fecha_add) <= date('$fechaHasta')
					ORDER BY cat.nombre ASC";

		 		$query_select = mysqli_query($con, $query_select);

		 		$result_query_select = mysqli_num_rows($query_select);

		 		if ($result_query_select > 0) {
		 			# code...
		 			while ($data = mysqli_fetch_array($query_select)) {
		 				# code...
			 ?>

			<tr>
				<td><?php echo $data['idarticulo']; ?></td>
				<td><?php echo $data['fecha']; ?></td>
				<td><?php echo $data['nombre_categoria']; ?></td>
				<td><?php echo $data['codigo']; ?></td>
				<td><?php echo $data['nombre_articulo']; ?></td>
				<td><?php echo $data['descripcion']; ?></td>
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
	header("Content-Disposition: attachment; filename=Reporte_Articulos_Rangos.xls");
	exit;
 ?>

