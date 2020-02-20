$(document).ready(function(){

	// Modal Form - Add Articulo_Compra
	$('.add_articulo_compras').click(function(e){
		// Act ON the Event
		e.preventDefault();
		var articulo = $(this).attr('articulo_compra');
		var action = 'InfoArticuloToUpdate';
		// alert(articulo);

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, articulo:articulo},

			success: function(response){
				console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);
					console.log(info_success);

					$('#idcompras').val(info_success.idcompras);
					$('#nombreArticulo').html(info_success.nombre);
				}
			},

			error: function(error){
				console.log(error) ;
			}

		});
	});

	// Modal Form - Delete Articulo_Compras
	$('.delete_articulo_compras').click(function(e){
		// Act ON the Event
		e.preventDefault();
		var articulo = $(this).attr('articulo_compra_delete');
		var action = 'InfoArticuloToDelete';
		// alert(articulo);

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, articulo:articulo},

			success: function(response){
				// console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);

					console.log(info_success);

					$('#idcompras_DeleteForm').val(info_success.idcompras);
					$('#nombreArticulo_DeleteForm').html(info_success.nombre);
				}
			},

			error: function(error){
				console.log(error) ;
			}

		});
	});

	// Modal Form - Delete Compras
	$('.delete_compras').click(function(e){
		// Act ON the Event
		e.preventDefault();
		var compra = $(this).attr('compra_delete');
		var action = 'InfoCompraToDelete';
		alert(compra);

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, compra:compra},

			success: function(response){
				// console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);

					console.log(info_success);

					$('#idRegistroCompras_DeleteForm').val(info_success.idRegistroCompras);
					$('#NoCompraDeleteForm').html(info_success.idRegistroCompras);
					$('#NombreCompra_DeleteForm').html(info_success.nombre);
				}
			},

			error: function(error){
				console.log(error) ;
			}

		});
	});

	// Activar Campos para Registrar Cliente
	$('.btn_new_cliente').click(function(e){
		e.preventDefault();
		// alert("Estoy entrando a Js");
		$('#tipo_documento').removeAttr('disabled');
		$('#nom_cliente').removeAttr('disabled');
		$('#tel_cliente').removeAttr('disabled');
		$('#dir_cliente').removeAttr('disabled');

		$('#div_registro_cliente').slideDown();
	});

	// Buscar Cliente - Por Numero de Identificacion
	$('#num_identificacion_cliente').keyup(function(e){
		e.preventDefault();

		var cli = $(this).val();
		var action = 'searchCliente';

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, cliente:cli},

			success: function(response){
				console.log(response);

				if (response == 0) {
					$('#idcliente').val("");
					$('#tipo_documento').val("1");
					$('#nom_cliente').val("");
					$('#dir_cliente').val("");
					$('#tel_cliente').val("");
					// Mostrando Boton Agregar
					$('.btn_new_cliente').slideDown();
				}else{
					var data = $.parseJSON(response);

					// console.log(data);

					$('#idcliente').val(data.idcliente);

					if (data.tipo_documento == 'Cédula') {
						$('#tipo_documento').val("1");
					}else if(data.tipo_documento == 'Ruc'){
						$('#tipo_documento').val("2");
					}else{
						$('#tipo_documento').val("1");
					}

					$('#nom_cliente').val(data.nombre);
					$('#dir_cliente').val(data.direccion);
					$('#tel_cliente').val(data.telefono);

					// Ocultar Boton Agregar
					$('.btn_new_cliente').slideUp();

					// Bloquear Campos
					$('#tipo_documento').attr('disabled', 'disabled');
					$('#nom_cliente').attr('disabled', 'disabled');
					$('#tel_cliente').attr('disabled', 'disabled');
					$('#dir_cliente').attr('disabled', 'disabled');

					// Ocultar Boton Guardar
					$('#div_registro_cliente').slideUp();


				}
			},

			error: function(error){
				console.log(error) ;
			}


		});
	});

	// Crear Cliente - Ventas
	$('#form_new_cliente_venta').submit(function(e){
		e.preventDefault();

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: $('#form_new_cliente_venta').serialize(),

			success: function(response){
				// console.log(response);

				if (response != 'error') {
					// Agregar id a input hidden
					$('#idcliente').val(response);
					// Bloquear Campos
					$('#nom_cliente').attr('disabled', 'disabled');
					$('#tel_cliente').attr('disabled', 'disabled');
					$('#dir_cliente').attr('disabled', 'disabled');

					// Ocultar Boton Agregar
					$('.btn_new_cliente').slideUp();
					// Ocultar Boton Guardar
					$('#div_registro_cliente').slideUp();

				}


				
			},

			error: function(error){
				console.log(error) ;
			}


		});
	});

	// Buscar - Articulo x Codigo
	$('#txt_cod_articulo').keyup(function(e){
		e.preventDefault();

		var idarticulo = $(this).val();
		var action = "infoArticulo";

		if (idarticulo != '') {
			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action:action, articulo:idarticulo},

			success: function(response){
				// console.log("sucess");
				console.log(response);

				if (response != 'error') {
					var info = JSON.parse(response);
					// $('#txt_descripcion').html(info.nombre_Articulo);
					var nombre_articulo = info.nombre_articulo;
					// $("#Articulo_List").val(info.nombre_articulo).change();
					// $("#Articulo_List").change();
					$('#ArticuloGet').html(info.nombre_articulo);

					$('#txt_existencia').html(info.existencia);
					$('#txt_cant_articulo').val('1');

					$('#txt_precio_min').html(info.precio_venta_min);
					$('#txt_precio_max').html(info.precio_venta_max);

					$('#txt_precio_pagar').val(info.precio_venta_max);
					$('#txt_precio_total').html(info.precio_venta_max);

					// Activar Cantidad
					$('#txt_cant_articulo').removeAttr('disabled');

					// Activar Precio Pagar
					$('#txt_precio_pagar').removeAttr('disabled');

					// Mostrar Boton Agregar
					$('#add_Articulo_Venta').slideDown();
				}else{
					// $('#txt_descripcion').html('-');
					$('#txt_existencia').html('-');
					$('#txt_cant_articulo').val('0');
					$('#txt_precio_min').html('0.00');
					$('#txt_precio_max').html('0.00');
					$('#txt_precio_pagar').val('0.00');
					$('#txt_precio_total').html('0.00');

					// Bloquear Cantidad
					$('#txt_cant_articulo').attr('disabled', 'disabled');

					// Bloquear Precio Pagar
					$('#txt_precio_pagar').attr('disabled', 'disabled');

					// Ocultar Boton Agregar
					$('#add_Articulo_Venta').slideUp();
				}
			},

			error: function(error){
				// console.log("error");
				// console.log(error) ;
			}

		});

		}else{

		}

	});

	// Buscar - Nombre Articulo
	// $('#Articulo_List').click(function(e){
	// 	e.preventDefault();

	// 	var nombre_articulo = $(this).val();
	// 	var action = "infoArticulo_x_Nombre";

	// 	if (nombre_articulo != '') {
	// 		$.ajax({
	// 		url: 'ajax.php',
	// 		type: 'POST',
	// 		async: true,
	// 		data: {action:action, articulo:nombre_articulo},

	// 		success: function(response){
	// 			console.log("sucess");
	// 			console.log(response);

	// 			if (response != 'error') {
	// 				var info = JSON.parse(response);
				
	// 				$('#txt_cod_articulo').val(info.codigo_articulo);
	// 				$('#txt_existencia').html(info.existencia);
	// 				$('#txt_cant_articulo').val('1');
	// 				$('#txt_precio_min').html(info.precio_venta_min);
	// 				$('#txt_precio_max').html(info.precio_venta_max);

	// 				$('#txt_precio_pagar').val(info.precio_venta_max);
	// 				$('#txt_precio_total').html(info.precio_venta_max);

	// 				// Desactivar Codigo Articulo
	// 				$('#txt_cod_articulo').attr('disabled', 'disabled');

	// 				// Activar Cantidad
	// 				$('#txt_cant_articulo').removeAttr('disabled');

	// 				// Activar Precio Pagar
	// 				$('#txt_precio_pagar').removeAttr('disabled');

	// 				// Mostrar Boton Agregar
	// 				$('#add_Articulo_Venta').slideDown();
	// 			}else{
	// 				// $('#txt_descripcion').html('-');
	// 				$('#txt_existencia').html('-');
	// 				$('#txt_cant_articulo').val('0');
	// 				$('#txt_precio_min').html('0.00');
	// 				$('#txt_precio_max').html('0.00');
	// 				$('#txt_precio_pagar').val('0.00');
	// 				$('#txt_precio_total').html('0.00');

	// 				// Bloquear Cantidad
	// 				$('#txt_cant_articulo').attr('disabled', 'disabled');

	// 				// Bloquear Precio Pagar
	// 				$('#txt_precio_pagar').attr('disabled', 'disabled');

	// 				// Ocultar Boton Agregar
	// 				$('#add_Articulo_Venta').slideUp();
	// 			}
	// 		},

	// 		error: function(error){
	// 			// console.log("error");
	// 			// console.log(error) ;
	// 		}

	// 	});

	// 	}else{

	// 	}
	// }); 

	// Validando Cantidad de Articulos Antes de Agregar
	$('#txt_cant_articulo').keyup(function(e){
		e.preventDefault();
		var precio_total = $(this).val() * $('#txt_precio_pagar').val();
		var existencia = parseInt($('#txt_existencia').html());

		 precio_total = Math.round(precio_total * 100) / 100;

		$('#txt_precio_total').html(precio_total);

		// Ocultar el boton Agregar si la cantidad es menor que 1
		if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)  ){
			$('#add_Articulo_Venta').slideUp();
		}else{
			$('#add_Articulo_Venta').slideDown();
		}	

	});

	// Validando Precio Pagar de Articulos Antes de Agregar
	$('#txt_precio_pagar').keyup(function(e){
		e.preventDefault();
		var precio_total = $(this).val() * $('#txt_cant_articulo').val();

		  precio_total = Math.round(precio_total * 100) / 100;

		$('#txt_precio_total').html(precio_total);

		// Ocultar el boton Agregar si la cantidad es menor que 1
		if($(this).val() <= 0 || isNaN($(this).val())){
			$('#add_Articulo_Venta').slideUp();
		}else{
			$('#add_Articulo_Venta').slideDown();
		}	

	});

	// VENTAS MODULO
	secuencia_venta();

	// Obteniendo maxima secuencia de Venta
	function secuencia_venta(){
		if($('#txt_secuencia_venta').val() >= 0 ){

			var action = 'getUltimoValordeSecuencia_Venta';
			var ultimo_val_secuencia = $('#txt_secuencia_venta').val();

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, secuencia:ultimo_val_secuencia},

			success: function(response){
				console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);
					console.log(info_success);
					var nueva_secuencia = parseInt(info_success.secuencia) + 1;

					$('#txt_secuencia_venta').val(nueva_secuencia);
				}
			},

			error: function(error){
				console.log(error) ;
			}

		});

		}
	}

	// Agregar articulos al detalle
	$('#add_Articulo_Venta').click(function(e){
		e.preventDefault();
		if($('#txt_cant_articulo').val() > 0 ){

			var codigo_articulo= $('#txt_cod_articulo').val();
			var cantidad = $('#txt_cant_articulo').val();
			var descripcion = $('#ArticuloGet').html();
			var precio_pagar = $('#txt_precio_pagar').val();
			var precio_total = $('#txt_precio_total').html();

			var secuencia = $('#txt_secuencia_venta').val();

			var action = 'addArticuloDetalle';

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,
			       codigo_articulo:codigo_articulo,
			  	   cantidad:cantidad,
			  	   descripcion:descripcion,
			  	   precio_pagar:precio_pagar,
			  	   precio_total:precio_total,
			  	   secuencia: secuencia
			  	},

			success: function(response){
				// console.log(response);
				if (response != 'error') {
					var info = JSON.parse(response);
					console.log(info);

					$('#detalle_venta').html(info.detalle);
					$('#detalle_totales').html(info.totales);

					// Limpiando el ingreso
					$('#txt_cod_articulo').val("");
					$('#ArticuloGet').html("-");
					$('#txt_existencia').html("-");
					$('#txt_cant_articulo').val("0");
					$('#txt_precio_min').html("0.00");
					$('#txt_precio_max').html("0.00");
					$('#txt_precio_pagar').val("0");
					$('#txt_precio_total').html("0.00");

					// Bloqueando la Cantidad
					$('#txt_cant_articulo').attr('disabled','disabled');

					// Ocultando el boton Agregar
					$('#add_Articulo_Venta').slideUp();					

				}else{
					console.log('No Data');
				}

				viewProcesar();


			},

			error: function(error){
				// console.log("error");
				// console.log(error) ;
			}

		});


		}
	});

	// Anular Venta
	$('#btn_anular_venta').click(function(e){
		e.preventDefault();

		var rows = $('#detalle_venta tr').length;
		var secuencia_Actual = $('#txt_secuencia_venta').val();

		console.log('num rows ' + rows);

		if (rows > 0) {
			var action = 'anularVenta';

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,
				   secuencia: secuencia_Actual

			},

			success: function(response){
				if (response != 'error') {
					location.reload();

				}else{
					console.log('No Data');
				}

				viewProcesar();
			},

			error: function(error){
				// console.log("error");
				// console.log(error) ;
			}

		});


		}
	});

	// Facturar Venta
	$('#btn_procesar_venta').click(function(e){
		e.preventDefault();

		var rows = $('#detalle_venta tr').length;
		var secuencia_Actual = $('#txt_secuencia_venta').val();

		var codigo_cliente = $('#idcliente').val();

		// console.log('num rows ' + rows);

		if (rows > 0) {
			var action = 'procesarVenta';

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,
				   secuencia: secuencia_Actual,
				   codigo_cliente: codigo_cliente
			},

			success: function(response){
				// console.log(response);
				if (response != 'error') {
					var info = JSON.parse(response);
					console.log(info);

					generarPDF(info.idcliente, info.nrofactura);
					location.reload();
				}else{
					console.log('No data');
				}
			},

			error: function(error){
				// console.log("error");
				// console.log(error) ;
			}

		});


		}

	});

	// Generar_Descargar Pdf
	$('#btn_expo_pdf').click(function(e){
		e.preventDefault();

		// console.log('num rows ' + rows);
			var action = 'Generar_Descargar_Pdf';

			$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action:action
			},

			success: function(response){
				// console.log(response);
				if (response != 'error') {
					var info = JSON.parse(response);
					console.log(info);

					generarPDF(info.idcliente, info.nrofactura);
				}else{
					console.log('No data');
				}
			},

			error: function(error){
				// console.log("error");
				// console.log(error) ;
			}

		});

	});

	// Modal Form - Anular Factura
	$('.anular_factura').click(function(e){
		// Act ON the Event
		e.preventDefault();
		var nrofactura = $(this).attr('fact');
		var action = 'infoDelFactura';
		// alert(nrofactura);

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, nrofactura:nrofactura},

			success: function(response){
				console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);
					console.log(info_success);

					$('#anuNroFactura').html(info_success.nrofactura);
					$('#anuTotFact').html(info_success.total_factura);
					$('#anuFecha').html(info_success.fecha);

					$('#NroFactura').val(info_success.nrofactura);


				}
			},

			error: function(error){
				console.log(error) ;
			}

		});
	});

	$('.view_factura').click(function(e){
		e.preventDefault();
		var cod_cliente = $(this).attr('cli');
		var nrofactura = $(this).attr('fact');

		generarPDF(cod_cliente, nrofactura);


	});

	


}); // End-Ready




function sendDataArticulo(){
		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: $('#form_add_articulo_compra').serialize(),

			success: function(response){
				console.log(response);

				if (response == 'error') {
					$('.alertAddArticulo').html('<p style="color: red;">Error Al Agregar el Articulo.</p>');
				}else{

					var info_success =  JSON.parse(response);

					console.log("Id Compra: " + info_success.idcompras);
					console.log("Precio Nuevo: " + info_success.nuevo_precio_venta);
					console.log("Existencia Add: " + info_success.nueva_existencia);
					console.log("Fecha Mod: " + info_success.fecha_mod);

					$('.row'+ info_success.idcompras+' .cellPrecio_Venta').html(info_success.nuevo_precio_venta);
					$('.row'+ info_success.idcompras+' .cellExistencia').html(info_success.nueva_existencia);
					$('.row'+ info_success.idcompras+' .cellFechaMod').html(info_success.fecha_mod);

					// Limpiando Campos Modales
					$('#cantidad_add').val("");
					$('#precio_nuevo').val("");

					// Mostrando Alert - Success
					$('.alertAddArticulo').html('<p style="color: green;">Articulo Añadido Correctamente.</p>');

				}

			},

			error: function(error){
				console.log(error) ;
			}

		});

}

function DeleteArticulo(){
	$('.alertDeleteArticulo').html("");
	var pr = $('#idcompras_DeleteForm').val();

	$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: $('#form_delete_articulo_compra').serialize(),

			success: function(response){
				console.log(response);

				if (response == 'error') {
					$('.alertDeleteArticulo').html('<p style="color: red;">Error, Al Eliminar el Articulo.</p>');
				}else{

					$('.row'+ pr).remove();
					// Removiendo Boton Eliminar
					$('#form_delete_articulo_compra .btn_delete').remove();

					// Mostrando Alert - Success
					$('.alertDeleteArticulo').html('<p style="color: green;">Articulo fue Eliminado Correctamente.</p>');

				}

			},

			error: function(error){
				console.log(error) ;
			}

		});
}

function DeleteCompra(){
	$('.alertDeleteCompra').html("");
	var pr = $('#idRegistroCompras_DeleteForm').val();

	$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: $('#form_delete_compra').serialize(),

			success: function(response){
				console.log(response);

				if (response == 'error') {
					$('.alertDeleteCompra').html('<p style="color: red;">Error, Al Eliminar el Articulo.</p>');
				}else{

					$('.row'+ pr).remove();
					// Removiendo Boton Eliminar
					$('#form_delete_compra .btn_delete').remove();

					// Mostrando Alert - Success
					$('.alertDeleteCompra').html('<p style="color: green;">Articulo fue Eliminado Correctamente.</p>');

				}

			},

			error: function(error){
				console.log(error) ;
			}

		});
}

function closeModal_Add_Articulo(){
		$('.alertAddArticulo').html("");
		$('#cantidad_add').val("");
		$('#precio_nuevo').val("");
}

function closeModal_Delete_Articulo(){
	$('.alertDeleteArticulo').html("");
}

function Limpiar_Datos_Cliente(){
	$('#tipo_documento').val("1");
	$('#num_identificacion_cliente').val("");
	$('#nom_cliente').val("");
	$('#tel_cliente').val("");
	$('#dir_cliente').val("");
}

function searchForDetalle(secuencia_Activa){
	var action = 'searchForDetalle';
	var secuencia = secuencia_Activa;

	$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, secuencia: secuencia},

			success: function(response){
				// console.log(response);
				if (response != 'error') {
					var info = JSON.parse(response);

					$('#detalle_venta').html(info.detalle);
					$('#detalle_totales').html(info.totales);
				}else{
					console.log('No data');
				}

				viewProcesar();

			},

			error: function(error){
				// console.log(error) ;
			}

		});
}

function delete_articulo_detalle(idVentaTemp){
	var action = 'deleteArticuloDetalle';
	var idVentaTemp = idVentaTemp;
	var secuencia = $('#txt_secuencia_venta').val();

	$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, idArticuloDetalle:idVentaTemp, secuencia: secuencia},

			success: function(response){
				// console.log(response);

				if (response != 'error') {
					var info_success =  JSON.parse(response);
					console.log(info_success);

					// Limpiando el ingreso
					$('#txt_cod_articulo').val("");
					$('#Articulo_List').val("-");
					$('#txt_existencia').html("-");
					$('#txt_cant_articulo').val("0");
					$('#txt_precio_min').html("0.00");
					$('#txt_precio_max').html("0.00");
					$('#txt_precio_pagar').val("0");
					$('#txt_precio_total').html("0.00");

					// Bloqueando la Cantidad
					$('#txt_cant_articulo').attr('disabled','disabled');

					// Ocultando el boton Agregar
					$('#add_Articulo_Venta').slideUp();					
				}else{
					$('#detalle_venta').html('');
					$('#detalle_totales').html('');
				}

				viewProcesar();
			},

			error: function(error){
				// console.log(error) ;
			}

		});

}

 // Mostrar/Ocultar Boton Procesar
function viewProcesar(){
	if($('#detalle_venta tr').length > 0){
		$('#btn_procesar_venta').show();
	}else{
		$('#btn_procesar_venta').hide();
	}
}

function generarPDF(cliente,factura){
	var ancho = 1000;
	var alto = 800;

	// Calculando posicion para centrar la ventana
	var x = parseInt((window.screen.width/2)-(ancho/2));
	var y = parseInt((window.screen.height/2)-(alto/2));

	$url = 'factura/generaFactura.php?cli=' +cliente+ '&fact=' +factura;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+
				",scrollbar=si,location=no,resizable=si,menubar=no");
}

// function descargarEXCEL(cliente,factura){
// 	$url = 'factura/generaExcel.php?cli=' +cliente+ '&fact=' +factura;
// 	window.location.href = $url;
// }


// function descargarWORD(cliente,factura){
// 	$url = 'factura/generaWord.php?cli=' +cliente+ '&fact=' +factura;
// 	window.location.href = $url;
// }

function downloadFile_Pdf(cliente,factura){
	var ancho = 1000;
	var alto = 800;

	// Calculando posicion para centrar la ventana
	var x = parseInt((window.screen.width/2)-(ancho/2));
	var y = parseInt((window.screen.height/2)-(alto/2));

	$url = 'descargaPdf_id.php?cli=' +cliente+ '&fact=' +factura;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+
				",scrollbar=si,location=no,resizable=si,menubar=no");
}

function anularFactura(){
		var nrofactura = $('#anuNroFactura').html();
		var action = 'anularFactura';

		// alert(nroFactura);

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,
			data: {action: action, nrofactura:nrofactura},

			success: function(response){
				console.log(response);

				if (response == 'error') {
					// var info_success =  JSON.parse(response);
					// console.log(info_success);

					// location.reload();

					$('.alertAnuFact').html('<h3 style="color:red;">Error al anular la Factura.</h3>');
				}else{
					$('#row_'+nrofactura+' .estatus').html('<span class="anulada">Anulada.</span>')
					$('#form_anular_fact .btn_new').remove();
					// $('#row_'+nrofactura+' .div_factura').html('<button type="button" class="btn_anular inactive"></button>');
					$('.alertAnuFact').html('<h3 style="color:green;font-weight:bold;">Factura Anulada.</h3>');
				}
			},

			error: function(error){
				console.log(error) ;
			}

		});
	
	}

function closeModal_Anular_Fact(){
	location.reload();
}

// function ReporteFiltroCliente(){
// 	// alert("LLegue Reporte Filtro Cliente");
// 	var action1 = 'ReportClientesRange';
// 	var action2 = 'getReportClientesRange';

// 	var fechaDesde = $('#FechaDesdeRClientes_R').val();
// 	var fechaHasta = $('#FechaHastaRClientes_R').val();
// 	var data = '';

// 	$.ajax({
// 			url: 'ajax.php',
// 			type: 'POST',
// 			async: true,
// 			data: {action: action1, fechaDesde:fechaDesde, fechaHasta:fechaHasta},

// 			success: function(response){
// 				if (response != 'error') {
// 					data =  JSON.parse(response);

// 					window.location.replace("http://localhost/sistema_ventas_luisa/system/reporte_filtro/ClienteExcel.php?data=$data");

						
// 				}
// 			},

// 			error: function(error){
// 				console.log(error) ;
// 			}

// 		});
// }



