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
		<title>Listado-Compras || Sistema-Accesorios D-ASTU</title>
		
	</head>
	<body>
		<!-- Scripts -->
		<?php include_once 'scripts.php'; ?>
		<!-- Header -->
		<?php include_once 'header.php'; ?>

		<?php include_once 'dataTable.php'; ?>

		<!-- JavaScript Functions -->
		<script type="text/javascript" src="js/functions.js"></script>

		<!-- FontAwesome Cdn -->
		<script src="https://kit.fontawesome.com/6a36ea283a.js" crossorigin="anonymous"></script>

		<!-- Fontawesome Local -->
		<script type="text/javascript" src="js/fontAwesome-6a36ea283a.js"></script>

		<?php include_once 'modal.php'; ?>

		<section id="container">
			<u><h2><i class="fas fa-car"></i> Bienvenido al Sistema</h2></u></i>
			<br>
			
			<div class="form_register">
				<h3><i class="fas fa-user-friends"></i> Listado Compras</h3>
				<hr>

				<div>
					<a href="registro_compras.php" class="btn btn-warning"><i class="far fa-caret-square-down"></i> <b>Registrar Compra</b></a>
				</div>

				<br><br>

				<div>
						<table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
						<thead>
							<tr class="table-primary">
								<th>No.Fact</th>
								<th>Fecha/Hora</th>
								<th>Proveedor</th>
								<th>Artículo</th>
								<th>Tipo Comprobante</th>
								<th>Serie Comprobante</th>
								<th>Número Comprobante</th>
								<th>Existencia</th>
								<th>Precio Compra</th>
								<th>Usuario</th>
								<th>Icono</th>

								<th>Acciones</th>
							</tr>
						</thead>

						<?php 
							$query = "SELECT rc.idRegistroCompras,rc.fecha_add, proveedor.nombre AS nombre_proveedor, articulo.nombre AS nombre_articulo, rc.tipo_comprobante, rc.serie_comprobante, rc.num_comprobante, rc.existencia, rc.precio_compra, user.nombre AS nombre_usuario
								FROM registro_compras as rc JOIN proveedor as proveedor ON rc.idproveedor = proveedor.idproveedor
								JOIN articulo as articulo ON rc.idarticulo = articulo.idarticulo
	                            JOIN usuario AS user ON rc.idusuario = user.idusuario
								WHERE rc.estatus = 1 ORDER BY rc.fecha_add ASC";

							$query = mysqli_query($con, $query);

							$result_list_compras = mysqli_num_rows($query);
					
						?>
										<tbody class="text-center">
											<?php 
							
												if($result_list_compras > 0){
													while ($data = mysqli_fetch_array($query)) {

											 ?>
											
											<tr class="row<?php echo $data['idRegistroCompras']; ?>">
												<td><?php echo $data['idRegistroCompras']; ?></td>
												<td><?php echo $data['fecha_add']; ?></td>
												<td><?php echo $data['nombre_proveedor']; ?></td>
												<td><?php echo $data['nombre_articulo']; ?></td>
												<td><?php echo $data['tipo_comprobante']; ?></td>
												<td><?php echo $data['serie_comprobante']; ?></td>
												<td><?php echo $data['num_comprobante']; ?></td>
												<td class="cellExistencia"><?php echo $data['existencia']; ?></td>
												<td>$<?php echo $data['precio_compra']; ?></td>

												<td><?php echo $data['nombre_usuario']; ?></td>
												<td><img src="./img/box_icon.png" width="25" height="25"></td>

												<?php 
														$idRegistroCompras = $data['idRegistroCompras'];
												?>

												<td>
													<div class="btn_accion">
														<a href="editar_compra.php?id=<?php echo $idRegistroCompras; ?>" class="link_edit btn btn-primary"><i class="fas fa-edit"></i> EDITAR</a>
													 
														<a class="link_delete btn btn-danger delete_compras" compra_delete="<?php echo $idRegistroCompras; ?>" data-toggle="modal" data-target="#myModal_Delete_Compras" href="#"><i class="fas fa-trash"></i> ELIMINAR</a>
													</div>
												</td> 
											</tr>

											<?php 
									}
							}

						 ?>

						 </tbody>

						
					</table>
				</div>

				
			</div>
		</section>

		<section name="DeleteCompra" id="DeleteCompra">
			<div class="modal" id="myModal_Delete_Compras" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Borrar Compra</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
			
							<form action="" method="POST" name="form_delete_compra" id="form_delete_compra" onsubmit="event.preventDefault(); DeleteCompra();" accept-charset="UTF-8">
								<h1><i class="fas fa-trash" style="font-size: 40pt;"></i>Eliminar Compra</h1>
								<br>
								<h4 class="alert alert-heading" style="background-color: orange;">Estás Seguro de Eliminar, La Siguiente Compra?</h4>
								<br>
								<span><b>Compra:</b> </span> <br>
								<h4>No.Fact</h4>
								<h4 style="color:darkblue;" class="NoCompraDeleteForm" id="NoCompraDeleteForm"></h4>
								<br>
								<h4>Articulo</h4>
								<h4 style="color:darkblue;" class="NombreCompra_DeleteForm" id="NombreCompra_DeleteForm"></h4>
								<br>
								<!-- Ocultos -->
								<input type="hidden" name="idRegistroCompras_DeleteForm" id="idRegistroCompras_DeleteForm" required>
								<br>
								<input type="hidden" name="action" value="delete_compra" required>

								<div class="alert alertDeleteCompra"></div>

								<button type="submit" class="btn btn-danger btn_delete"><i class="fas fa-trash"> Eliminar</i></button>

								<a href="#" type="button" data-dismiss="modal" class="btn btn-secondary closeModal" onclick="closeModal_Delete_Compra();"><i class="fas fa-ban"></i> Cerrar</a>

							</form>

						</div>
						<!-- <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div> -->
					</div>
				</div>
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
