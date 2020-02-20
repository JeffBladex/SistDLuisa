<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
		// header('location: home.php');
	}

	require_once "../db_connection/connection.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	ob_start();

	if(empty($_REQUEST['cli']) || empty($_REQUEST['fact']))
	{
		echo "No es posible generar la factura.";
	}else{
		$idcliente = $_REQUEST['cli'];
		$nrofactura = $_REQUEST['fact'];
		$anulada = '';

		$query_config   = mysqli_query($con,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($con,"SELECT f.nrofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.idcliente, f.estatus,
												 user.nombre as vendedor,
												 cli.numero_documento, cli.nombre as nombre_cliente, cli.telefono as telefono_cliente,cli.direccion as direccion_cliente
											FROM factura f
											INNER JOIN usuario user
											ON f.idusuario = user.idusuario
											INNER JOIN cliente cli
											ON f.idcliente = cli.idcliente
											WHERE f.nrofactura = '$nrofactura' AND f.idcliente = '$idcliente'  AND f.estatus != 10");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$nrofactura = $factura['nrofactura'];

			if($factura['estatus'] == 0){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($con,"SELECT distinct(UPPER(articulo.nombre)) as descripcion,df.cantidad,df.precio_venta,df.precio_total
				FROM factura f
				INNER JOIN detalle_factura AS df
                INNER JOIN articulo AS articulo
				INNER JOIN compras AS compras
														
                ON (f.nrofactura = df.nrofactura and compras.idarticulo = articulo.idarticulo and
					df.idarticulo = compras.idarticulo)
				WHERE f.nrofactura = '$nrofactura' ORDER BY articulo.nombre asc");

			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('Factura_Venta_Anulada_'.$nrofactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>