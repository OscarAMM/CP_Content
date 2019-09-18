<!-- Inicio del archivo -->
<script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/solicitud_alta_grid.js"></script>
<script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/jquery.jqGrid.min.js"></script>
<link href="<?php echo INDEX_CP ?>resources/css/ui.jqgrid.css" rel="stylesheet" />
<script>
	$(function() {
		$("#altaAgregaBien").click(function() {
			$("#tab-form-agregaAnexos").hide();
			$("#tab-anexos-solicitud").hide();

			$("#tab-form-agregaBien").slideToggle("Blind");  

			if ($("#tab-form-agregaBien").css("display") != "none")
			{
				get_ajax_frm_bienes();
			}	
			else
			{
				$("#form_bienes_content").html(""); 
			}
  		});

		$("#altaAgregaAnexos").click(function() {
  			$("#tab-form-agregaAnexos").slideToggle("Blind");
  			$("#tab-form-agregaBien").hide();
  			$("#tab-anexos-solicitud").hide();

  			if ($("#tab-form-agregaAnexos").css("display") != "none")
			{
  				get_ajax_frm_anexos();
  			}
  			else
  			{
  				$("#form_anexos_content").html(""); 
  			}
		});     		

		$("#altaAnexosSolicitud").on("click", function(){
  			$("#tab-form-agregaBien").hide();
  			$("#tab-form-agregaAnexos").hide();
  			$("#tab-anexos-solicitud").slideToggle("Blind");
		});

	});	

	function get_ajax_frm_bienes ()
	{		
		$.ajax({				
		    url : uri+"safb_frmBienes",
		    data : {'cp_hsh4_tk': $("#token").val()},
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
				$('#loadData').show();
				},
			success: function(data){	
				$("#form_bienes_content").html(data.contenido);		
				$('#loadData').hide();		   	
			   },
			error: function (jqXHR, textStatus, errorThrown){	
				$('#loadData').hide();			
			   }
		});	
	}

	function get_ajax_frm_anexos ()
	{
		$.ajax({				
		    url : uri+"safa_frmAnexos",
		    data : {'cp_hsh4_tk': $("#token").val()},
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
				},
			success: function(data){										
				$("#form_anexos_content").html(data.contenido);				   	
			   },
			error: function (jqXHR, textStatus, errorThrown){			
			   }
		});	
	}
	function confEliminarBienes(bienesIds)
	{
		pregunta("¿Está seguro de eliminar los bienes seleccionados?","","INFO","eliminarBienes",bienesIds);
	}

	function eliminarBienes(bienesIds)
	{
		$.ajax({				
		    url : uri+"safb_delBienes",
		    data : { 'bienesIds' : bienesIds, 'cp_hsh4_tk': $("#token").val() },
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
					$("#tab-form-agregaBien").hide();
					$("#tab-form-agregaAnexos").hide();
					$("#tab-anexos-solicitud").hide();
				},
			success: function(data){										
				if(!data.errores){ mensaje("ERROR! " + data.mensaje, "", "ERROR"); }
				else { 
					mensaje(data.mensaje, "", "OK"); 
					$("#tablaListadoAlta").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
				}				
				$("#loadData").hide();		   	
			   },
			error: function (jqXHR, textStatus,errorThrown){
			   	$("#loadData").hide();				
			   }
		});
	}

	function detalleBienes(bienesIds)
	{
		$("#tab-form-agregaAnexos").hide();
		$("#tab-anexos-solicitud").hide();

		$.ajax({				
		    url : uri+"safb_updBienes",
		    data : { 'bienesIds' : bienesIds, 'cp_hsh4_tk': $("#token").val() },
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
					$("#form_bienes_content").html("Cargando....");
				},
			success: function(data){										
				$("#form_bienes_content").html(data.contenido);
				if( $( "#tab-form-agregaBien").css("display") == "none" )
					$( "#tab-form-agregaBien").slideToggle("Blind");
				
				$("#loadData").hide();
			   },
			error: function (jqXHR, textStatus,errorThrown){
				//alert(errorThrown);
			   	$("#loadData").hide();				
			   }
		});
	}

	function confEliminarAnexos(idAnexo, NoFactura)
	{
		pregunta("¿Está seguro de eliminar la evidencia seleccionada?","<b>No. Factura:</b> "+NoFactura,"INFO","eliminarAnexosSolicitud",idAnexo);
	}
	
	function eliminarAnexosSolicitud(idAnexo)
	{
		$.ajax({				
		    url : uri+"alta_delAnexo",
		    data : { 'cp_hsh4_tk': $("#token").val(), 'idAnexo':idAnexo, 'idSolicitud': $("#hdn_IdSolicitud").val() },
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
				},
			success: function(data){										
				if(!data.errores){ mensaje("ERROR! " + data.mensaje, "", "ERROR"); }
				else { 
					mensaje(data.mensaje, "", "OK"); 
					$("#tab-anexos-solicitud-content").html(data.anexos);
				}				
				$("#loadData").hide();		   	
			   },
			error: function (jqXHR, textStatus,errorThrown){
			   	$("#loadData").hide();				
			   }
		});
	}
	function editar_info_sol(accion,btn){
		if(accion == "Habilitar")
		{
			sAccion = "Guardar";
			if(btn == "tels")
			{
				$("#txt_tel_sol").removeAttr("disabled");
				$("#txt_tel_sol2").removeAttr("disabled");
				$("#btn_icon_editTel").removeClass("glyphicon-pencil");
				$("#btn_icon_editTel").addClass("glyphicon-ok");
				$("#btn_editTel").attr("onclick","editar_info_sol('Guardar','tels')");
				$("#btn_editTel").attr("title","Guardar teléfono(s)");
			}
			if(btn == "correo")
			{
				$("#txt_correo_sol").removeAttr("disabled");				
				$("#btn_icon_editCorreo").removeClass("glyphicon-pencil");
				$("#btn_icon_editCorreo").addClass("glyphicon-ok");
				$("#btn_editCorreo").attr("onclick","editar_info_sol('Guardar','correo')");
				$("#btn_editCorreo").attr("title","Guardar correo electrónico");
			}	
		}		
		if(accion == "Guardar")
		{
			var token = $("#token").val(), idSolicitud = $("#hdn_IdSolicitud").val();
			var tel = $("#txt_tel_sol").val(), tel2 = $("#txt_tel_sol2").val(), correo = $("#txt_correo_sol").val();			
			$.ajax({				
		    url : uri+"alta_edittelsol",
		    data : { 'cp_hsh4_tk': token, 'idSolicitud': idSolicitud, 'tel': tel, 'tel2' : tel2, 'correo' : correo },
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
				},
			success: function(data){										
				if(data.errores){ mensaje("ERROR! " + data.error_msg, "", "ERROR"); }
				else { 
					if(btn == "tels")
					{
						$("#txt_tel_sol").attr("disabled","disabled");
						$("#txt_tel_sol2").attr("disabled","disabled");
						$("#btn_icon_editTel").removeClass("glyphicon-ok");
						$("#btn_icon_editTel").addClass("glyphicon-pencil");
						$("#btn_editTel").attr("onclick","editar_info_sol('Habilitar','tels')");
						$("#btn_editTel").attr("title","Editar teléfono(s)");
					}
					if(btn == "correo")
					{
						$("#txt_correo_sol").attr("disabled","disabled");						
						$("#btn_icon_editCorreo").removeClass("glyphicon-ok");
						$("#btn_icon_editCorreo").addClass("glyphicon-pencil");
						$("#btn_editCorreo").attr("onclick","editar_info_sol('Habilitar','correo')");
						$("#btn_editCorreo").attr("title","Editar correo electrónico");
					}	
				}				
				$("#loadData").hide();		   	
			   },
			error: function (jqXHR, textStatus,errorThrown){
			   	$("#loadData").hide();				
			   }
		});
				
		}

		
	}
</script>
<style type="text/css">	
	#tab-anexos-solicitud-content div{
		margin:2px;
		padding:1px;
		height:auto;
		width:112px;
		float:left;
		text-align:center;
	}
	#tab-anexos-solicitud-content div div{
		text-align:center;
		font-weight:normal;
		width:88px;
		margin:2px; 
		position:bottom;
		padding-left: 5px;	
	}
	#tab-anexos-solicitud-content div a img{
		display:inline;
		margin:2px;
		/*border:1px solid #ffffff;*/
	}
	#tab-anexos-solicitud-content div button{
		border:1px solid #999;
		float: left;
	}	
	.form-control{
		text-transform: uppercase;
	}
</style>
<input id="token" type="hidden" name="cp_hsh4_tk" value="<?=$token?>" />
<input id="hdn_IdSolicitud" type="hidden" name="IdSolicitud" value="<?=$IdSolicitud?>" />
<div id="Anexos" title="Evidencia de Bien Seleccionado" style="display: none"></div>
<div style="display:inline">
	<span class="tituloInicio">Solicitud de Alta</span>
	<span class="right"><span class="tituloInicio">Folio:</span>
		<span class="textLarge"><?=@$datos_cabecera[0]->FolioSolicitud?></span>
	</span>
</div><br/><br/>
<div class="panel panel-danger">
	<div class="panel-heading"><b>Centro de trabajo que entrega:</b></div>
	<div class="panel-body">
		<table class="table">
			<tr>
				<td colspan='2'><span class="titleInfo"><b>Área o plantel:</b> <?=@$datos_cabecera[0]->NOMBRECT?></span></td>
			</tr>
			<tr>
				<td><span class="titleInfo"><b>Domicilio:</b> <?=@$datos_cabecera[0]->DOMICILIO?></span></td>
				<td><span class="titleInfo"><b>Población:</b> <?=@$datos_cabecera[0]->poblacion?></span></td>
			</tr>
			<tr>
				<td><span class="titleInfo"><b>Clave:</b> <?=@$datos_cabecera[0]->CLAVECCT?></span></td>
				<td><span class="titleInfo"><b>Zona:</b> <?=@$datos_cabecera[0]->ZONAESCOLA?></span></td>
			</tr>
			<tr>
				<td><span class="titleInfo"><b>Turno:</b> <?=@$datos_cabecera[0]->TURNO?></span></td>
				<td><span class="titleInfo"><b>Teléfono(s):</b>				
					<input type="text" id="txt_tel_sol" value="<?=@$datos_cabecera[0]->TELEFONOS?>" disabled maxlength="15" size="18"/>
					<input type="text" id="txt_tel_sol2" value="<?=@$datos_cabecera[0]->TelefonoSolicitud2?>" disabled maxlength="15" size="18"/>
					<button id="btn_editTel" type="button" title="Editar teléfono(s)" class="btn btn-default btn-xs" style="border:0" onclick="editar_info_sol('Habilitar','tels')">
					  <span id="btn_icon_editTel" class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</button>
				</span></td>
			</tr>
			<tr>
				<td colspan='2'><span class="titleInfo"><b>Correo electrónico:</b>
					<input type="text" id="txt_correo_sol" name="txt_correo_sol" value="<?=@$datos_cabecera[0]->CorreoElectronico?>" disabled maxlength="120" size="40"/>					
					<button id="btn_editCorreo" type="button" title="Editar correo electrónico" class="btn btn-default btn-xs" style="border:0" onclick="editar_info_sol('Habilitar','correo')">
					  <span id="btn_icon_editCorreo" class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</button>
				</span></td>
			</tr>
		</table>
	</div>
</div>
<div class="well btn-group" role="group">
	
	<label for="altaAgregaAnexos"><span class="label label-danger">Paso 1</span> <a href="javascript:;" onclick="mensaje('Ayuda','Por favor, primero ingrese los archivos correspondientes a las evidencias para los bienes de esta solicitud','INFO');" class="btn btn-xs btn-info"> ? </a><br/><button id="altaAgregaAnexos" type="button" class="btn btn-purple">Agregar evidencia</button></label>
	<label for="altaAgregaBien"><span class="label label-danger">Paso 2</span> <a href="javascript:;" onclick="mensaje('Ayuda','<h4>Agregar bien</h4> Por favor complete el formulario con los datos del nuevo bien. <br> *Los campos marcados con asterisco son obligtorios.','INFO');" class="btn btn-xs btn-info"> ? </a> <br/><button id="altaAgregaBien" type="button" class="btn btn-purple">Agregar bienes a la solicitud de alta</button> <button id="altaAnexosSolicitud" type="button" class="btn btn-purple">Ver Evidencias de la solicitud</button></label>
</div>
<div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all" hidden="hidden">
	<div class="ui-widget-header ui-corner-all textLarge">Agregar bien</div>
	<div class="alert alert-warning" role="alert">
		<p>
			<img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> Por favor utilice el siguiente formulario para cargar bienes relacionados a esta <b>solicitud de alta</b>.	      	
		</p><br/>
		<p><b>NOTA:</b> 
			Si el bien es compartido debe seleccionar un director responsable por cada centro de trabajo enlistado (al menos dos responsables seleccionados). 
			En el caso de que falte información, favor de ir al sistema de "Plantilla" para acompletarla y recargue la página.
		</p>
		<!--<p><b>NOTA:</b> Presione en la <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> arriba del anexo relacionado para quitarlo del(de los) bien(es).</p>-->
	</div>
	<!-- inicio: vista_form_bienes -->
	<div  id='form_bienes_content'><?=@$frm_bienes?></div>
	<!-- fin: vista_form_bienes -->	
</div>		
<div id="tab-form-agregaAnexos" class="ui-widget-content ui-corner-all" <?=( isset($hidden_frm_anexos) ) ? $hidden_frm_anexos : "hidden='hidden'" ?>>
	<div class="ui-widget-header ui-corner-all textLarge">Agregar evidencia</div>
	<!--div  class="alert alert-warning" role="alert"-->
		<p>
			<img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> Por favor utilice el siguiente formulario para cargar evidencias relacionadas a los bienes de esta <b>solicitud de alta</b>.
	      	<span>Los archivos deben de cumplir con los siguientes requisitos:
	        	<ul class="anexosLista">
		          	<li>Formato JPG, PNG, PDF ó XML</li>
		          	<li>Medida máxima de 1 Mb (1024 Kb).</li>
	        	</ul>
	      	</span>
		</p>
	<!--/div-->
	<div id='form_anexos_content' class="alert alert-warning"><?=@$frm_anexos?></div>
</div>  
<div id="tab-anexos-solicitud" class="ui-widget-content ui-corner-all" hidden="hidden">
	<div class="ui-widget-header ui-corner-all textLarge">Evidencia de solicitud</div>
	<div  class="alert alert-warning" role="alert">
		<p>
			<img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> Evidencias relacionadas a los bienes de esta <b>solicitud de alta</b>.  	
		</p><br/>
		<p>
			<b>NOTAS: </b> <span>
			<ul>
				<li> Presione en la <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> para eliminar la evidencia.</li>
				<li> Si no aparece la <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>, entonces la evidencia está relacionada a algún(algunos) bien(es).</li>
				<li> Presione encima de la imagen para descargar la evidencia.</li>
			</ul>
		</span>
		</p>
	</div>
	<div id="tab-anexos-solicitud-content" style="overflow:auto;width:auto;text-align:center;"  class="well well-sm">

		<?php if( !empty($listado_anexos_solicitud) ) {?>
		<?php foreach ($listado_anexos_solicitud as $a) { ?>
			<div>
				<?php if ($a->IdBien == null) { ?>
				<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onClick="confEliminarAnexos('<?=$a->IdAnexo?>','<?=$a->NoFacturaAnexo?>')">
					<span class="glyphicon glyphicon-remove" aria-hidden="true" title="Eliminar"></span>
				</button>
				<?php } ?>
				<a target="_blank" href="<?=INDEX_CP.$a->UbicacionAnexo.$a->NombreAnexo.$a->ExtensionAnexo?>" download>

					<?php $srcImg = "";
					switch ($a->ExtensionAnexo) {
						case '.pdf':case '.PDF':
							$srcImg = INDEX_CP."resources/images/pdf_icono.png";
							break;
						case '.xml':case '.XML':
							$srcImg = INDEX_CP."resources/images/xml_icono.png";
							break;
						default:
							$srcImg = INDEX_CP.$a->UbicacionAnexo.$a->NombreAnexo.$a->ExtensionAnexo;
							break;
					}
					?>
					<img src="<?=$srcImg?>" width="80px"/>
				</a>
				<div><b>Factura:</b><?=$a->NoFacturaAnexo?></div>																	
			</div>
		<?php } ?>
		<?php } else { ?>
		<span class="textLarge">No hay evidencias agregadas</span>
		<?php } ?>
	</div>	
</div>

<table id="tablaListadoAlta"></table>
<div id="paginacion"></div>
<a href="#" id="iconoG3" class="btn btn-default" title="Mostrar glosario de íconos" style="margin-top:5px !important; margin-bottom:0px !important">Ver glosario de íconos</a>
<table border="0" cellpadding="0" id="tableIconos3" style="border-top:#CCCCCC solid 1px;font-size: 10px; display:none;margin-top:5px">
    <tbody>
        <tr>        	
            <td><img src="<?php echo INDEX_CP ?>resources/images/editar.png" class='icon24' alt='Editar'></td>
            <td><img src="<?php echo INDEX_CP ?>resources/images/error.png" class='icon24' alt='Eliminar'></td>
            <td><img src="<?php echo INDEX_CP ?>resources/images/refresh.png" class='icon24' alt='Recargar'></td>
        </tr>
        <tr>
            <th>Editar</th>
            <th>Eliminar</th>
            <th>Recargar datos</th>
        </tr>
    </tbody>
</table>
<hr/>
<div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span> Para enviar esta y otras solicitudes a autorización dirigirse al menú de solicitudes: 
	<a href="<?php echo INDEX_CP ?>solicitudes" class="btn btn-xs btn-success"> <img src="<?php echo INDEX_CP ?>resources/images/ico_solicitud.png" class="icon24"> Solicitudes</a>
</div>
</div>
<!-- fin del archivo -->

