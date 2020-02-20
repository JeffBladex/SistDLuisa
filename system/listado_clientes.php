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
		<title>Listado-Clientes || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-friends"></i> Listado Clientes</h3>
				<hr>

				<a href="registro_cliente.php" class="btn btn-info">Crear Cliente</a>

				<br><br>

				<table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
					<thead>
						<tr class="table-primary">
							<th>ID</th>
							<th>Tipo Documento</th>
							<th>Número Documento</th>
							<th>Nombre</th>
							<th>Direccion</th>
							<th>Telefono</th>
							<th>Email</th>
							<th>Fecha AGG</th>
							<th>Usuario</th>

							<th>Acciones</th>
						
						</tr>
					</thead>

					<?php 
						$query = "SELECT cliente.idcliente, cliente.tipo_documento, cliente.numero_documento, cliente.nombre AS nombre_cliente, cliente.direccion, cliente.telefono, cliente.email, cliente.fecha_add, user.idrol, user.nombre AS nombre_usuario FROM cliente AS cliente JOIN usuario AS user ON cliente.idusuario = user.idusuario
						WHERE cliente.estatus = '1' ORDER BY user.nombre ASC ";

						$query = mysqli_query($con, $query);

						$result_list_clientes = mysqli_num_rows($query);
				
					?>
									<tbody>
										<?php 
											if($result_list_clientes > 0){
												while ($data = mysqli_fetch_array($query)) {

													if($data['numero_documento'] == '')
														$num_doc = "S/C";
													else
														$num_doc = $data['numero_documento'];

										 ?>

										<tr>
											<td><?php echo $data['idcliente']; ?></td>
											<td><?php echo $data['tipo_documento']; ?></td>
											<td><?php echo $num_doc; ?></td>
											<td><?php echo $data['nombre_cliente']; ?></td>
											<td><?php echo $data['direccion']; ?></td>
											<td><?php echo $data['telefono']; ?></td>
											<td><?php echo $data['email']; ?></td>
											<td><?php echo $data['fecha_add']; ?></td>
											<td><?php echo $data['nombre_usuario']; ?></td>

											<td>
											
												<?php 
													$idcliente = $data['idcliente'];
												 ?>

												<a href="editar_cliente.php?id=<?php echo $idcliente; ?>" class="link_edit btn btn-primary">EDITAR</a>
												 
												<a href="eliminar_confirm_cliente.php?id=<?php echo $idcliente; ?>" class="link_delete btn btn-danger">ELIMINAR</a>

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
