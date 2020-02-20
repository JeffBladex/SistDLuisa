<?php 
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
require_once "./db_connection/connection.php";

	if(!empty($_POST)){

		$idusuario =$_POST['idusuario'];
		$query_tipo_rol_user = "SELECT rol.rol FROM usuario AS user JOIN rol AS rol on user.idrol = rol.idrol WHERE user.idusuario = '$idusuario'"; 
		$query_tipo_rol_user = mysqli_query($con, $query_tipo_rol_user);

		if($query_tipo_rol_user = "Admin"){
			header('location: listado_usuarios.php');
			exit;
		}

		// $query_delete_usuario  = "DELETE FROM usuario WHERE idusuario= '$idusuario'";
		// $query_delete_usuario = mysqli_query($con, $query_delete_usuario);

		$query_inhabilitar_usuario = "UPDATE usuario set estatus ='0'
		WHERE idusuario='$idusuario'";

		$query_inhabilitar_usuario = mysqli_query($con, $query_inhabilitar_usuario);

		if($query_inhabilitar_usuario){

			header('location: listado_usuarios.php');
		}else{
			echo "ERROR: ERROR AL ELIMINAR USUARIO";
		}

	}

	$idusuario = $_REQUEST['id'];

	$query_super_usuario = "SELECT ROL.rol FROM USUARIO AS USER JOIN ROL AS ROL ON USER.idrol = ROL.idrol
		WHERE idusuario= '$idusuario'";
	$query_super_usuario = mysqli_query($con, $query_super_usuario);

	$result = mysqli_fetch_array($query_super_usuario);
	$super_user = $result['rol'];
	

	if(empty($_REQUEST['id']) || $_REQUEST['id'] == '1'){
		header('location: listado_usuarios.php');
	}else{	

		$idusuario =$_REQUEST['id'];

		$query = "SELECT user.idusuario, user.nombre, user.usuario, rol.rol from usuario AS user JOIN rol AS rol ON user.idrol = rol.idrol WHERE idusuario = '$idusuario' AND user.estatus = 1";

		$query = mysqli_query($con, $query);
		$result_num_query = mysqli_num_rows($query);

		if($result_num_query > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nombre = $data['nombre'];
				$usuario = $data['usuario'];
				$rol = $data['rol'];


			}
		}else{
			header('location: listado_usuarios.php');
		}

	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Confirmar Eliminar Usuario || Sistema-Accesorios D-ASTU</title>
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
		<div class="container-delete-user">
			<div class="alert alert-danger data-delete-head" role="alert">
			<u><h3><i class="fas fa-user-times"></i> Eliminar Usuario</h3></u>
			<br>

			<h4 class="alert-heading">Estás Seguro de Eliminar, El siguiente Registro?</h4>
			<p><b>Nombre</b>: <span><?php echo $nombre; ?></span>  </p>
			<p><b>Usuario</b>: <span><?php echo $usuario; ?></span>  </p>
			<p><b>Rol</b>: <span><?php echo $rol; ?></span>  </p>
			<hr>
			<p class="mb-0"><b>AL DAR CLICK EN BOTÓN DE ACEPTAR SE ELIMINARÁ, EL USUARIO. !!!</b></p>
		</div>

		<div class="data-delete-body">
			<form action="" method="POST">
				<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
				<input type="submit" value="ACEPTAR" class="btn btn-success btn_acept">

				<a href="listado_usuarios.php" class=" btn btn-secondary btn_cancel">CANCELAR</a>
			</form>
			
		</div>
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