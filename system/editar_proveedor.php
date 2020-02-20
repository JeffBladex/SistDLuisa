<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$cod_proveedor = '';
			$nombre_proveedor = '';
			$telefono = '';
			$direccion = '';
			$email = '';

			$idproveedor = '';

			$cod_proveedor = $_POST['cod_prov'];
			$nombre_proveedor = $_POST['nombre'];
			$telefono = $_POST['telefono'];
			$direccion = $_POST['direccion'];
			$email = $_POST['email'];

			$idproveedor = $_POST['idproveedor'];

			$query = "SELECT * FROM proveedor
						WHERE (nombre = '$nombre_proveedor' AND idproveedor!= '$idproveedor')
						OR (cod_proveedor= '$cod_proveedor' AND idproveedor
						!= '$idproveedor')";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert = '<p class="alert alert-danger" role="alert">El Proveedor o Codigo de Proveedor, ya han sido Registrados. !!!</p>';
			}else{
				
					$sql_update = "UPDATE proveedor
					SET cod_proveedor= '$cod_proveedor',
						nombre='$nombre_proveedor',
						telefono='$telefono',
						direccion='$direccion',
						email= '$email'
					WHERE idproveedor= '$idproveedor'
					";

					$query_update = mysqli_query($con, $sql_update);

				if($sql_update){
					$alert = '<p class="alert alert-success" role="alert">El Proveedor fue Actualizado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar el Proveedor. !!!</p>';
				}

				
			}


		}
	}

	// MOstrar datos del anterior form
	// Si no llega el Id
	if(empty($_GET['id'])){
		header('location: listado_proveedores.php');
	}

	$idproveedor = $_GET['id'];

	$query_provedor = "SELECT proveedor.idproveedor, proveedor.cod_proveedor, proveedor.nombre AS nombre_proveedor, proveedor.telefono, proveedor.direccion, proveedor.email,
		proveedor.fecha_add, user.idusuario, user.nombre AS nombre_usuario
		FROM proveedor as proveedor join usuario AS user on proveedor.idusuario = user.idusuario
		WHERE proveedor.idproveedor = '$idproveedor' AND proveedor.estatus = 1";

	$query = mysqli_query($con, $query_provedor);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_proveedores.php');
	}else{

		$option = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// CLIENTE
			$idproveedor = $data['idproveedor'];
			$cod_proveedor = $data['cod_proveedor'];
			$nombre_proveedor = $data['nombre_proveedor'];
			$telefono = $data['telefono'];
			$direccion = $data['direccion'];
			$email = $data['email'];

			//USUARIO
			$idusuario = $data['idusuario'];

		}
	}


 ?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Actualizar-Proveedor || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-users-cog"></i> Actualizar Proveedor</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Código Proveedor</b></span>
								</div>
								<input type="text" name="cod_prov" id="cod_prov" class="form-control text-center campo_No_Obligatorio" placeholder="Código Proveedor..." value="<?php echo $cod_proveedor; ?>" aria-label="Número Documento" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Completo..." value="<?php echo $nombre_proveedor; ?>" aria-label="Nombre" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Teléfono</b></span>
								</div>
								<input type="text" name="telefono" id="telefono" class="form-control text-center" placeholder="Teléfono..." value="<?php echo $telefono; ?>" aria-label="Teléfono" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Dirección</b></span>
								</div>
								<input type="text" name="direccion" id="direccion" class="form-control text-center" placeholder="Dirección..." value="<?php echo $direccion; ?>" aria-label="Dirección" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Correo Electrónico</b></span>
								</div>
								<input type="email" name="email" id="email" class="form-control text-center campo_No_Obligatorio" placeholder="Correo Electrónico..." value="<?php echo $email; ?>" aria-label="Email" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>
						

					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Actualizar Proveedor" class="btn btn-primary">
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

