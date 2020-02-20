<?php 
	require_once "./db_connection/connection.php";
	session_start();

	// print_r($_POST);
	// exit;

	if (!empty($_POST)) {
		if ($_POST['action'] == 'InfoArticuloToUpdate') {
			# code...
	
			$idcompras = $_POST['articulo'];

			$query_select = "SELECT compras.idcompras, articulo.nombre
			FROM compras AS compras JOIN articulo AS articulo ON compras.idarticulo = articulo.idarticulo
			WHERE idcompras= '$idcompras' AND compras.estatus = 1";

			$query = mysqli_query($con, $query_select);

			$result_num_query = mysqli_num_rows($query);

			// print_r($result_num_query); exit;

			if ($result_num_query > 0) {
				# code...
				$data = mysqli_fetch_array($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;

			}

			echo 'error';
			exit;


		}

		if ($_POST['action'] == 'add_articulo_compra') {
			# code...
			// echo 'Agregar Producto';

			if (!empty($_POST['cantidad_add']) || !empty($_POST['precio_nuevo'])  ||  !empty($_POST['idcompras'])) {
				$cantidad_add = $_POST['cantidad_add'];
				$precio_nuevo = $_POST['precio_nuevo'];
				$idcompras = $_POST['idcompras'];

				$idusuario = $_SESSION['idusuario'];
				$rol_usuario = $_SESSION['rol'];

				// Mediante Procedure

			$query_stock_anterior = "SELECT * FROM compras WHERE idcompras = '$idcompras'";
			$query_stock_anterior = mysqli_query($con, $query_stock_anterior);

			$data = mysqli_fetch_array($query_stock_anterior);

			$idarticulo = $data['idarticulo'];
			$precio_compra = $data['precio_compra'];

			$query_insert = "INSERT INTO detalle_compra(idcompras, idarticulo, cantidad, precio_compra, precio_venta, idusuario)
			VALUES('$idcompras', '$idarticulo', '$cantidad_add', '$precio_compra', '$precio_nuevo', '$idusuario')";
			$query_insert = mysqli_query($con, $query_insert);

			if ($query_insert) {
				# code...
			
				// Ejecutar Procedimiento ALmacenado
				$query_upd = mysqli_query($con, "CALL actualizar_precio_compra('$cantidad_add', '$precio_nuevo', '$idcompras')");

				$result_art = mysqli_num_rows($query_upd);

				if ($result_art > 0) {
					# code...

					$data = mysqli_fetch_array($query_upd);

					$data['idcompras'] = $idcompras;

					echo json_encode($data, JSON_UNESCAPED_UNICODE);
					exit;

				}else{
					echo 'error';
				}
			}else{
				echo 'error';
			}


			}else{
				echo 'error';
			}
		}

		if ($_POST['action'] == 'InfoArticuloToDelete') {
			# code...
	
			$idcompras = $_POST['articulo'];

			$query_select = "SELECT compras.idcompras, articulo.nombre
			FROM compras AS compras JOIN articulo AS articulo ON compras.idarticulo = articulo.idarticulo
			WHERE idcompras= '$idcompras' AND compras.estatus = 1";

			$query = mysqli_query($con, $query_select);

			$result_num_query = mysqli_num_rows($query);

			// print_r($result_num_query); exit;

			if ($result_num_query > 0) {
				# code...
				$data = mysqli_fetch_array($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;

			}

			echo 'error';
			exit;


		}

		if (($_POST['action'] == 'delete_articulo_compra')) {
			# code...

			if (empty($_POST['idcompras_DeleteForm'])) {
				# code...
				echo 'error';
			}else{

				$idcompras = $_POST['idcompras_DeleteForm'];

				$query_inhabilitar_compra = "UPDATE compras SET estatus= 0 WHERE idcompras= '$idcompras'";
				$query_delete = mysqli_query($con, $query_inhabilitar_compra);

				if ($query_delete) {
					# code...
					echo 'borrada compra';
				}else{
					echo 'error';
				}
			}

			echo 'error';
		}

		if ($_POST['action'] == 'InfoCompraToDelete') {
			# code...
	
			$idRegistroCompras = $_POST['compra'];

			$query_select = "SELECT rc.idRegistroCompras, articulo.nombre
			FROM registro_compras AS rc JOIN articulo AS articulo ON rc.idarticulo = articulo.idarticulo
			WHERE idRegistroCompras= '$idRegistroCompras' AND rc.estatus = 1";

			$query = mysqli_query($con, $query_select);

			$result_num_query = mysqli_num_rows($query);

			// print_r($result_num_query); exit;

			if ($result_num_query > 0) {
				# code...
				$data = mysqli_fetch_array($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;

			}

			echo 'error';
			exit;


		}

		if (($_POST['action'] == 'delete_compra')) {
			# code...

			if (empty($_POST['idRegistroCompras_DeleteForm'])) {
				# code...
				echo 'error';
			}else{

				$idRegistroCompras = $_POST['idRegistroCompras_DeleteForm'];

				$query_inhabilitar_compra = "UPDATE registro_compras SET estatus= 0 WHERE idRegistroCompras= '$idRegistroCompras'";
				$query_delete = mysqli_query($con, $query_inhabilitar_compra);

				if ($query_delete) {
					# code...
					echo 'borrada compra';
				}else{
					echo 'error';
				}
			}

			echo 'error';
		}

		if (($_POST['action'] == 'searchCliente')) {
			# code...
			// print_r($_POST);
			// echo "Buscar Cliente";

			if (!empty($_POST['cliente'])) {
				# code...
				$num_identificacion_cliente = $_POST['cliente'];

				$query = "SELECT * FROM cliente WHERE numero_documento LIKE '$num_identificacion_cliente' AND estatus=1"; 
				$query = mysqli_query($con, $query);

				$result = mysqli_num_rows($query);

				$data = '';
				if ($result > 0) {
					# code...
					$data = mysqli_fetch_array($query);
				}else{
					$data=0;
				}

				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}

			exit;

		}

		if (($_POST['action'] == 'addCliente')) {
			# code...
			// print_r($_POST);
			// exit;
			$tipo_documento = "";
			$numero_documento = "";
			$nom_cliente = "";
			$tel_cliente = "";
			$dir_cliente = "";

			if ($_POST['tipo_documento'] == '1') {
				# code...
				$tipo_documento = "Cédula";
			}else if($_POST['tipo_documento'] == '2'){
				$tipo_documento = "Ruc";
			}else{
				$tipo_documento = "";
			}
			
			$numero_documento = $_POST['num_identificacion_cliente'];
			$nom_cliente = $_POST['nom_cliente'];
			$tel_cliente = $_POST['tel_cliente'];
			$dir_cliente = $_POST['dir_cliente'];

			$idusuario = $_SESSION['idusuario'];

			$query_insert = "INSERT INTO cliente(tipo_documento, numero_documento, nombre, direccion, telefono, idusuario)
							VALUES('$tipo_documento', '$numero_documento', '$nom_cliente', '$dir_cliente', '$tel_cliente', '$idusuario')";
			$query_insert= mysqli_query($con, $query_insert);

			if($query_insert){
				$idcliente = mysqli_insert_id($con);
				$msg = $idcliente;
			}else{
				$msg= 'error';
			}

			echo $msg;
			exit;
		}

		if ($_POST['action'] == 'infoArticulo') {
			# code...
			$codigo_articulo = $_POST['articulo'];

			$query_select = "SELECT compras.idcompras, articulo.idarticulo, articulo.nombre AS nombre_articulo, articulo.codigo AS codigo_articulo, sum(compras.existencia) AS existencia, min(compras.precio_venta) AS precio_venta_min, max(compras.precio_venta) AS precio_venta_max
			FROM compras AS compras 
			JOIN articulo AS articulo ON compras.idarticulo = articulo.idarticulo
            WHERE articulo.codigo = '$codigo_articulo' AND compras.estatus = 1";

			$query = mysqli_query($con, $query_select);
			$data = mysqli_fetch_assoc($query);

			if(!is_null($data['idcompras'])){
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;
			}
	
			echo 'error';
			exit;

		}

		if ($_POST['action'] == 'infoArticulo_x_Nombre') {
			# code...

			$nombre_articulo = $_POST['articulo'];

			$query_select = "SELECT compras.idcompras, articulo.idarticulo, articulo.nombre AS nombre_articulo, articulo.codigo AS codigo_articulo, sum(compras.existencia) AS existencia, min(compras.precio_venta) AS precio_venta_min, max(compras.precio_venta) AS precio_venta_max
			FROM compras AS compras 
			JOIN articulo AS articulo ON compras.idarticulo = articulo.idarticulo
            WHERE articulo.nombre = '$nombre_articulo' AND compras.estatus = 1";

			$query = mysqli_query($con, $query_select);
			$data = mysqli_fetch_assoc($query);

			if(!is_null($data['idcompras'])){
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;
			}

			echo 'error';
			exit;
		}

		if ($_POST['action'] == 'getUltimoValordeSecuencia_Venta') {
			# code...
			// Ultima secuencia
			$ultima_secuencia = $_POST['secuencia'];

			$query_ult_secuencia = "SELECT MAX(secuencia) AS secuencia FROM detalle_ventas_temp";
			$query_ult_secuencia = mysqli_query($con, $query_ult_secuencia);
			$ult_secuencia_num_rows = mysqli_num_rows($query_ult_secuencia);

			if($ult_secuencia_num_rows > 0){
				$data = mysqli_fetch_array($query_ult_secuencia);
				$secuencia = 0;
				$secuencia = $data['secuencia'];

				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;

			}else{
				$secuencia = 0;
			}

			echo 'error';
			exit;
		}

		// Extrae Datos del detalle ventas temp
		if (($_POST['action'] == 'searchForDetalle')) {
			# code...
			// print_r($_POST);
			// exit;
			if (empty($_POST['secuencia'])) {
				# code...
				echo 'error';
			}else{
				$token_usuario = md5($_SESSION['idusuario']);
				$secuencia = $_POST['secuencia'];

				$query_ventas_tmp = "SELECT * FROM detalle_ventas_temp as ventas_tmp
						WHERE secuencia = '$secuencia'";
				$query_ventas_tmp = mysqli_query($con, $query_ventas_tmp);

				$result_ventas_tmp = mysqli_num_rows($query_ventas_tmp);

				$query_iva = "SELECT iva FROM configuracion";
				$query_iva = mysqli_query($con, $query_iva);
				$result_iva = mysqli_num_rows($query_iva);

				$detalleTabla_ventas = '';
				$sub_total = 0;
				$iva = 0;
				$total = 0;
				$arrayData = array();

				if ($result_ventas_tmp > 0) {
					# code...
					if ($result_iva > 0) {
						# code...
						$info_iva = mysqli_fetch_array($query_iva);
						$iva = $info_iva['iva'];

					}

					while ($dataVentasTemp = mysqli_fetch_array($query_ventas_tmp)) {
					# code...
					$precioTotal = round($dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'], 2);
					$sub_total = round($sub_total + $precioTotal, 2);
					$total= round($total+ $precioTotal, 2);

					$detalleTabla_ventas .= '
						<tr>
							<td>'.$dataVentasTemp['codigo_articulo'].'</td>
							<td colspan="2">'.$dataVentasTemp['descripcion'].'</td>
							<td class="text-center">'.$dataVentasTemp['cantidad'].'</td>
							<th class="text-right"></th>
							<th class="text-right"></th>
							<td class="text-right">'.$dataVentasTemp['precio_venta'].'</td>
							<td class="text-right">'.$dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'].'</td>
							<td class="">
								<a href="#" class="link_delete" onclick="event.preventDefault(); delete_articulo_detalle('.$dataVentasTemp['correlativo'].');"><i class="fas fa-trash-alt"></i></a>
							</td>
						</tr>

					';
					}

					$porc_iva  = ($iva/100);
					$porc_iva  = round($porc_iva,2);

					$subtot = $sub_total;
					$subtot  = round($subtot,2);

					$impuesto = $subtot*$porc_iva;
					$impuesto  = round($impuesto,2);

					$tot_fin = $subtot + $impuesto;
					$tot_fin  = round($tot_fin,2);

					$detalleTotales = '
						<tr>
							<td colspan="7" class="text-right"><b>SUBTOTAL $</b></td>
							<td class="text-right">'.$subtot.'</td>
						</tr>
						<tr>
							<td colspan="7" class="text-right"><b>IVA('.$iva.') $</b></td>
							<td class="text-right">'.$impuesto.'</td>
						</tr>
						<tr>
							<td colspan="7" class="text-right"><b>TOTAL $</b></td>
							<td class="text-right">'.$tot_fin.'</td>
						</tr>

					';

					$arrayData['detalle'] = $detalleTabla_ventas;
					$arrayData['totales'] = $detalleTotales;

					echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
					exit;

				}else{
					echo 'error';
					exit;
				}

			}

		}

		if (($_POST['action'] == 'addArticuloDetalle')) {
			# code...
			// print_r($_POST);
			// exit;
			if (empty($_POST['codigo_articulo']) || empty($_POST['cantidad']) || empty($_POST['descripcion']) || empty($_POST['precio_pagar']) || empty($_POST['precio_total'])) {
				# code...
				echo 'error';
			}else{
				$codigo_articulo = $_POST['codigo_articulo'];
				$cantidad = $_POST['cantidad'];
				$descripcion = $_POST['descripcion'];
				$precio_pagar = $_POST['precio_pagar'];
				$precio_total = $_POST['precio_total'];



				$token_usuario = md5($_SESSION['idusuario']);

				$secuencia = $_POST['secuencia'];
				
				$query_iva = "SELECT iva FROM configuracion";
				$query_iva = mysqli_query($con, $query_iva);
				$result_iva = mysqli_num_rows($query_iva);

				// Obteniendo idcompras - idarticulo - codigo_articulo
				$query_getDataArticulo = "SELECT compras.idcompras, articulo.idarticulo, articulo.codigo
				FROM compras AS compras 
				JOIN articulo AS articulo ON compras.idarticulo =  articulo.idarticulo
				WHERE articulo.codigo = '$codigo_articulo' and articulo.nombre = '$descripcion'
				AND compras.estatus = 1";
				$query_getDataArticulo = mysqli_query($con, $query_getDataArticulo);
				$result_getDataArticulo = mysqli_num_rows($query_getDataArticulo);

				if ($result_getDataArticulo > 0) {
					# code...
					while ($data_Articulo = mysqli_fetch_array($query_getDataArticulo)) {
					# code...
						$idcompras = $data_Articulo['idcompras'];
						$idarticulo = $data_Articulo['idarticulo'];
						$codigo_articulo = $data_Articulo['codigo'];
					}
				}else{
						$idcompras = 0;
						$idarticulo = 0;
						$codigo_articulo = 0;
				}

				$query_detalle_ventas_temp = mysqli_query($con, "CALL add_detalle_ventas_temp('$idcompras', '$idarticulo', '$codigo_articulo', '$cantidad', '$precio_pagar', '$token_usuario', '$secuencia')");

				$detalleTabla_ventas = '';
				$sub_total = 0;
				$iva = 0;
				$total = 0;
				$arrayData = array();

					# code...
					if ($result_iva > 0) {
						# code...
						$info_iva = mysqli_fetch_array($query_iva);
						$iva = $info_iva['iva'];
					}

					$query_ventas_tmp = "SELECT * FROM detalle_ventas_temp where token_user='$token_usuario' and secuencia= '$secuencia' ORDER BY descripcion asc";
					$query_ventas_tmp = mysqli_query($con, $query_ventas_tmp);
					$ventas_tmp_num_rows = mysqli_num_rows($query_ventas_tmp);

				if($ventas_tmp_num_rows > 0){

				while ($dataVentasTemp = mysqli_fetch_array($query_ventas_tmp)) {
					# code...
					$precioTotal = round($dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'], 2);
					$sub_total = round($sub_total + $precioTotal, 2);
					$total= round($total+ $precioTotal, 2);

					$detalleTabla_ventas .= '
						<tr>
							<td>'.$dataVentasTemp['codigo_articulo'].'</td>
							<td colspan="3">'.$dataVentasTemp['descripcion'].'</td>
							<td class="text-center">'.$dataVentasTemp['cantidad'].'</td>
							
							<th class="text-right"></th>
							<td class="text-right">'.$dataVentasTemp['precio_venta'].'</td>
							<td class="text-right">'.$dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'].'</td>
							
						</tr>

					';

					// <td class="">
					// 			<a href="#" class="link_delete" onclick="event.preventDefault(); delete_articulo_detalle('.$dataVentasTemp['correlativo'].');"><i class="fas fa-trash-alt"></i></a>
					// 		</td>
				}

				$porc_iva  = ($iva/100);
				$porc_iva  = round($porc_iva,2);

				$subtot = $sub_total;
				$subtot  = round($subtot,2);

				$impuesto = $subtot*$porc_iva;
				$impuesto  = round($impuesto,2);

				$tot_fin = $subtot + $impuesto;
				$tot_fin  = round($tot_fin,2);

				$detalleTotales = '
					<tr>
						<td colspan="7" class="text-right"><b>SUBTOTAL $</b></td>
						<td class="text-right">'.$subtot.'</td>
					</tr>
					<tr>
						<td colspan="7" class="text-right"><b>IVA('.$iva.') $</b></td>
						<td class="text-right">'.$impuesto.'</td>
					</tr>
					<tr>
						<td colspan="7" class="text-right"><b>TOTAL $</b></td>
						<td class="text-right">'.$tot_fin.'</td>
					</tr>

				';

				$arrayData['detalle'] = $detalleTabla_ventas;
				$arrayData['totales'] = $detalleTotales;

				echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
				exit;

			}else{
				echo 'error';
				exit;
			}

		}

	}

	if (($_POST['action'] == 'deleteArticuloDetalle')) {
		if (empty($_POST['idArticuloDetalle'])) {
			# code...
			echo 'error';
		}else{
		$idventa_temp = $_POST['idArticuloDetalle'];
		$token_usuario = md5($_SESSION['idusuario']);
		$secuencia = $_POST['secuencia'];

		$query_iva = "SELECT iva FROM configuracion";
		$query_iva = mysqli_query($con, $query_iva);
		$result_iva = mysqli_num_rows($query_iva);

		$query_detalle_ventas_temp = mysqli_query($con, "CALL delete_detalle_temp('$idventa_temp', '$token_usuario')");

		$detalleTabla_ventas = '';
		$sub_total = 0;
		$iva = 0;
		$total = 0;
		$arrayData = array();

		# code...
		if ($result_iva > 0) {
			# code...
			$info_iva = mysqli_fetch_array($query_iva);
			$iva = $info_iva['iva'];
		}

		$query_ventas_tmp = "SELECT * FROM detalle_ventas_temp where token_user='$token_usuario' and secuencia= '$secuencia'";
		$query_ventas_tmp = mysqli_query($con, $query_ventas_tmp);
		$ventas_tmp_num_rows = mysqli_num_rows($query_ventas_tmp);

		if($ventas_tmp_num_rows > 0){

				while ($dataVentasTemp = mysqli_fetch_array($query_ventas_tmp)) {
					# code...
					$precioTotal = round($dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'], 2);
					$sub_total = round($sub_total + $precioTotal, 2);
					$total= round($total+ $precioTotal, 2);

					$detalleTabla_ventas .= '
						<tr>
							<td>'.$dataVentasTemp['codigo_articulo'].'</td>
							<td colspan="3">'.$dataVentasTemp['descripcion'].'</td>
							<td class="text-center">'.$dataVentasTemp['cantidad'].'</td>
							
							<th class="text-right"></th>
							<td class="text-right">'.$dataVentasTemp['precio_venta'].'</td>
							<td class="text-right">'.$dataVentasTemp['cantidad'] * $dataVentasTemp['precio_venta'].'</td>
							
						</tr>

					';
					
					// <td class="">
					// 			<a href="#" class="link_delete" onclick="event.preventDefault(); delete_articulo_detalle('.$dataVentasTemp['iddetalle_ventas_temp'].');"><i class="fas fa-trash-alt"></i></a>
					// 		</td>

				}

				$porc_iva  = ($iva/100);
				$porc_iva  = round($porc_iva,2);

				$subtot = $sub_total;
				$subtot  = round($subtot,2);

				$impuesto = $subtot*$porc_iva;
				$impuesto  = round($impuesto,2);

				$tot_fin = $subtot + $impuesto;
				$tot_fin  = round($tot_fin,2);

				$detalleTotales = '
					<tr>
						<td colspan="7" class="text-right"><b>SUBTOTAL $</b></td>
						<td class="text-right">'.$subtot.'</td>
					</tr>
					<tr>
						<td colspan="7" class="text-right"><b>IVA('.$iva.') $</b></td>
						<td class="text-right">'.$impuesto.'</td>
					</tr>
					<tr>
						<td colspan="7" class="text-right"><b>TOTAL $</b></td>
						<td class="text-right">'.$tot_fin.'</td>
					</tr>

				';

				$arrayData['detalle'] = $detalleTabla_ventas;
				$arrayData['totales'] = $detalleTotales;

				echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
				exit;

			}else{
				echo 'error';
				exit;
			}

		}

		exit;
	}

	if (($_POST['action'] == 'anularVenta')) {
		$token_usuario = md5($_SESSION['idusuario']);
		$secuencia_actual = $_POST['secuencia'];

		$query_del = "DELETE FROM detalle_ventas_temp WHERE secuencia= '$secuencia_actual'";
		// echo $query_del;
		// exit;
		$query_del = mysqli_query($con, $query_del);
		if ($query_del) {
			# code...
			echo 'ok';
		}else{
			echo 'error';
		}

		exit;

	}

	// Procesar Venta
	if (($_POST['action'] == 'procesarVenta')) {
		// print_r($_POST); exit;
		if (empty($_POST['codigo_cliente'])){
			# code...
			$codigo_cliente = 1;
		}else{
			$codigo_cliente = $_POST['codigo_cliente'];
		}

		$token_usuario = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

		$token_secuencia = $_POST['secuencia'];

		if ($token_usuario != '' || $idusuario != '') {
			# code...
			$query_procesar_venta = mysqli_query($con, "CALL procesar_venta($idusuario,$codigo_cliente,'$token_secuencia')");
			$result_procesar_venta = mysqli_num_rows($query_procesar_venta);

			if ($result_procesar_venta > 0) {
				# code...
				$data = mysqli_fetch_array($query_procesar_venta);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}else{
				echo 'error';
			}

		}else{
			echo 'error';
		}
	}

	// Generar_DescargarPdf
	if (($_POST['action'] == 'Generar_Descargar_Pdf')) {
		// print_r($_POST); exit;
		$token_usuario = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

		// $token_secuencia = $_POST['secuencia'];

		if ($token_usuario != '' || $idusuario != '') {
			# code...
			$query_ult_factura = "SELECT factura.nrofactura, factura.idcliente FROM factura AS factura 
				WHERE factura.nrofactura = (SELECT MAX(f.nrofactura) FROM factura AS f)";
			$query_ult_factura = mysqli_query($con, $query_ult_factura);
			$result_ult_factura = mysqli_num_rows($query_ult_factura);

			if ($result_ult_factura > 0) {
				# code...
				$data = mysqli_fetch_array($query_ult_factura);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}else{
				echo 'error';
			}

		}else{
			echo 'error';
		}
	}

	// Generar_DescargarExcel
	// if (($_POST['action'] == 'Generar_Descargar_Excel')) {
	// 	// print_r($_POST); exit;
	// 	$token_usuario = md5($_SESSION['idusuario']);
	// 	$idusuario = $_SESSION['idusuario'];

	// 	// $token_secuencia = $_POST['secuencia'];

	// 	if ($token_usuario != '' || $idusuario != '') {
	// 		# code...
	// 		$query_ult_factura = "SELECT factura.nrofactura, factura.idcliente FROM factura AS factura 
	// 			WHERE factura.nrofactura = (SELECT MAX(f.nrofactura) FROM factura AS f)";
	// 		$query_ult_factura = mysqli_query($con, $query_ult_factura);
	// 		$result_ult_factura = mysqli_num_rows($query_ult_factura);

	// 		if ($result_ult_factura > 0) {
	// 			# code...
	// 			$data = mysqli_fetch_array($query_ult_factura);
	// 			echo json_encode($data, JSON_UNESCAPED_UNICODE);
	// 		}else{
	// 			echo 'error';
	// 		}

	// 	}else{
	// 		echo 'error';
	// 	}
	// }

	// Generar_DescargarWord
	if (($_POST['action'] == 'Generar_Descargar_Word')) {
		// print_r($_POST); exit;
		$token_usuario = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

		// $token_secuencia = $_POST['secuencia'];

		if ($token_usuario != '' || $idusuario != '') {
			# code...
			$query_ult_factura = "SELECT factura.nrofactura, factura.idcliente FROM factura AS factura 
				WHERE factura.nrofactura = (SELECT MAX(f.nrofactura) FROM factura AS f)";
			$query_ult_factura = mysqli_query($con, $query_ult_factura);
			$result_ult_factura = mysqli_num_rows($query_ult_factura);

			if ($result_ult_factura > 0) {
				# code...
				$data = mysqli_fetch_array($query_ult_factura);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}else{
				echo 'error';
			}

		}else{
			echo 'error';
		}
	}

	// Anular Factura-Info
	if ($_POST['action'] == 'infoDelFactura') {
		// print_r($_POST); exit;
		if (!empty($_POST['nrofactura'])) {
			# code...
			$nrofactura = $_POST['nrofactura'];
			$query = "SELECT * FROM factura WHERE nrofactura= '$nrofactura' AND estatus= 1";
			$query = mysqli_query($con, $query);

			$result_num_query= mysqli_num_rows($query);
			if ($result_num_query > 0) {
				# code...
				$data = mysqli_fetch_array($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;
			}
		}

		echo 'error';
		exit;
		
	}

	// Anular Factura-Submit
	if ($_POST['action'] == 'anularFactura') {
		// print_r($_POST); exit;
		if (!empty($_POST['nrofactura'])) {
			# code...
			$nrofactura = $_POST['nrofactura'];
			$query_anular = mysqli_query($con, "CALL anular_factura('$nrofactura')");

			$result_num_query= mysqli_num_rows($query_anular);
			if ($result_num_query > 0) {
				# code...
				$data = mysqli_fetch_array($query_anular);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;
			}
		}

		echo 'error';
		exit;
		
	}

	// if ($_POST['action'] == 'ReportClientesRange') {
	// 	// print_r($_POST); exit;
	// 	if (!empty($_POST['fechaDesde']) && !empty($_POST['fechaHasta'])) {
	// 		# code...
	// 		$fechaDesde = $_POST['fechaDesde'];
	// 		$fechaHasta = $_POST['fechaHasta'];

	// 		$query_select = "SELECT cli.idcliente, cli.fecha_add as fecha, cli.tipo_documento,
	// 		 cli.numero_documento, cli.nombre, cli.telefono, cli.direccion, cli.email
	// 				FROM cliente as cli
	// 	 			WHERE cli.estatus = 1 AND date(cli.fecha_add) >= date('$fechaDesde') and  date(cli.fecha_add) <= date('$fechaHasta') ORDER BY cli.fecha_add ASC";

	// 	 		$query_select = mysqli_query($con, $query_select);

	// 	 		$result_query_select = mysqli_num_rows($query_select);

	// 	 		if ($result_query_select > 0) {

	// 				$data = array();

	// 				while($row = mysqli_fetch_row($query_select)){
	// 					$data[] = $row;
	// 				}

	// 				echo json_encode($data, JSON_UNESCAPED_UNICODE);
	// 				exit;
	// 	 		}
	// 	}

	// 	echo 'error';
	// 	exit;
		
	// }

	exit;

	}

	mysqli_close($con);
 ?>
