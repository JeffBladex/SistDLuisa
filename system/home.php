<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style-plain-system.css">
	<?php include_once 'logoSite.php'; ?>
	<title>HOme || Sistema-Accesorios D-ASTU</title>

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

	<section id="container">
		<h2>Bienvenido al sistema</h2>

		<br>

		<div class="row">
			<div class="col-sm-3 homeMenu">
				<div class="card" style="width: 15rem;">
					<img class="" src="img/go-to-link-2.png" width="100" height="100" alt="Card image cap">
					<div class="card-body">
						<p class="card-text">Listado de Usuarios.</p>
						<a href="listado_usuarios.php" class="btn btn-primary">Ir a Usuarios</a>
					</div>

				</div>
			</div>

			<div class="col-sm-3 homeMenu">
				<div class="card" style="width: 15rem;">
					<img class="" src="img/go-to-link-2.png" width="100" height="100" alt="Card image cap">
					<div class="card-body">
						<p class="card-text">Listado de Clientes.</p>
						<a href="listado_clientes.php" class="btn btn-primary">Ir a Clientes</a>
					</div>

				</div>
			</div>

			<div class="col-sm-3 homeMenu">
				<div class="card" style="width: 15rem;">
					<img class="" src="img/go-to-link-2.png" width="100" height="100" alt="Card image cap">
					<div class="card-body">
						<p class="card-text">Listado de Proveedores.</p>
						<a href="listado_proveedores.php" class="btn btn-primary">Ir a Proveedores</a>
					</div>

				</div>
			</div>

		</div>
	</section>

	<!-- Footer -->
	<section class="footerLogo">
		<div class="footLogo">
			<img src="img/logoLuisaCarNew.jpeg">
		</div>
	</section>
</body>
</html>

