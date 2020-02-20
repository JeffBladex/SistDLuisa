<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['nombre'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$nombre = '';
			$descripcion = '';
			
			$idcategoria = '';

			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];

			$idcategoria = $_POST['idcategoria'];

			$query = "SELECT * FROM categoria
						WHERE (nombre = '$nombre' AND idcategoria!= '$idcategoria')
						";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert = '<p class="alert alert-danger" role="alert">La Categoria de Producto, ya ha sido Registrados. !!!</p>';
			}else{
				
					$sql_update = "UPDATE categoria
					SET nombre= '$nombre',
						descripcion='$descripcion'
					WHERE idcategoria= '$idcategoria'
					";

					$query_update = mysqli_query($con, $sql_update);

				if($sql_update){
					$alert = '<p class="alert alert-success" role="alert">La Categoria de Producto fue Actualizada. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar la Categoria. !!!</p>';
				}

				
			}


		}
	}

	// MOstrar datos del anterior form
	// Si no llega el Id
	if(empty($_GET['id'])){
		header('location: listado_categorias.php');
	}

	$idcategoria = $_GET['id'];

	$query_categoria = "SELECT categoria.idcategoria, categoria.nombre, categoria.descripcion
		FROM categoria as categoria 
		WHERE categoria.idcategoria = '$idcategoria' AND categoria.estatus = 1";

	$query = mysqli_query($con, $query_categoria);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_cateorias.php');
	}else{

		$option = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// CATEGORIA
			$idcategoria = $data['idcategoria'];
			$nombre = $data['nombre'];
			$descripcion = $data['descripcion'];

		}
	}


 ?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Actualizar-Categoria Productos ||Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-users-cog"></i> Actualizar Categoria Productos</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idcategoria" value="<?php echo $idcategoria; ?>">
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" value="<?php echo $nombre; ?>" placeholder="Nombre Categoría..." aria-label="Nombre Categoria" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Descripción</b></span>
								</div>
								<input type="text" name="descripcion" id="descripcion" class="form-control text-center campo_No_Obligatorio" placeholder="Descripción Categoría..." value="<?php echo $descripcion; ?>" aria-label="Nombre" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Actualizar Categoría" class="btn btn-primary">
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

