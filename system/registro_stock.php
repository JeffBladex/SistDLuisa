<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

	session_start();
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';

		if(empty($_POST['idproveedor']) || empty($_POST['idarticulo']) || empty($_POST['tipo_comprobante']) || empty($_POST['serie_comprobante']) || empty($_POST['numero_comprobante']) || empty($_POST['existencia']) || empty($_POST['precio_compra']) || empty($_POST['precio_venta'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idproveedor = '';
			$idarticulo = '';
			$tipo_comprobante = '';
			$serie_comprobante = '';
			$numero_comprobante = '';
			$existencia = '';
			$precio_compra = '';
			$precio_venta = '';

			$idproveedor = $_POST['idproveedor'];
			$idarticulo = $_POST['idarticulo'];
			$tipo_comprobante = $_POST['tipo_comprobante'];
			$serie_comprobante = $_POST['serie_comprobante'];
			$numero_comprobante = $_POST['numero_comprobante'];
			$existencia = $_POST['existencia'];
			$precio_compra = $_POST['precio_compra'];
			$precio_venta = $_POST['precio_venta'];

			$idusuario = $_SESSION['idusuario'];

			// $Serie_Num_Comprobante = $serie_comprobante .'-'. $numero_comprobante;

			// $query = "SELECT concat(compras.serie_comprobante,'-', compras.num_comprobante) AS serie_num_comprobante
			// 	FROM compras AS compras WHERE concat(compras.serie_comprobante,'-', compras.num_comprobante) = '$Serie_Num_Comprobante'";

			// $query = mysqli_query($con, $query);
			// $result = mysqli_fetch_array($query);

			// if($result > 0  && $result['serie_comprobante'] != '' && $result['numero_comprobante'] != ''){
			// 	$alert = '<p class="alert alert-danger" role="alert">La Serie y Número de Comprobante, ya han sido Registrados. !!!</p>';
			// }else{

			// 	$query = "INSERT INTO compras(idproveedor, idarticulo, tipo_comprobante, serie_comprobante, num_comprobante, existencia, precio_compra, precio_venta,idusuario)
			// 		VALUES('$idproveedor','$idarticulo','$tipo_comprobante','$serie_comprobante','$numero_comprobante','$existencia','$precio_compra','$precio_venta','$idusuario')";

			// 	$query_insert = mysqli_query($con, $query);

			// 	if($query_insert){
			// 		$alert = '<p class="alert alert-success" role="alert">El Registro de Stock fue Correctamente Ingresado. !!!</p>';
			// 	}else{
			// 		$alert = '<p class="alert alert-danger" role="alert">Error Al Registrar el Stock. !!!</p>';
			// 	}

				
			// }

				$query = "INSERT INTO compras(idproveedor, idarticulo, tipo_comprobante, serie_comprobante, num_comprobante, existencia, precio_compra, precio_venta,idusuario)
					VALUES('$idproveedor','$idarticulo','$tipo_comprobante','$serie_comprobante','$numero_comprobante','$existencia','$precio_compra','$precio_venta','$idusuario')";

				$query_insert = mysqli_query($con, $query);

				if($query_insert){
					$alert = '<p class="alert alert-success" role="alert">El Registro de Stock fue Correctamente Ingresado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Registrar el Stock. !!!</p>';
				}

		}
	}

 ?> 


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Registro-Stock|| Sistema-Accesorios D-ASTU</title>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>

		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-user-tie"></i> Registro Stock</h3>
				<hr>
				<form action="" method="POST">
					<!-- Proveedor -->
					<div class="row">
						<div class="col-sm-7">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
								</div>

								<?php 
									$query_proveedor= "SELECT * FROM proveedor ORDER BY nombre ASC";

									$query_proveedor= mysqli_query($con,$query_proveedor);
									$result_proveedor = mysqli_num_rows($query_proveedor);
								 ?>

									<select name="idproveedor" id="idproveedor" class="custom-select text-center">
									<?php 
										if($result_proveedor >0){
											while ($proveedor = mysqli_fetch_array($query_proveedor)) {
									 ?>
									 			<option value="<?php echo $proveedor['idproveedor'] ?>">
									 				<?php 
									 					echo $proveedor['nombre'];
									 				 ?>
									 			</option>

									 			<?php 
											}
										}
									?>
									
								</select>

							</div>
						</div>
					</div>

					<br>

					<!-- Articulo -->

					<div class="row">
						<div class="col-sm-7">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Artículo</b></label>
								</div>

								<?php 
									$query_articulo= "SELECT * FROM articulo ORDER BY nombre ASC ";

									$query_articulo= mysqli_query($con,$query_articulo);
									$result_articulo = mysqli_num_rows($query_articulo);
								 ?>

									<select name="idarticulo" id="idarticulo" class="custom-select text-center">
									<?php 
										if($result_articulo >0){
											while ($articulo = mysqli_fetch_array($query_articulo)) {
									 ?>
									 			<option value="<?php echo $articulo['idarticulo'] ?>">
									 				<?php 
									 					echo $articulo['nombre'];
									 				 ?>
									 			</option>

									 			<?php 
											}
										}
									?>
									
									</select>

							</div>
						</div>
					</div>

					<br>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Tipo Comprobante</b></span>
								</div>
								<input type="text" name="tipo_comprobante" id="tipo_comprobante" class="form-control text-center" value="FACTURA" aria-label="Tipo Comprobante" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Serie Comprobante</b></span>
								</div>
								<input type="text" name="serie_comprobante" id="serie_comprobante" class="form-control text-center" placeholder="Serie Comprobante..." aria-label="Serie Comprobante" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Número Comprobante</b></span>
								</div>
								<input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control text-center" placeholder="Número Comprobante..." aria-label="Numero Comprobante" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Existencia</b></span>
								</div>
								<input type="text" name="existencia" id="existencia" class="form-control text-center" placeholder="Existencia..." aria-label="EXistencia" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Precio Compra</b></span>
								</div>
								<input type="text" name="precio_compra" id="precio_compra" class="form-control text-center" placeholder="Precio Compra..." aria-label="Precio Compra" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Precio Venta</b></span>
								</div>
								<input type="text" name="precio_venta" id="precio_venta" class="form-control text-center" placeholder="Precio Venta..." aria-label="Precio Venta" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>
					
					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Registrar Stock" class="btn btn-primary">
						</div>
					</div>

					<br>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="alert">
								<b>
									<?php 
										echo isset($alert)? $alert: '';

									 ?>

								</b>
							</div>
						</div>
					</div>
					
				</form>
			</div>
		</section>
		<!-- Footer -->
		<?php include_once 'footer.php'; ?>
	</body>
</html>

<style type="text/css">
	.campo_No_Obligatorio{
		background-color: #ffe066;
	}
</style>


<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>