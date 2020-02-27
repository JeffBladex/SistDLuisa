<?php
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';
		if(empty($_POST['categorias']) || empty($_POST['codigo']) || empty($_POST['nombre'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idcategoria = '';
			$codigo = '';
			$nombre = '';
			$descripcion = '';
			// $foto = '';

			$idcategoria = $_POST['categorias'];
			$codigo = $_POST['codigo'];
			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];

			$idusuario = $_SESSION['idusuario'];

			$idarticulo = $_POST['idarticulo'];

			
			$query = "SELECT * FROM articulo
						WHERE (nombre = '$nombre' AND idarticulo!= '$idarticulo')
						OR (codigo = '$codigo' AND idarticulo!= '$idarticulo')
						";


			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert = '<p class="alert alert-danger" role="alert">El Artículo o Código de Artículo, ya han sido Registrados. !!!</p>';
			}else{
				
					$sql_update = "UPDATE articulo
					SET idcategoria= '$idcategoria',
						codigo='$codigo',
						nombre='$nombre',
						descripcion='$descripcion'
					WHERE idarticulo= '$idarticulo'
					";

					$query_update = mysqli_query($con, $sql_update);

				if($sql_update){
					$alert = '<p class="alert alert-success" role="alert">El Artículo fue Actualizado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Actualizar el Artículo. !!!</p>';
				}

				
			}


		}
	}

	// MOstrar datos del anterior form
	// Si no llega el Id
	if(empty($_GET['id'])){
		header('location: listado_articulos.php');
	}

	$idarticulo = $_GET['id'];

	$query_articulo = "SELECT articulo.idcategoria, articulo.codigo, articulo.nombre AS nombre_articulo, articulo.descripcion, articulo.estatus,
		cat.idcategoria, cat.nombre AS nombre_categoria
		FROM articulo AS articulo
		JOIN categoria AS cat ON articulo.idcategoria = cat.idcategoria
		WHERE articulo.idarticulo = '$idarticulo' AND articulo.estatus = 1";

	$query = mysqli_query($con, $query_articulo);
	$result_num_query = mysqli_num_rows($query);

	if($result_num_query  == 0){
		header('location: listado_articulos.php');
	}else{

		$option = '';

		while ($data = mysqli_fetch_array($query)) {
			# code...
			// CATEGORIA
			$idcategoria = $data['idcategoria'];
			$nombre_categoria = $data['nombre_categoria'];
			// ARTICULO
			$codigo = $data['codigo'];
			$nombre_articulo = $data['nombre_articulo'];
			$descripcion = $data['descripcion'];

			$option = '<option value="'.$idcategoria.'" select>'.$nombre_categoria.'</option>';
		}
	}


 ?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Actualizar-Artículo || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-users-cog"></i> Actualizar Artículo</h3>
				<hr>
				<form action="" method="POST">
					<div class="row">
						<input type="hidden" name="idarticulo" value="<?php echo $idarticulo; ?>">
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Categoria Artículo</b></label>
								</div>


								<?php 
									$query_categorias= "SELECT cat.idcategoria, cat.nombre FROM categoria as cat";

									$query_categorias= mysqli_query($con,$query_categorias);
									$result_categorias = mysqli_num_rows($query_categorias);
								 ?>

								<select name="categorias" id="categorias" class="custom-select text-center NotItemOne">
									<?php
										echo $option;

										if($result_categorias >0){
											while ($categoria = mysqli_fetch_array($query_categorias)) {
									 ?>
									 			
									 			<option value="<?php echo $categoria['idcategoria'] ?>">
									 				<?php 
									 					echo $categoria['nombre'];
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

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Código</b></span>
								</div>
								<input type="text" name="codigo" id="codigo" class="form-control text-center" placeholder="Código Producto..." value="<?php echo $codigo; ?>" aria-label="Código Producto" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Producto..." value="<?php echo $nombre_articulo; ?>" aria-label="Nombre Producto" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Descripción</b></span>
								</div>
								<input type="text" name="descripcion" id="descripcion" class="form-control text-center campo_No_Obligatorio" placeholder="Descripción..." value="<?php echo $descripcion; ?>" aria-label="Descripción" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Actualizar Articulo" class="btn btn-primary">
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

