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
		<title>Listado-Usuarios || Sistema-Accesorios D-ASTU</title>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>

		<?php include_once 'dataTable.php'; ?>
		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-user-friends"></i> Listado Usuarios</h3>
				<hr>

				<a href="registro_usuario.php" class="btn btn-info">Crear Usuario</a>

				<br><br>

				<table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
					<thead>
						<tr class="table-primary">
							<th>ID</th>
							<th>Nombre</th>
							<th>Usuario</th>
							<th>Email</th>
							<th>Password</th>
							<th>Rol</th>
							<th>Acciones</th>
						
						</tr>
					</thead>

					<?php 
						$query = "SELECT user.idusuario, user.nombre, user.usuario, user.email, user.password, rol.idrol, rol.rol FROM usuario AS user JOIN rol AS rol ON user.idrol = rol.idrol
							WHERE user.estatus ='1' ORDER BY user.nombre ASC ";

						$query = mysqli_query($con, $query);

						$result_list_usuarios = mysqli_num_rows($query);
				
					?>
									<tbody>
										<?php 
											if($result_list_usuarios > 0){
												while ($data = mysqli_fetch_array($query)) {

										 ?>

										<tr>
											<td><?php echo $data['idusuario']; ?></td>
											<td><?php echo $data['nombre']; ?></td>
											<td><?php echo $data['usuario']; ?></td>
											<td><?php echo $data['email']; ?></td>
											<td><?php echo $data['password']; ?></td>
											<td><?php echo $data['rol']; ?></td>
											<td>
												<?php 
													$idusuario = $data['idusuario'];
												 ?>

												<a href="editar_usuario.php?id=<?php echo $idusuario; ?>" class="link_edit btn btn-primary">EDITAR</a>

												<?php

													if($data['idrol'] == '1'){
												?>		
												
												<?php 
													}else{

												?>
												 
												<a href="eliminar_confirm_usuario.php?id=<?php echo $idusuario; ?>" class="link_delete btn btn-danger">ELIMINAR</a>

												<?php 
													}
												 ?>
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
