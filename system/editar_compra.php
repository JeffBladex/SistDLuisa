<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['idproveedor']) || empty($_POST['idarticulo']) || empty($_POST['tipo_comprobante']) || empty($_POST['serie_comprobante']) || empty($_POST['num_comprobante']) || empty($_POST['existencia']) || empty($_POST['precio_compra'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idproveedor = '';
			$idarticulo = '';
			$idRegistroCompras = '';
			$tipo_comprobante = '';
			$serie_comprobante = '';
			$num_comprobante = '';
			$existencia = '';
			$precio_compra = '';
			// $precio_venta = '';

			$idproveedor = $_POST['idproveedor'];
			$idarticulo = $_POST['idarticulo'];
			$idRegistroCompras = $_POST['idRegistroCompras'];
			$tipo_comprobante = $_POST['tipo_comprobante'];
			$serie_comprobante = $_POST['serie_comprobante'];
			$num_comprobante = $_POST['num_comprobante'];
			$existencia = $_POST['existencia'];
			$precio_compra = $_POST['precio_compra'];
			// $precio_venta = $_POST['precio_venta'];

			// $serie_num_comprobante = $serie_comprobante . '-' . $num_comprobante;

			// $query = "SELECT concat(rc.serie_comprobante,'-', rc.num_comprobante) AS 		serie_num_comprobante
			// 		FROM registro_compras AS rc
			// 			WHERE (concat(rc.serie_comprobante,'-', rc.num_comprobante) = '$serie_num_comprobante' AND idRegistroCompras!= '$idRegistroCompras')";

			// $query = mysqli_query($con, $query);
			// $result = mysqli_fetch_array($query);

			// if($result > 0){
			// 	$alert = '<p class="alert alert-danger" role="alert">Una Compra con esa serie y número de comprobante, ya han sido Registrados. !!!</p>';
			// }else{
				
			// 		$sql_update_compras = "UPDATE registro_compras 
			// 		SET idproveedor= '$idproveedor',
			// 			idarticulo= '$idarticulo',
			// 			tipo_comprobante='$tipo_comprobante',
			// 			serie_comprobante='$serie_comprobante',
			// 			num_comprobante='$num_comprobante',
			// 			existencia='$existencia',
			// 			precio_compra='$precio_compra'
			// 		WHERE idRegistroCompras= '$idRegistroCompras'
			// 		";

			// 		$query_update1 = '';

			// 		// echo $sql_update_compras . '<br>';
			// 		// echo $sql_update_detalle_compras . '<br>'; exit;

			// 		$query_update1 = mysqli_query($con, $sql_update_compras);

			// 	if($query_update1 == 'true'){
			// 		$alert = '<p class="alert alert-success" role="alert">La Compra fue Actualizada. !!!</p>';
			// 	}else{
			// 		$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar la Compra. !!!</p>';
			// 	}

				
			// }

			$sql_update_compras = "UPDATE registro_compras 
			 		SET idproveedor= '$idproveedor',
			 			idarticulo= '$idarticulo',
			 			tipo_comprobante='$tipo_comprobante',
			 			serie_comprobante='$serie_comprobante',
			 			num_comprobante='$num_comprobante',
			 			existencia='$existencia',
			 			precio_compra='$precio_compra'
			 		WHERE idRegistroCompras= '$idRegistroCompras'
			 		";

			 		$query_update1 = '';

					$query_update1 = mysqli_query($con, $sql_update_compras);

				if($query_update1 == 'true'){
					$alert = '<p class="alert alert-success" role="alert">La Compra fue Actualizada. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar la Compra. !!!</p>';
				}


		}
	}

	// MOstrar datos del anterior form
	if(empty($_GET['id'])){
		header('location: listado_compras.php');
	}

	$idRegistroCompras = $_GET['id'];

	$query_compras = "SELECT rc.idproveedor, proveedor.nombre AS nombre_proveedor, rc.idarticulo, articulo.nombre AS nombre_articulo, rc.tipo_comprobante, rc.serie_comprobante, rc.num_comprobante, rc.existencia, rc.precio_compra, rc.idusuario, user.nombre AS nombre_usuario
		FROM registro_compras AS rc
		JOIN proveedor as proveedor ON rc.idproveedor = proveedor.idproveedor
		JOIN articulo as articulo ON rc.idarticulo = articulo.idarticulo
		JOIN usuario as user ON rc.idusuario = user.idusuario
				WHERE rc.idRegistroCompras = '$idRegistroCompras' AND rc.estatus = 1";

	$query = mysqli_query($con, $query_compras);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_compras.php');
	}else{

		$option_proveedor = '';
		$option_articulo = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// PROVEEDOR
			$idproveedor = $data['idproveedor'];
			$nombre_proveedor = $data['nombre_proveedor'];
			// ARTICULO
			$idarticulo = $data['idarticulo'];
			$nombre_articulo = $data['nombre_articulo'];
			//COMPRAS
			$tipo_comprobante = $data['tipo_comprobante'];
			$serie_comprobante = $data['serie_comprobante'];
			$num_comprobante = $data['num_comprobante'];
			$existencia = $data['existencia'];
			$precio_compra = $data['precio_compra'];
			// $precio_venta = $data['precio_venta'];
			//USUARIO
			$idusuario = $data['idusuario'];
			$nombre_usuario = $data['nombre_usuario'];

			$option_proveedor = '<option value="'.$idproveedor.'" select>'.$nombre_proveedor.'</option>';
			$option_articulo = '<option value="'.$idarticulo.'" select>'.$nombre_articulo.'</option>';

		}
	}


 ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Actualizar-Stock || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-users-cog"></i> Actualizar Stock</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idRegistroCompras" value="<?php echo $idRegistroCompras; ?>">
					</div>

					<!-- Proveedor -->
					<div class="row">
						<div class="col-sm-7">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
								</div>

								<?php 
									$query_proveedor= "SELECT * FROM proveedor";

									$query_proveedor= mysqli_query($con,$query_proveedor);
									$result_proveedor = mysqli_num_rows($query_proveedor);
								 ?>

								<select name="idproveedor" id="idproveedor" class="custom-select text-center NotItemOne">
									<?php 
										if($result_proveedor >0){

											echo $option_proveedor;

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

					<!-- Articulo -->

					<div class="row">
						<div class="col-sm-7">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Artículo</b></label>
								</div>

								<?php 
									$query_articulo= "SELECT * FROM articulo ";

									$query_articulo= mysqli_query($con,$query_articulo);
									$result_articulo = mysqli_num_rows($query_articulo);
								 ?>

								<select name="idarticulo" id="idarticulo" class="custom-select text-center NotItemOne">
									<?php 
										if($result_articulo >0){

											echo $option_articulo;

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

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Tipo Comprobante</b></span>
								</div>
								<input type="text" name="tipo_comprobante" id="tipo_comprobante" class="form-control text-center" value="<?php echo $tipo_comprobante; ?>" aria-label="Tipo Comprobante" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Serie Comprobante</b></span>
								</div>
								<input type="text" name="serie_comprobante" id="serie_comprobante" class="form-control text-center" placeholder="Serie Comprobante..." value="<?php echo $serie_comprobante; ?>" aria-label="Serie Comprobante" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Número Comprobante</b></span>
								</div>
								<input type="text" name="num_comprobante" id="num_comprobante" class="form-control text-center" placeholder="Número Comprobante..." aria-label="Numero Comprobante" value="<?php echo $num_comprobante; ?>" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Existencia</b></span>
								</div>
								<input type="text" name="existencia" id="existencia" class="form-control text-center" placeholder="Existencia..." value="<?php echo $existencia; ?>" aria-label="EXistencia" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Precio Compra</b></span>
								</div>
								<input type="text" name="precio_compra" id="precio_compra" class="form-control text-center" placeholder="Precio Compra..." value="<?php echo $precio_compra; ?>" aria-label="Precio Compra" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Precio Venta</b></span>
								</div>
								<input type="text" name="precio_venta" id="precio_venta" class="form-control text-center" placeholder="Precio Venta..." value="<?php  $precio_venta; ?>" aria-label="Precio Venta" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div> -->
					
					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Actualizar Compra" class="btn btn-primary">
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

<!-- <?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?> -->

