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
		<title>Listado-Proveedores || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-friends"></i> Listado Proveedores</h3>
				<hr>

				<a href="registro_proveedor.php" class="btn btn-info">Crear Proveedor</a>

				<br><br>

				<table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
					<thead>
						<tr class="table-primary">
							<th>ID</th>
							<th>Codigo Proveedor</th>
							<th>Nombre</th>
							<th>Telefono</th>
							<th>Dirección</th>
							<th>Email</th>
							<th>Fecha AGG</th>
							<th>Usuario</th>

							<th>Acciones</th>
						
						</tr>
					</thead>

					<?php 
						$query = "SELECT proveedor.idproveedor, proveedor.cod_proveedor, proveedor.nombre AS nombre_proveedor, proveedor.telefono, proveedor.direccion, proveedor.email, proveedor.fecha_add, user.nombre AS nombre_usuario
							FROM proveedor as proveedor join usuario AS user ON proveedor.idusuario = user.idusuario
							WHERE proveedor.estatus = 1 ORDER BY proveedor.nombre ASC;";

						$query = mysqli_query($con, $query);

						$result_list_proveedores = mysqli_num_rows($query);
				
					?>
									<tbody>
										<?php 
											$cod_provedor = '';

											if($result_list_proveedores > 0){
												while ($data = mysqli_fetch_array($query)) {

													if($data['cod_proveedor'] == '')
														$cod_provedor = "S/C";
													else
														$cod_provedor = $data['cod_proveedor'];

										 ?>

										<tr>
											<td><?php echo $data['idproveedor']; ?></td>
											<td><?php echo $cod_provedor; ?></td>
											<td><?php echo $data['nombre_proveedor']; ?></td>
											<td><?php echo $data['telefono']; ?></td>
											<td><?php echo $data['direccion']; ?></td>
											<td><?php echo $data['email']; ?></td>
											<td><?php echo $data['fecha_add']; ?></td>
											<td><?php echo $data['nombre_usuario']; ?></td>

											<td>
											
												<?php 
													$idproveedor = $data['idproveedor'];
												 ?>

												<a href="editar_proveedor.php?id=<?php echo $idproveedor; ?>" class="link_edit btn btn-primary">EDITAR</a>
												 
												<a href="eliminar_confirm_proveedor.php?id=<?php echo $idproveedor; ?>" class="link_delete btn btn-danger">ELIMINAR</a>

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
