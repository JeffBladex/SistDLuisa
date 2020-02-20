<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

	session_start();
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$cod_prov = '';
			$nombre = '';
			$telefono = '';
			$direccion = '';
			$email = '';

			$cod_prov = $_POST['cod_prov'];
			$nombre = $_POST['nombre'];
			$telefono = $_POST['telefono'];
			$direccion = $_POST['direccion'];
			$email = $_POST['email'];

			$idusuario = $_SESSION['idusuario'];

			$query = "SELECT * FROM proveedor WHERE cod_proveedor = '$cod_prov' or nombre= '$nombre'";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0  && $result['cod_proveedor'] != ''){
				$alert = '<p class="alert alert-danger" role="alert">El Código de Proveedor o Proveedor, ya han sido Registrados. !!!</p>';
			}else{
				$query = "INSERT INTO proveedor(cod_proveedor, nombre, telefono, direccion, email, idusuario)
				values('$cod_prov','$nombre','$telefono', '$direccion','$email', '$idusuario')";

				$query_insert = mysqli_query($con, $query);

				if($query_insert){
					$alert = '<p class="alert alert-success" role="alert">El Proveedor fue Correctamente Ingresado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Registrar el Proveedor. !!!</p>';
				}

				
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
		<title>Registro-Proveedor|| Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-tie"></i> Registro Proveedor</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Código Proveedor</b></span>
								</div>
								<input type="text" name="cod_prov" id="cod_prov" class="form-control text-center campo_No_Obligatorio" placeholder="Código Proveedor..." aria-label="Número Documento" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Completo..." aria-label="Nombre" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Teléfono</b></span>
								</div>
								<input type="text" name="telefono" id="telefono" class="form-control text-center" placeholder="Teléfono..." aria-label="Teléfono" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Dirección</b></span>
								</div>
								<input type="text" name="direccion" id="direccion" class="form-control text-center" placeholder="Dirección..." aria-label="Dirección" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Correo Electrónico</b></span>
								</div>
								<input type="email" name="email" id="email" class="form-control text-center campo_No_Obligatorio" placeholder="Correo Electrónico..." aria-label="Email" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Registrar Proveedor" class="btn btn-primary">
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