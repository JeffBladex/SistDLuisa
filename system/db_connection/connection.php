<?php
	$host = "127.0.0.1:3366";
	$user = "root";
	$password = "";
	$db = "sistema_ventas_luisa_car";


    $con = mysqli_connect($host,$user,$password,$db);

    if(!$con){
		echo 'Error en la conexión <br>';
	}else{
		// echo 'Conexión Exitosa';

	}

?>