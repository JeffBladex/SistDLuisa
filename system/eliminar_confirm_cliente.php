<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	
session_start();
require_once "./db_connection/connection.php";

	if(!empty($_POST)){

		$idcliente =$_POST['idcliente'];
		// $query_tipo_rol_user = "SELECT rol.rol FROM usuario AS user JOIN rol AS rol on user.idrol = rol.idrol WHERE user.idusuario = '$idusuario'"; 
		// $query_tipo_rol_user = mysqli_query($con, $query_tipo_rol_user);

		$rol_user = $_SESSION['rol'];

		if($rol_user != "Admin"){
			header('location: listado_clientes.php');
			exit;
		}

		// $query_delete_usuario  = "DELETE FROM usuario WHERE idusuario= '$idusuario'";
		// $query_delete_usuario = mysqli_query($con, $query_delete_usuario);

		$query_inhabilitar_cliente = "UPDATE cliente set estatus ='0'
		WHERE idcliente='$idcliente'";

		$query_inhabilitar_cliente = mysqli_query($con, $query_inhabilitar_cliente);

		if($query_inhabilitar_cliente){

			header('location: listado_clientes.php');
		}else{
			echo "ERROR: ERROR AL ELIMINAR CLIENTES";
		}

	}

	$idcliente = $_REQUEST['id'];

	// $query_super_usuario = "SELECT ROL.rol FROM USUARIO AS USER JOIN ROL AS ROL ON USER.idrol = ROL.idrol
	// 	WHERE idusuario= '$idusuario'";
	// $query_super_usuario = mysqli_query($con, $query_super_usuario);

	// $result = mysqli_fetch_array($query_super_usuario);
	// $super_user = $result['rol'];
	// echo $super_user;

	if(empty($_REQUEST['id']) || $rol_user == 'Admin'){
		header('location: listado_clientes.php');
	}else{	

		$idcliente =$_REQUEST['id'];

		$query = "SELECT cliente.tipo_documento, cliente.numero_documento, cliente.nombre AS nombre_cliente
			FROM cliente as cliente JOIN usuario AS user on cliente.idusuario = user.idusuario
			WHERE cliente.idcliente = '$idcliente' AND cliente.estatus =1";

		$query = mysqli_query($con, $query);
		$result_num_query = mysqli_num_rows($query);

		if($result_num_query > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$tipo_documento = $data['tipo_documento'];
				$numero_documento = $data['numero_documento'];
				$nombre_cliente = $data['nombre_cliente'];
			}
		}else{
			header('location: listado_clientes.php');
		}

	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Confirmar Eliminar Cliente || Sistema-Accesorios D-ASTU</title>
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
			<u><h3><i class="fas fa-user-times"></i> Eliminar Cliente</h3></u>
			<br>

			<h4 class="alert-heading">Estás Seguro de Eliminar, El siguiente Registro?</h4>
			<p><b>Tipo Documento</b>: <span><?php echo $tipo_documento; ?></span>  </p>
			<p><b>Número Documento</b>: <span><?php echo $numero_documento; ?></span>  </p>
			<p><b>Nombre</b>: <span><?php echo $nombre_cliente; ?></span>  </p>
			<hr>
			<p class="mb-0"><b>AL DAR CLICK EN BOTÓN DE ACEPTAR SE ELIMINARÁ, EL CLIENTE. !!!</b></p>
		</div>

		<div class="data-delete-body">
			<form action="" method="POST">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<input type="submit" value="ACEPTAR" class="btn btn-success btn_acept">

				<a href="listado_clientes.php" class=" btn btn-secondary btn_cancel">CANCELAR</a>
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