<?php 
	session_start();

	if(empty($_SESSION['active'])){
		header('location: index.php');
	}

 ?>

<header>
		<div class="header">
			
			<b><h5>Sistema-Accesorios <strong> D-ASTU </strong></h5></b>
			<div class="optionsBar">
				<span class="bold">Ecuador, <?php echo fechaC(); ?></span>
				<span>|</span>
				<span class="user"><?php echo  $_SESSION['usuario'] .'-'. $_SESSION['rol']; ?> </span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		
		<!-- Nav Bar -->
		<?php include_once 'nav.php' ?>

</header>

<style type="text/css">
	.bold{
		font-weight: bold;
	}
</style>

