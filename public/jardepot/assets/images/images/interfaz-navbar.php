<?php 
	include_once $_SESSION['levelPath'].'php/carritoClass.php';
	$carrito = new Carrito();

	$mysqli = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$mysqli->set_charset("utf8");

	$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
		'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
		'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
		'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	//<i class="fa fa-phone pr-5 pl-10"></i><strong>01 (800) 212 9225</strong>
	echo'
	<div class="header-container">

		<div class="header-top colored	"style="font-size:16px;">
			<div class="container">
				<div class="row-centered">
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
						<div class="header-top-first clearfix object-non-visible" data-animation-effect="bounceInLeft" data-effect-delay="0">
							<ul class="list-inline">
								<ul class="social-links circle animated-effect-1 colored small clearfix">
									<li class="facebook"><a target="_blank" href="https://www.facebook.com/Jardepot"><i class="fa fa-facebook"></i></a></li>
									<li class="youtube"><a target="_blank" href="https://www.youtube.com/channel/UCym0cCHYeEDqs70RD7Zs2-g"><i class="fa fa-youtube-play"></i></a></li>
									<li class="whatsapp"><a style="cursor:pointer;" data-toggle="modal" data-target="#whatsappModal"><i class="fa fa-whatsapp"></i></a></li>
								</ul>
								
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>CDMX: (55) 4996 8849, </strong>
								</li>
								<li style="font-size:19px;">
									<strong>(55) 4997 4360</strong>
								</li>
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>Guadalajara: (33) 1728 3353</strong>
								</li>
								
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>EDO MEX: (722) 648 1040 </strong>
								</li>
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>MTY: (812) 063 5708 </strong>
								</li>
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>Cuernavaca: (777) 241 6930 </strong>
								</li>
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>Veracruz: (229) 330 0992 </strong>
								</li>
								
								
								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong>800 212 9225</strong>
								</li>

								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong> Puebla: (222) 705 1726</strong>
								</li>

								<li style="font-size:19px;">
									<i class="fa fa-envelope pr-5 pl-10"></i><strong> ventas@jardepot.com</strong>
								</li>

								<li style="font-size:19px;">
									<i class="fa fa-envelope pr-5 pl-10"></i><strong> refacciones@jardepot.com</strong>
								</li>

								<li style="font-size:19px;">
									<i class="fa fa-phone pr-5 pl-10"></i><strong> Refacciones: (777) 244 6511</strong>
								</li>

							</ul>
						</div>
						<!-- header-top-first end -->
					</div>
					<div class="hidden-xs hidden-sm col-md-4 col-lg-3">
						<!-- logo ofertas-->
						<div id="logo" class="logo object-non-visible" data-animation-effect="bounceInDown" data-effect-delay="0">
							<a href="'.$_SESSION['webLevelPath'].'ofertas.php"><img id="logo_ofertas" class="lazy" style="max-width:120px;" data-original="'.$_SESSION['webLevelPath'].'images/buenFin.png" alt="ofertas"></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<header class="header fixed dark clearfix" id="navbarPrincipal">
			
			<div class="container">
				<div class="row">
					<div class="col-md-3">

						<div class="header-left clearfix">
							<div id="logo" class="logo object-non-visible" data-animation-effect="swing" data-effect-delay="0">
								<a href="'.$_SESSION['webLevelPath'].'index.php"><img id="logo_img" class="lazy" data-original="'.$_SESSION['webLevelPath'].'images/logo2.png" alt=""></a>
							</div>
						</div>

					</div>
					<div class="col-md-9">

						<div class="header-right clearfix">
							<div class="main-navigation  animated with-dropdown-buttons">

								<!-- navbar start -->
								<!-- ================ -->
								<nav class="navbar navbar-default" role="navigation">
									<div class="container-fluid">

										<div class="navbar-header">
											<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>
											
										</div>

										<div class="collapse navbar-collapse" id="navbar-collapse-1">
											<ul class="nav navbar-nav ">
	';
	//obtiene las categorias
	$select_stmt = $mysqli -> prepare("SELECT idCategoriasNivel1, nombreCategoriaNivel1 FROM categoriasNivel1 WHERE ubicacion = 'navbar' OR ubicacion = 'ambos' ORDER BY prioridad ASC");
	$select_stmt -> execute();
	$select_stmt -> store_result();
	$select_stmt -> bind_result($idCategoriasNivel1, $nombreCategoriaNivel1);


	while($select_stmt->fetch()){
		echo'
												<li class="dropdown  mega-menu">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#ffffff; text-shadow: none;"><strong>'.$nombreCategoriaNivel1.'</strong></a>
													<ul class="dropdown-menu">
														<li>
															<div class="row">
																<div class="col-lg-12 col-md-12">
																	<h4 class="title">'.$nombreCategoriaNivel1.'</h4>
																	<div class="row">
		';

		//cuenta las categorias nivel 2
		$select_stmt2 = $mysqli -> prepare("SELECT COUNT(*) FROM categoriasNivel2 WHERE idCategoriasNivel1 = ?");
		$select_stmt2 -> bind_param("i", $idCategoriasNivel1);
		$select_stmt2 -> execute();
		$select_stmt2 -> store_result();
		$select_stmt2 -> bind_result($cantidadCategoriasNivel2);
		$select_stmt2 -> fetch();
		$select_stmt2 -> close();

		$contadorCategoriasNivel2 = round($cantidadCategoriasNivel2/2);

		echo'
																		<div class="col-sm-6">
																			<div class="divider"></div>
																			<ul class="menu">
		';
		//imprime categorias nivel 2
		$contador = 1;
		$select_stmt2 = $mysqli -> prepare("SELECT idCategoriasNivel2, nombreCategoriaNivel2 FROM categoriasNivel2 WHERE idCategoriasNivel1 = ? ORDER BY prioridad ASC");
		$select_stmt2 -> bind_param("i", $idCategoriasNivel1);
		$select_stmt2 -> execute();
		$select_stmt2 -> store_result();
		$select_stmt2 -> bind_result($idCategoriasNivel2, $nombreCategoriaNivel2);
		while($select_stmt2 -> fetch()){

			$lowerNombreCategoriaNivel2 = strtolower($nombreCategoriaNivel2);

			if($contador <= $contadorCategoriasNivel2){
				echo'
																				<li><a href="'.$_SESSION['webLevelPath'].strtr($lowerNombreCategoriaNivel2, $unwanted_array).'/" title="'.$nombreCategoriaNivel2.'"><i class="fa fa-angle-right"></i>'.$nombreCategoriaNivel2.'</a></li>
				';
			}
			$contador++;
		}
		$select_stmt2 -> close();
		echo'
																				
																			</ul>
																		</div>
		';
		echo'
																		<div class="col-sm-6">
																			<div class="divider"></div>
																			<ul class="menu">
		';
		//imprime categorias nivel 2
		$contador = 1;
		$select_stmt2 = $mysqli -> prepare("SELECT idCategoriasNivel2, nombreCategoriaNivel2 FROM categoriasNivel2 WHERE idCategoriasNivel1 = ? ORDER BY prioridad ASC");
		$select_stmt2 -> bind_param("i", $idCategoriasNivel1);
		$select_stmt2 -> execute();
		$select_stmt2 -> store_result();
		$select_stmt2 -> bind_result($idCategoriasNivel2, $nombreCategoriaNivel2);
		while($select_stmt2 -> fetch()){

			$lowerNombreCategoriaNivel2 = strtolower($nombreCategoriaNivel2);

			if($contador > $contadorCategoriasNivel2){
				echo'
																				<li><a href="'.$_SESSION['webLevelPath'].strtr($lowerNombreCategoriaNivel2, $unwanted_array).'/"><i class="fa fa-angle-right" title="'.$nombreCategoriaNivel2.'"></i>'.$nombreCategoriaNivel2.'</a></li>
				';
			}
			$contador++;
		}
		$select_stmt2 -> close();
		echo'
																			</ul>
																		</div>
		';
		echo'
																	</div>
																</div>
															</div>
														</li>
													</ul>
												</li>
		';
	}
	$select_stmt -> close();                        				
												
	echo'
											</ul>
											<!-- main-menu end -->


											<!-- header dropdown buttons -->
											<div class="header-dropdown-buttons hidden-xs ">
												<div class="btn-group dropdown" data-toggle="tooltip" data-placement="bottom" data-original-title="Buscar">
													<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="background-color:#FF7504;"><i class="icon-search" style="color:#FFFFFF;"></i></button>
													<ul class="dropdown-menu dropdown-menu-right dropdown-animation" style="background-color:#FF7504;">
														<li>
															<form role="search" class="search-box margin-clear" action="'.$_SESSION['webLevelPath'].'busqueda.php" method="post" target="_blank">
																<div class="form-group has-feedback">
																	<input type="text" id="busqueda" name="busqueda" class="form-control" placeholder="Buscar producto" style="background-color:#FFFFFF; color:#3D3D3D;">
																	<i class="icon-search form-control-feedback" style="color:#3D3D3D;"></i>
																</div>
															</form>
														</li>
													</ul>
												</div>
												<div class="btn-group dropdown">
													<button type="button" style="background-color:#FF7504;" onclick="location.href=\''.$_SESSION['webLevelPath'].'carrito.php\';" class="btn dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Carrito de compras" aria-expanded="false"><i class="icon-basket-1" style="color:#FFFFFF;"></i><span class="cart-count default-bg">'.$carrito->articulos_total().'</span></button>
												</div>
											</div>
											<!-- header dropdown buttons end-->
											
										</div>

									</div>
								</nav>
								<!-- navbar end -->

							

							</div>
							<!-- main-navigation end -->	

						</div>
						<!-- header-right end -->
			
					</div>
				</div>
			</div>
			
		</header>
		<!-- header end -->
	</div>
	<!-- header-container end -->


	<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" style="font-size:25px;" id="whatsappModalLabel">WhatsApp JarDepot</h4>
				</div>
				<div class="modal-body row-centered">
					<img src="'.$_SESSION['webLevelPath'].'images/whatsappBig.png" alt="whatsapp" style="margin-left: auto; margin-right: auto; display: block;">
					<br>
					<h2 style="display:inline; font-size:45px;" class="col-centered">55 4996 8849</h2>
				</div>
			</div>
		</div>
	</div>
';?>
