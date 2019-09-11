<div class="well">
    <?php echo $textoBienvenida;?>

    <?php
	switch ($TIPOUSUARIO) {
		case 1:case 4:
			echo '<a class="btn btn-danger" href="'.INDEX_CP.'tutoriales"> Manual de usuario</a>';
			if ($VERIFICACION){ ?>

    <span class="">
        <a target="_blank" href="ReporteControlPatrimonial" class="btn btn-info" ><span
                class="glyphicon glyphicon-list"></span> Reporte <b>Listado de
                Bienes</b></a></span>
    <?php }else{ ?>
    <span class="">
        <span class="alert alert-success"><span class="glyphicon glyphicon-warning-sign">
            </span>
            <b>Por favor realice la
                <a href='<?php echo INDEX_CP?>verificacion_bienes' class='btn btn-sm btn-purple textWhite'>Verificación
                    de bienes</a> para desplegar el listado y poder descargar su reporte completo.</b>
        </span>
    </span>
    <?php } 
			break;
		case 2:case 5:
			echo '<a class="btn btn-danger" href="'.INDEX_CP.'tutoriales"> Manual de usuario</a>';
			break;
        case 3:
        echo '<a class="btn btn-primary" stretched-link" style= "margin-top:8px;" href="'. INDEX_CP.'vista_calendario">Calendario de eventos</a>';
			//echo '<a class="btn btn-danger"> Manual de usuario</a>';
			break;
		default:
			break;
	}
	?>
	
    <!-- LOS CASES PERTENECEN A CADA TIPO DE USUARIO ---->
</div>