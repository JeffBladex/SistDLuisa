<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	
session_start();
require_once "./db_connection/connection.php";

	if(!empty($_POST)){

		$idproveedor =$_POST['idproveedor'];

		$rol_user = $_SESSION['rol'];

		if($rol_user != "Admin"){
			header('location: listado_proveedores.php');
			exit;
		};

		$query_inhabilitar_proveedor = "UPDATE proveedor set estatus ='0'
		WHERE idproveedor='$idproveedor'";

		$query_inhabilitar_proveedor = mysqli_query($con, $query_inhabilitar_proveedor);

		if($query_inhabilitar_proveedor){

			header('location: listado_proveedores.php');
		}else{
			echo "ERROR: ERROR AL ELIMINAR PROVEEDORES";
		}

	}

	$idproveedor = $_REQUEST['id'];

	if(empty($_REQUEST['id']) || $rol_user == 'Admin'){
		header('location: listado_proveedores.php');
	}else{	

		$idproveedor =$_REQUEST['id'];

		$query = "SELECT proveedor.cod_proveedor, proveedor.nombre AS nombre_proveedor
		FROM proveedor AS proveedor JOIN usuario AS user ON proveedor.idusuario = user.idusuario
		WHERE proveedor.idproveedor ='$idproveedor' AND proveedor.estatus =1";

		$query = mysqli_query($con, $query);
		$result_num_query = mysqli_num_rows($query);

		if($result_num_query > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$cod_proveedor = $data['cod_proveedor'];
				$nombre_proveedor = $data['nombre_proveedor'];
			}
		}else{
			header('location: listado_proveedores.php');
		}

	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Confirmar Eliminar Proveedor || Sistema-Accesorios D-ASTU</title>
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
			<u><h3><i class="fas fa-user-times"></i> Eliminar Proveedor</h3></u>
			<br>

			<h4 class="alert-heading">Estás Seguro de Eliminar, El siguiente Registro?</h4>
			<p><b>Código Proveedor</b>: <span><?php echo $cod_proveedor; ?></span>  </p>
			<p><b>Nombre Proveedor</b>: <span><?php echo $nombre_proveedor; ?></span>  </p>
			
			<hr>
			<p class="mb-0"><b>AL DAR CLICK EN BOTÓN DE ACEPTAR SE ELIMINARÁ, EL PROVEEDOR. !!!</b></p>
		</div>

		<div class="data-delete-body">
			<form action="" method="POST">
				<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
				<input type="submit" value="ACEPTAR" class="btn btn-success btn_acept">

				<a href="listado_proveedores.php" class=" btn btn-secondary btn_cancel">CANCELAR</a>
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