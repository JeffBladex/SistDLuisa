<?php 
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['usuario']) || empty($_POST['rol'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idusuario = $_POST['idusuario'];
			$nombre = $_POST['nombre'];
			$email = $_POST['email'];
			$usuario = $_POST['usuario'];
			// $password = $_POST['password'];
			$rol = $_POST['rol'];

			$query = "SELECT * FROM usuario
						WHERE (usuario = '$usuario' AND idusuario!= '$idusuario')
						OR (email= '$email' AND idusuario!= '$idusuario')";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert = '<p class="alert alert-danger" role="alert">El Usuario o Correo, ya han sido Registrados. !!!</p>';
			}else{
				if(empty($_POST['password'])){

					$usuario_check = "SELECT * FROM usuario
					WHERE usuario='$usuario'";

					$sql_update = "UPDATE usuario
					SET nombre='$nombre',
						email='$email',
						usuario='$usuario',
						idrol='$rol'
					WHERE idusuario= '$idusuario'
					";

					$query_update = mysqli_query($con, $sql_update);


				}else{
					$sql_update = "UPDATE usuario
					SET nombre='$nombre',
						email='$email',
						usuario='$usuario',
						password= '$password',
						idrol='$rol'
					WHERE idusuario= '$idusuario'
					";

					$query_update = mysqli_query($con, $sql_update);
				}

				if($sql_update){
					$alert = '<p class="alert alert-success" role="alert">El Usuario fue Actualizado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar el Usuario. !!!</p>';
				}

				
			}


		}
	}

	// MOstrar datos del anterior form

	// Si llega el ID
	if(empty($_GET['id'])){
		header('location: listado_usuarios.php');
	}

	$idusuario = $_GET['id'];

	$query_usuarios = "SELECT user.idusuario, user.nombre, user.usuario, user.email, user.password,
						rol.idrol, rol.rol
						FROM usuario AS user JOIN rol AS rol ON user.idrol = rol.idrol
						WHERE user.idusuario = '$idusuario' AND user.estatus = 1";

	$query = mysqli_query($con, $query_usuarios);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_usuarios.php');
	}else{

		$option = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// USUARIO
			$idusuario = $data['idusuario'];
			$nombre = $data['nombre'];
			$usuario = $data['usuario'];
			$email = $data['email'];
			$password = $data['password'];
			//ROL - USUARIO
			$idrol = $data['idrol'];
			$rol_get = $data['rol'];

			if($idrol == 1 || $idrol == 2 || $idrol == 3 || $idrol == 4){
				$option = '<option value="'.$idrol.'" select>'.$rol_get.'</option>';

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
		<title>Actualizar-Usuario || Sistema-Accesorios D-ASTU</title>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>
		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-users-cog"></i> Actualizar Usuario</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
					</div>

					<div class="row">
						<div class="col-sm-7">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Completo..." value="<?php echo $nombre; ?>" aria-label="Nombre" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Correo Electrónico</b></span>
								</div>
								<input type="email" name="email" id="email" class="form-control text-center" placeholder="Correo Electrónico..." value="<?php echo $email; ?>" aria-label="Email" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Usuario</b></span>
								</div>
								<input type="text" name="usuario" id="usuario" class="form-control text-center" placeholder="Usuario..." value="<?php echo $usuario; ?>" aria-label="Usuario" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Password</b></span>
								</div>
								<input type="text" name="password" id="password" class="form-control text-center" placeholder="Password..." aria-label="Password" aria-describedby="inputGroup-sizing-default" disabled>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Tipo Usuario</b></label>
								</div>

								<?php 
									$query_rol= "SELECT * FROM rol";

									$query_rol= mysqli_query($con,$query_rol);
									$result_rol = mysqli_num_rows($query_rol);
								 ?>

								<select name="rol" id="rol" class="custom-select text-center NotItemOne">
									<?php
										echo $option;

										if($result_rol >0){
											while ($rol = mysqli_fetch_array($query_rol)) {
									 ?>
									 			
									 			<option value="<?php echo $rol['idrol'] ?>">
									 				<?php 
									 					echo $rol['rol'];
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
						<div class="col-sm-6">
							<input type="submit" value="Actualizar Usuario" class="btn btn-primary">
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

<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>