<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	
session_start();
require_once "./db_connection/connection.php";

	if(!empty($_POST)){

		$idcategoria =$_POST['idcategoria'];

		$rol_user = $_SESSION['rol'];

		if($rol_user != "Admin"){
			header('location: listado_categorias.php');
			exit;
		};

		$query_inhabilitar_categoria = "UPDATE categoria set estatus ='0'
		WHERE idcategoria='$idcategoria'";

		$query_inhabilitar_categoria = mysqli_query($con, $query_inhabilitar_categoria);

		if($query_inhabilitar_categoria){

			header('location: listado_categorias.php');
		}else{
			echo "ERROR: ERROR AL ELIMINAR CATEGORIAS";
		}

	}

	$idcategoria = $_REQUEST['id'];

	if(empty($_REQUEST['id']) || $rol_user == 'Admin'){
		header('location: listado_categorias.php');
	}else{	

		$idcategoria =$_REQUEST['id'];

		$query = "SELECT categoria.idcategoria, categoria.nombre, categoria.descripcion FROM categoria AS categoria
		WHERE categoria.idcategoria ='$idcategoria' AND categoria.estatus = 1";

		$query = mysqli_query($con, $query);
		$result_num_query = mysqli_num_rows($query);

		if($result_num_query > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nombre = $data['nombre'];
				$descripcion = $data['descripcion'];
			}
		}else{
			header('location: listado_categorias.php');
		}

	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>Confirmar Eliminar Categoria Producto || Sistema-Accesorios D-ASTU</title>
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
			<u><h3><i class="fas fa-user-times"></i> Eliminar Categoria</h3></u>
			<br>

			<h4 class="alert-heading">Estás Seguro de Eliminar, El siguiente Registro?</h4>
			<p><b>Categoria</b>: <span><?php echo $nombre; ?></span>  </p>
			<p><b>Descripcion</b>: <span><?php echo $descripcion; ?></span>  </p>
			
			<hr>
			<p class="mb-0"><b>AL DAR CLICK EN BOTÓN DE ACEPTAR SE ELIMINARÁ, LA CATEGORIA DE PRODUCTO. !!!</b></p>
		</div>

		<div class="data-delete-body">
			<form action="" method="POST">
				<input type="hidden" name="idcategoria" value="<?php echo $idcategoria; ?>">
				<input type="submit" value="ACEPTAR" class="btn btn-success btn_acept">

				<a href="listado_categorias.php" class=" btn btn-secondary btn_cancel">CANCELAR</a>
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