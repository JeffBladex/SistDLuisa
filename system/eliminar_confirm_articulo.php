<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	
session_start();
require_once "./db_connection/connection.php";

	if(!empty($_POST)){

		$idarticulo =$_POST['idarticulo'];

		$rol_user = $_SESSION['rol'];

		if($rol_user != "Admin"){
			header('location: listado_articulos.php');
			exit;
		};

		$query_inhabilitar_articulo = "UPDATE articulo set estatus ='0'
		WHERE idarticulo='$idarticulo'";

		$query_inhabilitar_articulo = mysqli_query($con, $query_inhabilitar_articulo);

		if($query_inhabilitar_categoria){

			header('location: listado_articulos.php');
		}else{
			echo "ERROR: ERROR AL ELIMINAR ARTICULOS";
		}

	}

	$idarticulo = $_REQUEST['id'];

	if(empty($_REQUEST['id']) || $rol_user == 'Admin'){
		header('location: listado_articulos.php');
	}else{	

		$idarticulo =$_REQUEST['id'];

		$query = "SELECT art.idarticulo, art.codigo, art.nombre, art.descripcion FROM articulo AS art
		WHERE art.idarticulo ='$idarticulo' AND art.estatus = 1";

		$query = mysqli_query($con, $query);
		$result_num_query = mysqli_num_rows($query);

		if($result_num_query > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$codigo = $data['codigo'];
				$nombre = $data['nombre'];
				$descripcion = $data['descripcion'];
			}
		}else{
			header('location: listado_articulos.php');
		}

	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Confirmar Eliminar Producto || Sistema-Accesorios D-ASTU</title>
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
			<u><h3><i class="fas fa-user-times"></i> Eliminar Artículo</h3></u>
			<br>

			<h4 class="alert-heading">Estás Seguro de Eliminar, El siguiente Registro?</h4>
			<p><b>Código</b>: <span><?php echo $codigo; ?></span>  </p>
			<p><b>Artículo</b>: <span><?php echo $nombre; ?></span>  </p>
			<p><b>Descripción</b>: <span><?php echo $descripcion; ?></span>  </p>
			
			<hr>
			<p class="mb-0"><b>AL DAR CLICK EN BOTÓN DE ACEPTAR SE ELIMINARÁ, EL PRODUCTO. !!!</b></p>
		</div>

		<div class="data-delete-body">
			<form action="" method="POST">
				<input type="hidden" name="idarticulo" value="<?php echo $idarticulo; ?>">
				<input type="submit" value="ACEPTAR" class="btn btn-success btn_acept">

				<a href="listado_articulos.php" class=" btn btn-secondary btn_cancel">CANCELAR</a>
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