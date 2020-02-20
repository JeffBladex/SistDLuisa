<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

	session_start();
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['tipo_doc']) || empty($_POST['nombre']) || empty($_POST['direccion']) || empty($_POST['telefono'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$tipo_doc = '';
			$num_doc = '';
			$nombre = '';
			$direccion = '';
			$telefono = '';
			$email = '';

			$tipo_doc = $_POST['tipo_doc'];
			$num_doc = $_POST['num_doc'];
			$nombre = $_POST['nombre'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];

			$idusuario = $_SESSION['idusuario'];

			$query = "SELECT * FROM cliente WHERE numero_documento= '$num_doc' or nombre= '$nombre'";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0  && $result['numero_documento'] != ''){
				$alert = '<p class="alert alert-danger" role="alert">El Número de Documento o Cliente, ya han sido Registrados. !!!</p>';
			}else{
				$query = "INSERT INTO cliente(tipo_documento, numero_documento, nombre, direccion, telefono, email,idusuario)
					VALUES('$tipo_doc', '$num_doc', '$nombre', '$direccion', '$telefono', '$email','$idusuario')";

				$query_insert = mysqli_query($con, $query);

				if($query_insert){
					$alert = '<p class="alert alert-success" role="alert">El Cliente fue Correctamente Ingresado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Registrar el Cliente. !!!</p>';
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
		<title>Registro-Clientes|| Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-tie"></i> Registro Cliente</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Tipo Documento</b></label>
								</div>

								<select class="custom-select tipo_doc" name="tipo_doc" id="tipo_doc">
									<option selected>Seleccione...</option>
									<option value="<?php echo "Cédula"; ?>">Cédula</option>
									<option value="<?php echo "Ruc"; ?>">Ruc</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Número Documento</b></span>
								</div>
								<input type="text" name="num_doc" id="num_doc" class="form-control text-center campo_No_Obligatorio" placeholder="Número Documento..." aria-label="Número Documento" aria-describedby="inputGroup-sizing-default">
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
							<input type="submit" value="Registrar Ciente" class="btn btn-primary">
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