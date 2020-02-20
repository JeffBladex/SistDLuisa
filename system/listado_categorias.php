<?php
// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE); 
	require_once "./db_connection/connection.php";

 ?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
		<?php include_once 'logoSite.php'; ?>
		<title>Listado-Categoria Productos || Sistema-Accesorios D-ASTU</title>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>

		<?php include_once 'dataTable.php'; ?>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>

		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u></i>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-user-friends"></i> Listado Categoria Productos</h3>
				<hr>

				<a href="registro_categoria.php" class="btn btn-info">Crear Categoria</a>

				<br><br>

				<table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
					<thead>
						<tr class="table-primary">
							<th>ID</th>
							<th>Nombre</th>
							<th>Descripción</th>
							<th>Fecha AGG</th>

							<th>Acciones</th>
						
						</tr>
					</thead>

					<?php 
						$query = "SELECT categoria.idcategoria, categoria.nombre, categoria.descripcion, categoria.fecha_add
							FROM categoria as categoria
							WHERE categoria.estatus = 1 ORDER BY categoria.nombre ASC;";

						$query = mysqli_query($con, $query);

						$result_list_categorias = mysqli_num_rows($query);
				
					?>
									<tbody>
										<?php 
											$descripcion_categoria = '';

											if($result_list_categorias > 0){
												while ($data = mysqli_fetch_array($query)) {

													if($data['descripcion'] == '')
														$descripcion_categoria = "S/D-CATEGORIA";
													else
														$descripcion_categoria = $data['descripcion'];

										 ?>

										<tr>
											<td><?php echo $data['idcategoria']; ?></td>
											<td><?php echo $data['nombre']; ?></td>
											<td><?php echo $descripcion_categoria; ?></td>
											<td><?php echo $data['fecha_add']; ?></td>

											<td>
											
												<?php 
													$idcategoria = $data['idcategoria'];
												 ?>

												<a href="editar_categoria.php?id=<?php echo $idcategoria; ?>" class="link_edit btn btn-primary">EDITAR</a>
												 
												<a href="eliminar_confirm_categoria.php?id=<?php echo $idcategoria; ?>" class="link_delete btn btn-danger">ELIMINAR</a>

											</td> 
										</tr>
									
								<?php 
								}
						}

					 ?>

					 </tbody>

					
				</table>

				
			</div>
		</section>
		<!-- Footer -->
		<?php include_once 'footer.php'; ?>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
    	$('#example').DataTable({
    		"language": {
      			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    		}
    	});
	} );
</script>

<?php 
	//Cerrando la Conexion
	mysqli_close($con);
 ?>
