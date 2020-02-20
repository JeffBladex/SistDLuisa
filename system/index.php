<?php
require_once "./db_connection/connection.php";

	$alert = '';
	session_start();

	if(!empty($_SESSION['active'])){
		header('location: home.php');
	}

	if(!empty($_POST)){
		if(empty($_POST['usuario']) || empty($_POST['password'])){
			$alert = 'Ingrese Usuario y Password...';
		}else{
		
			$user = $_POST["usuario"];
			$email = $_POST["usuario"];
			$password = $_POST["password"];

			$query = "SELECT * FROM usuario AS user JOIN rol AS rol
			ON user.idrol = rol.idrol
			WHERE (usuario= '$user' or email='$email') and 
				password= '$password' LIMIT 1";

			$query = mysqli_query($con,$query);
			$result_query = mysqli_num_rows($query);

			if($result_query > 0){
				$data = mysqli_fetch_array($query);
				// print_r($data);

				// session_start();
				$_SESSION['active'] = 'true';

				$_SESSION['idusuario'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['usuario'] = $data['usuario'];
				$_SESSION['email'] = $data['email'];
				$_SESSION['password'] = $data['password'];
				$_SESSION['idrol'] = $data['idrol'];
				$_SESSION['rol'] = $data['rol'];

				header('location: home.php');
				// session_destroy();


			}else{
				$alert = 'El usuario o Password, son incorrectos';
				session_destroy();				
			}
			
		}

	}


 ?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<?php include_once 'logoSite.php'; ?>
	<title>LOgin || Sistema-Accesorios D-ASTU</title>

	<?php 

		// Css
		include_once 'scripts.php';

		// Alert-Hello
		// include_once 'alert-hello.php';

	 ?>
</head>
<body>
	<section id="container-loginForm">
		<form action="" method="POST">
			<h2>Iniciar Sección</h2>
			<img src="./img/lock-security.ico" alt="Login" width="200" height="200">
			<br>

			<div class="row">
				<div class="col-sm-6">
					<input type="text" class="form-control" name="usuario" placeholder="Usuario o Email">
			
				</div>

				<div class="col-sm-6">
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
			</div>
			
			<br>

			<div class="row">
				<div class="col-sm-4">
					<input type="submit" class="btn btn-success border border-primary " value="Ingresar">
				</div>
			</div>

			<div class="alert-login">
				<p><?php echo isset($alert)? $alert : ''; ?></p>
			</div>
		</form>
	</section>

	<section id="container-Tools">
		<img src="./img/slogan-clean.png" alt="Slogan Luisa's Car Accesorios" >

		<br><br>
		<img src="./img/accesorios_vehiculo_varios.png" alt="Accesorios Vehiculo Varios" >

	</section>

	
</body>
</html>

<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>