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
		<title>Listado-Stock || Sistema-Accesorios D-ASTU</title>
		
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
				<h3><i class="fas fa-user-friends"></i> Listado Inventario Stock</h3>
				<hr>

				<div>
					<a href="registro_stock.php" class="btn btn-warning"><i class="far fa-caret-square-down"></i> <b>Registrar Stock</b></a>
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
								<th>Codigo Art</th>
								<th>Tipo Comprobante</th>
								<th>Serie Comprobante</th>
								<th>Número Comprobante</th>
								<th>Existencia</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Usuario</th>
								<th>Icono</th>
								<th>Agregar</th>

								<th>Acciones</th>
							</tr>
						</thead>

						<?php 
							$query = "SELECT compras.idcompras,compras.fecha_add, proveedor.nombre AS nombre_proveedor, articulo.nombre AS nombre_articulo, articulo.codigo, compras.tipo_comprobante, compras.serie_comprobante, compras.num_comprobante, compras.existencia, compras.precio_compra, compras.precio_venta, user.nombre AS nombre_usuario
								FROM compras as compras JOIN proveedor as proveedor ON compras.idproveedor = proveedor.idproveedor
								JOIN articulo as articulo ON compras.idarticulo = articulo.idarticulo
	                            JOIN usuario AS user ON compras.idusuario = user.idusuario
								WHERE compras.estatus = 1 ORDER BY compras.serie_comprobante ASC";

							$query = mysqli_query($con, $query);

							$result_list_compras = mysqli_num_rows($query);
					
						?>
										<tbody class="text-center">
											<?php 
							
												if($result_list_compras > 0){
													while ($data = mysqli_fetch_array($query)) {

											 ?>
											
											<tr class="row<?php echo $data['idcompras']; ?>">
												<td><?php echo $data['idcompras']; ?></td>
												<td class="cellFechaMod"><?php echo $data['fecha_add']; ?></td>
												<td><?php echo $data['nombre_proveedor']; ?></td>
												<td><?php echo $data['nombre_articulo']; ?></td>
												<td><?php echo $data['codigo']; ?></td>
												<td><?php echo $data['tipo_comprobante']; ?></td>
												<td><?php echo $data['serie_comprobante']; ?></td>
												<td><?php echo $data['num_comprobante']; ?></td>
												<td class="cellExistencia"><?php echo $data['existencia']; ?></td>
												<td><?php echo $data['precio_compra']; ?></td>
												<td class="cellPrecio_Venta"><?php echo $data['precio_venta']; ?></td>
												<td><?php echo $data['nombre_usuario']; ?></td>
												<td><img src="./img/carrito_compras.png" width="25" height="25"></td>

												<?php 
														$idcompras = $data['idcompras'];
												?>

												<td>
													<a class="link_add btn btn-success add_articulo_compras" articulo_compra="<?php echo $idcompras; ?>" data-toggle="modal" data-target="#myModal_Update_Compras_Stock" href="#"><i class="fas fa-plus"></i> AGREGAR</a>

													
												</td>

												<td>
													<a href="editar_stock.php?id=<?php echo $idcompras; ?>" class="link_edit btn btn-primary"><i class="fas fa-edit"></i> EDITAR</a>
													 
													<a class="link_delete btn btn-danger delete_articulo_compras" articulo_compra_delete="<?php echo $idcompras; ?>" data-toggle="modal" data-target="#myModal_Delete_Compras_Stock" href="#"><i class="fas fa-trash"></i> ELIMINAR</a>
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


		<section name="UpdateStock" id="UpdateStock">
			<div class="modal" id="myModal_Update_Compras_Stock" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Agregar Producto</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
			
							<form action="" method="POST" name="form_add_articulo_compra" id="form_add_articulo_compra" onsubmit="event.preventDefault(); sendDataArticulo();" accept-charset="UTF-8">
								<h1><i class="fas fa-cubes" style="font-size: 40pt;"></i>Agregar Producto</h1>
								<br>
								<h2 class="nombreArticulo" id="nombreArticulo"></h2>
								<br>
								<input type="number" class="form-control" name="cantidad_add" id="cantidad_add" placeholder="Cantidad del Producto" required>
								<br>
								<input type="text" class="form-control" name="precio_nuevo" id="precio_nuevo" placeholder="Precio del Producto" required>
								<br>
								<!-- Ocultos -->
								<input type="hidden" name="idcompras" id="idcompras" required>
								<br>
								<input type="hidden" name="action" value="add_articulo_compra" required>

						
							<!-- 	<div class="alert alertAddArticulo" role="alert">
  									<p></p>
								</div> -->

								<div class="alert alertAddArticulo"></div>

								<button type="submit" class="btn btn-success btn_new"><i class="fas fa-plus"> Agregar</i></button>

								<a href="#" type="button" data-dismiss="modal" class="btn btn-secondary closeModal" onclick="closeModal_Add_Articulo();"><i class="fas fa-ban"></i> Cerrar</a>
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

		<section name="DeleteStock" id="DeleteStock">
			<div class="modal" id="myModal_Delete_Compras_Stock" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Borrar Producto</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
			
							<form action="" method="POST" name="form_delete_articulo_compra" id="form_delete_articulo_compra" onsubmit="event.preventDefault(); DeleteArticulo();" accept-charset="UTF-8">
								<h1><i class="fas fa-trash" style="font-size: 40pt;"></i>Eliminar Producto</h1>
								<br>
								<h4 class="alert alert-heading" style="background-color: orange;">Estás Seguro de Eliminar, El siguiente Registro?</h4>
								<br>
								<span><b>Producto:</b> </span> <br>
								<h4 style="color:darkblue;" class="nombreArticulo_DeleteForm" id="nombreArticulo_DeleteForm"></h4>
								<br>
								<!-- Ocultos -->
								<input type="hidden" name="idcompras_DeleteForm" id="idcompras_DeleteForm" required>
								<br>
								<input type="hidden" name="action" value="delete_articulo_compra" required>

								<div class="alert alertDeleteArticulo"></div>

								<button type="submit" class="btn btn-danger btn_delete"><i class="fas fa-trash"> Eliminar</i></button>

								<a href="#" type="button" data-dismiss="modal" class="btn btn-secondary closeModal" onclick="closeModal_Delete_Articulo();"><i class="fas fa-ban"></i> Cerrar</a>

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
