<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es"> 
<head>
	<title>Control Patrimonial</title>
	<meta charset="utf-8">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="X-Frame-Options" content="deny">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" media="all" type="image/x-icon" href="<?php echo INDEX_CP ?>resources/images/favicon.ico" />
	<!-- 	js -->
    <script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/general.js"></script>
    <script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/grid.locale-es.js"></script>
    
	<!--  css  -->
    <link href="<?php echo INDEX_CP ?>resources/css/jquery-ui.css" rel="stylesheet">
	 <!-- Bootstrap -->
    <link href="<?php echo INDEX_CP ?>resources/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles-->
    <link href="<?php echo INDEX_CP ?>resources/css/main.css" rel="stylesheet">

   

</head>
<body>
	<!--AVISO DE CARGA-->
    <div id="loadData" >
				Cargando... <img src="<?php echo INDEX_CP ?>resources/images/load_transparent.gif" width="15px">
	</div>
	<div class="container">  <!-- CONTENEDOR -->
		<div id="mainHeader">
			<div class="alert alert-success" role="alert">
			  <h3><b>Página destinada para Capacitaciones.</b></h3>
			</div>
	        	<a href="<?php echo INDEX_CP ?>" > <img src="<?php echo INDEX_CP ?>resources/images/logo_segey_border1.png" alt="SEGEY" class="logoMain"> </a>
	        	<span class="alert alert-warning">Control Patrimonial</span>
				
	        <div class="lastDate">
	        	<ul class="actividad">
	        		<li>Perfil: <?php echo $NOMBREUSUARIO?>  <img src="<?php echo INDEX_CP ?>resources/images/ico_user.png" alt="usuario" class="icon24"></li>
	        		<li><?php echo $ULTIMACONEXION ?></li>
	        	</ul>
	        	
	    	</div>
	    </div>
	    <!-- MENU -->
		<div class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
		    <div class="navbar-header">
		        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		          <span class="sr-only">Navigation</span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		        </button>
		       
		    </div>
		    <div class="navbar-collapse collapse">
		        <ul class="nav navbar-nav">
		        	<li class="<?php if($SECCIONACTUAL == 'Inicio')echo 'active';?>"><a href="<?php echo INDEX_CP ?>" class="btn_inicio">Inicio</a></li>
			            <?php foreach ($SISTEMAS as $keyS => $valueS) {
			            		$active = '';
			            		if($SECCIONACTUAL == $valueS['MenuTituloSeccion']){$active = 'active';}
								echo '<li class="'.$active.'" ><a href="'.INDEX_CP.$valueS['UrlSeccion'].'" class="'.$valueS['MenuCssSeccion'].'">'.$valueS['MenuTituloSeccion'].'</a></li>';
								
			            	}?>
							
		        </ul>
		        <ul class="nav navbar-nav navbar-right">
		        	<li><a href="<?php echo INDEX_CP ?>salir" class="btn_salir">Regresar</a></li>
		        </ul>
		    </div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
		</div>

		<!-- CCT INFO -->
		<div class="alert alert-info">
			<?php echo '<span class="glyphicon glyphicon-info-sign"></span><strong> Nombre escuela: </strong>  '.$CCTINFO['NOMBRECT'].'  <span class="glyphicon glyphicon-home"></span> <strong>  Centro de trabajo: </strong>  '.$CCTINFO['CLAVECCT'].'  <span class="glyphicon glyphicon-time"></span><strong> Turno: </strong>  '.$CCTINFO['TURNO']; ?>
		</div>
		<input type="hidden" value="<?php echo $VERIFICACION;?>" id="vRst5" >
		<?php echo $MIGAS ?>
		

