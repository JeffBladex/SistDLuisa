<?php 
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);

	session_start();
	require_once "./db_connection/connection.php";

	if(!empty($_POST)){
		$alert = '';

		if(empty($_POST['idcategoria']) || empty($_POST['codigo']) || empty($_POST['nombre']) || empty($_POST['descripcion'])){
			$alert = '<p class="alert alert-warning" role="alert">Todos los Campos Son Obligatorios. !!!</p>';
			
		}else{

			$idcategoria = '';
			$codigo = '';
			$nombre = '';
			$descripcion = '';
			// $foto = '';

			$idcategoria = $_POST['idcategoria'];
			$codigo = $_POST['codigo'];
			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];

		/*	$foto = $_FILES['foto'];
			$nombre_foto = $foto['name'];
			$tipo_foto = $foto['type'];
			$url_temp = $foto['tmp_name'];

			$imgProducto = 'img_producto.png';*/

			$idusuario = $_SESSION['idusuario'];

			// if($nombre_foto != ''){
			// 	$destino_foto = 'img/uploads/';
			// 	$img_nombre_random = 'img_'.md5(date('d-m-Y H:m:s'));
			// 	$imgProducto = $img_nombre_random.'.jpg';
			// 	$src = $destino_foto.$imgProducto;

			// }

			$query = "SELECT * FROM articulo WHERE codigo = '$codigo' or nombre= '$nombre'";

			$query = mysqli_query($con, $query);
			$result = mysqli_fetch_array($query);

			if($result > 0  && $result['codigo'] != '' && $result['nombre']){
				$alert = '<p class="alert alert-danger" role="alert">El Código de Artículo o Artículo, ya han sido Registrados. !!!</p>';
			}else{

				$query = "INSERT INTO articulo(idcategoria, codigo, nombre, descripcion, estatus)
				VALUES('$idcategoria', '$codigo', '$nombre', '$descripcion', 1)";

				$query_insert = mysqli_query($con, $query);

				if($query_insert){

					$alert = '<p class="alert alert-success" role="alert">El Artículo fue Correctamente Ingresado. !!!</p>';
				}else{
					$alert = '<p class="alert alert-danger" role="alert">Error Al Registrar el Artículo. !!!</p>';
				}

				
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
		<title>Registro-Artículo|| Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-tie"></i> Registro Artículo</h3>
				<hr>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01"><b>Categoria Artículo</b></label>
								</div>

								<select class="custom-select tipo_doc" name="idcategoria" id="idcategoria">
									<option selected>Seleccione...</option>
										<?php 
											$query_categorias = "SELECT categoria.idcategoria, categoria.nombre FROM categoria AS categoria WHERE categoria.estatus = 1 ORDER BY categoria.nombre ASC ";
											$query = mysqli_query($con, $query_categorias);
											$rows =  mysqli_num_rows($query);

											if($rows > 0){
												while ($data = mysqli_fetch_array($query)) {
													# code...
										?>
											<option value="<?php echo $data['idcategoria']; ?>"><?php echo $data['nombre']; ?></option>

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
								<input type="text" name="codigo" id="codigo" class="form-control text-center" placeholder="Código Producto..." aria-label="Código Producto" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Nombre</b></span>
								</div>
								<input type="text" name="nombre" id="nombre" class="form-control text-center" placeholder="Nombre Producto..." aria-label="Nombre Producto" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><b>Descripción</b></span>
								</div>
								<input type="text" name="descripcion" id="descripcion" class="form-control text-center" placeholder="Descripción..." aria-label="Descripción" aria-describedby="inputGroup-sizing-default">
							</div>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-sm-4">
							<label for="foto"><b>Foto:</b></label>
						</div>
					</div> -->
<!-- 
					<div class="row">
						<div class="col-sm-6">
							<input type="file" name="foto" id="foto">
						</div>
					</div>					 -->

					<br>
					<div class="row">
						<div class="col-sm-6">
							<input type="submit" value="Registrar Artículo" class="btn btn-primary">
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


<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>