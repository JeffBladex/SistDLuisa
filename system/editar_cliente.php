<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['tipo_doc']) || empty($_POST['nombre']) || empty($_POST['direccion']) || empty($_POST['telefono'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idcliente = '';
			$tipo_documento = '';
			$numero_documento = '';
			$nombre_cliente = '';
			$direccion = '';
			$telefono = '';
			$email = '';

			$idcliente = $_POST['idcliente'];
			$tipo_documento = $_POST['tipo_doc'];
			$numero_documento = $_POST['num_doc'];
			$nombre_cliente = $_POST['nombre'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];
			$email = $_POST['email'];

			$query = "SELECT * FROM cliente
						WHERE (nombre = '$nombre_cliente' AND idcliente!= '$idcliente')
						OR (numero_documento= '$numero_documento' AND idcliente
						!= '$idcliente')";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert = '<p class="alert alert-danger" role="alert">El Cliente o Numero de Documento, ya han sido Registrados. !!!</p>';
			}else{
				
					$sql_update = "UPDATE cliente
					SET tipo_documento= '$tipo_documento',
						numero_documento='$numero_documento',
						nombre='$nombre_cliente',
						direccion='$direccion',
						telefono= '$telefono',
						email= '$email'
					WHERE idcliente= '$idcliente'
					";

					$query_update = mysqli_query($con, $sql_update);

				if($sql_update){
					$alert = '<p class="alert alert-success" role="alert">El Cliente fue Actualizado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar el Cliente. !!!</p>';
				}

				
			}


		}
	}

	// MOstrar datos del anterior form
	// Si no llega el Id
	if(empty($_GET['id'])){
		header('location: listado_clientes.php');
	}

	$idcliente = $_GET['id'];

	$query_clientes = "SELECT cliente.idcliente, cliente.tipo_documento, cliente.numero_documento, cliente.nombre AS nombre_cliente, cliente.direccion, cliente.telefono, cliente.email, user.idusuario
		FROM cliente as cliente JOIN usuario AS user on cliente.idusuario = user.idusuario
		WHERE cliente.idcliente = '$idcliente' AND cliente.estatus =1";

	$query = mysqli_query($con, $query_clientes);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_clientes.php');
	}else{

		$option = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// CLIENTE
			$idcliente = $data['idcliente'];
			$tipo_documento = $data['tipo_documento'];
			$numero_documento = $data['numero_documento'];
			$tipo_documento = $data['tipo_documento'];
			$nombre_cliente = $data['nombre_cliente'];
			$direccion = $data['direccion'];
			$telefono = $data['telefono'];
			$email = $data['email'];
		
			//USUARIO
			$idusuario = $data['idusuario'];

			if($tipo_documento == 'Cédula' || $tipo_documento == 'Ruc'){
				$option = '<option value="'.$tipo_documento.'" select>'.$tipo_documento.'</option>';
			}

			// if($idrol == 1 || $idrol == 2 || $idrol == 3 || $idrol == 4){
			// 	$option = '<option value="'.$idrol.'" select>'.$rol_get.'</option>';

			// }

		}
	}


 ?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Actualizar-Cliente || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-users-cog"></i> Actualizar Cliente</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Tipo Documento</b></label>
								</div>

								<select class="custom-select tipo_doc" name="tipo_doc" id="tipo_doc">
									<option value="<?php echo $tipo_documento; ?>"><?php echo $tipo_documento; ?></option>
									
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
								<input type="text" name="num_doc" id="num_doc" class="form-control text-center campo_No_Obligatorio" placeholder="Número Documento..." value="<?php echo $numero_documento ?>" aria-label="Número Documento" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Completo..." value="<?php echo $nombre_cliente ?>" aria-label="Nombre" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Dirección</b></span>
								</div>
								<input type="text" name="direccion" id="direccion" class="form-control text-center" placeholder="Dirección..."  value="<?php echo $direccion; ?>" aria-label="Dirección" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Teléfono</b></span>
								</div>
								<input type="text" name="telefono" id="telefono" class="form-control text-center" placeholder="Teléfono..." value="<?php echo $telefono ?>" aria-label="Teléfono" aria-describedby="inputGroup-sizing-default">
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
							<input type="submit" value="Actualizar Cliente" class="btn btn-primary">
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

