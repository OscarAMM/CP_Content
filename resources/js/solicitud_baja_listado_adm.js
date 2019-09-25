var anexosId = '1';
$(document).ready(function(){
	/*LISTADO DE BIENES QUE ACTUALMENTE POSEE EL CCT */
	$("#tablaBienesCCT").jqGrid({
		url: uri+'cargar_bienes_cct',
		postData: {
			"cp_hsh4_tk" : function(){ return ($('#token').val() != "") ? $('#token').val() : "0";},"cct" : function(){ return ($('#claveCT_ADM').val() != "") ? $('#claveCT_ADM').val() : "";},"turno" : function(){ return ($('#turnoCT_ADM').val() != "") ? $('#turnoCT_ADM').val() : "";},
		},
		datatype: 'json',
		mtype: 'POST',
		colNames: ['idBienes', 'Cant.', 'No. Inventarios','Descripcion','Marca','Modelo','Serie', 'Responsable','Fecha Alta','Salida','inventario','Estatus','Estatus'//, 'Detalle'
		],
		colModel: [
			{name:'nIdBienes', index:'nIdBienes', width:'30px', search:false, resizable:false, align:"center", hidden:true, sortable:false},
			{name:'nBienes', index:'nBienes', width:'45px', search:false, resizable:false, align:"left", sortable:true},
			{name:'nInventarios', index:'nInventarios', width:'180px', search:false, resizable:true, align:"center", sortable:true},
			{name:'DescripcionBien', index:'DescripcionBien', width:'250px', search:true,resizable:false, align:"left", sortable:true},
			{name:'MarcaBien', index:'MarcaBien', width:'90px', search:true, resizable:false, align:"center", sortable:true},
			{name:'ModeloBien', index:'ModeloBien', width:'90px', search:true, resizable:false, align:"center", sortable:true},
			{name:'SerieBien', index:'SerieBien', width:'70px', search:true, resizable:false, align:"center", sortable:true},
			{name:'NombreEstadoBien', index:'NombreEstadoBien', width:'100px', search:false, resizable:false, align:"center", sortable:true},
			{name:'FechaCreacion', index:'FechaCreacion', width:'70px', search:false, resizable:false, align:"center", sortable:true},
			{name:'NoSalidaBien', index:'NoSalidaBien', width:'60px', search:false, resizable:false, align:"center", sortable:true},
			{name:'inventario', index:'inventario', width:'100px', search:false, resizable:false, align:"center", hidden:true, sortable:false},
			{name:'estatus', index:'estatus', width:'75px', search:false, resizable:false, align:"left", sortable:true, hidden:true,},
			{name:'action1', index:'action1', width:'100px', align:"center", search:true, resizable:false, sortable:false, "stype":"select","searchoptions":{"value":{"0":"Seleccione","EXISTE":"EXISTE","NO EXISTE":"NO EXISTE"}}}
		],
		gridComplete: function() {
			_totfilas =  $("#tablaBienesCCT").getGridParam("reccount");
			var gridx = $("#tablaBienesCCT");
			var ids = gridx.jqGrid('getDataIDs');

			for (var i = 0; i < ids.length; i++)
			{
				
				var rowId = ids[i];
				var ret = $("#tablaBienesCCT").getRowData(rowId);
				if(ret.estatus == '8'){
					var estatus = '<a href="javascript:;" class="btn btn-xs btn-warning textWhite cursorInactivo" title="No Verificado Director"><span class="glyphicon glyphicon-remove "></span> No Existe</a>';
				}
				else{
					var estatus = '<a href="javascript:;" class="btn btn-xs btn-success textWhite cursorInactivo" title="Verificado Director"><span class="glyphicon glyphicon-ok "></span> Existe</a>';
				}
				
				gridx.jqGrid('setRowData', rowId, {action1: estatus });
			}
		},
		shrinkToFit: false,
		height:'300px',
		gridview:true,
		pager: '#paginacionB',
		rowNum:50,
		rowList:[50,100,150,200],
		sortname: 'idBien',
		sortorder: 'asc',
		viewrecords: true,
		singleSelect:true,
		width: '100%',
		caption: 'Listado bienes en centro de trabajo',
		multiselect: true,
		beforeSelectRow: function(rowId, e){
			jQuery("#tablaBienesCCT").jqGrid('resetSelection');
			return(true);
		}
	}).navGrid('#paginacionB', { view: false, del: false, add: false, edit: false, refresh:true,search:false },
		 {},//opciones edit
		 {}, //opciones del
		 {}
		);
		jQuery("#tablaBienesCCT").jqGrid('filterToolbar');
	/*LISTADO BIENES EN LA SOLICITUD*/
	$("#tablaBajaListado").jqGrid({
		url: uri+'cargar_elementos_solicitud',
		postData: {
			"idSolicitud": function(){ return ($('#idSolicitud').val() != "") ? $('#idSolicitud').val() : "0";}, "cp_hsh4_tk" : function(){ return ($('#token').val() != "") ? $('#token').val() : "0";},
			"cct" : function(){ return ($('#claveCT_ADM').val() != "") ? $('#claveCT_ADM').val() : "";},"turno" : function(){ return ($('#turnoCT_ADM').val() != "") ? $('#turnoCT_ADM').val() : "";},
		},
		datatype: 'json',
		mtype: 'POST',
		colNames: ['idBienes', 'Cant.', 'No. Inventarios','Descripcion','Marca','Modelo','Serie', 'Estado','Motivo Baja','Fecha Alta','Salida', //'Detalle' , 
					'Descartar'],
		colModel: [
			{name:'nIdBienes', index:'nIdBienes', width:'100px', search:false, resizable:false, align:"center", hidden:true, sortable:false},
			{name:'nBienes', index:'nBienes', width:'35px', search:true, resizable:false, align:"left", sortable:true},
			{name:'nInventarios', index:'nInventarios', width:'150px', search:true, resizable:true, align:"center", sortable:true},
			{name:'DescripcionBien', index:'DescripcionBien', width:'250px', search:true,resizable:false, align:"left", sortable:true},
			{name:'MarcaBien', index:'MarcaBien', width:'100px', search:true, resizable:false, align:"center", sortable:true},
			{name:'ModeloBien', index:'ModeloBien', width:'100px', search:true, resizable:false, align:"center", sortable:true},
			{name:'SerieBien', index:'SerieBien', width:'100px', search:true, resizable:false, align:"center", sortable:true},
			{name:'NombreEstadoBien', index:'NombreEstadoBien', width:'100px', search:true, resizable:false, align:"center", sortable:true},
			{name:'NombreMotivo', index:'NombreMotivo', width:'100px', search:true, resizable:false, align:"center", sortable:true},
			{name:'FechaCreacion', index:'FechaCreacion', width:'70px', search:false, resizable:false, align:"center", sortable:false},
			{name:'NoSalidaBien', index:'NoSalidaBien', width:'60px', search:false, resizable:false, align:"center", sortable:false},
			//{name:'action1', index:'action1', width:'70px', align:"center", search:false, resizable:false, sortable:false},
			{name:'action2', index:'action2', width:'70px', align:"center", search:false, resizable:false, sortable:false}
		],
		gridComplete: function() {
			_totfilas =  $("#tablaBajaListado").getGridParam("reccount");
			var gridx = $("#tablaBajaListado");
			var ids = gridx.jqGrid('getDataIDs');
			for (var i = 0; i < ids.length; i++)
			{
				var rowId = ids[i];
				var ret = $("#tablaBajaListado").getRowData(rowId);
				var VistaP = "<div class='btn_jqgrid btn btn-default' title='Detalle' onclick=\"vistaPreviaBien('"+ ret.nIdBienes +"');\"><img src='"+uri+"resources/images/zoom.png' class='icon24' alt='Vista p'/> </div>";
				var Descartar = "<div class='btn_jqgrid btn btn-default' title='Descartar bien' onclick=\"confirmaDescartarBien('"+ ret.nIdBienes +"');\"><img src='"+uri+"resources/images/error.png' class='icon24' alt='Descartar'/></div>";
				gridx.jqGrid('setRowData', rowId, {action1: VistaP, action2: Descartar });
			}
		},
		shrinkToFit: false,
		height:'400px',
		gridview:true,
		pager: '#paginacion',
		rowNum:50,
		rowList:[50,100,150,200],
		sortname: 'idBien',
		sortorder: 'asc',
		viewrecords: true,
		singleSelect:true,
		width: '100%',
		caption: 'Listado bienes en solicitud',
		multiselect: false,
		beforeSelectRow: function(rowid, e)
		{		   
		   $("#tablaBajaListado").jqGrid('resetSelection');
		   return(true);
		} 
	}).navGrid('#paginacion', { view: false, del: false, add: false, edit: false, refresh:true,search:false },
		 {},//opciones edit
		 {}, //opciones del
		 {}
		);
	
	$("DIV.ui-pg-div SPAN.ui-icon-refresh").removeClass("ui-icon-refresh").addClass("refresh_btn");
	$("DIV.ui-pg-div SPAN.ui-icon-pencil").removeClass("ui-icon-pencil").addClass("icono_vacio");

	$("#iconoG3").click( function(){
		$("#tableIconos3").toggle();
		return false;
   });
});

function confirmaDescartarBien(bienes){
	if( (bienes == "")||(bienes == undefined) ) {return undefined;}
	pregunta("Descartar bienes de la solicitud", "¿Desea eliminar la selección del grupo de bienes a dar de baja?", "INFO", "descartarBien", bienes);
}
function descartarBien(bienesIds){
	////console.log("Eliminar "+bienesIds);
	$.ajax({
	    url : uri + "eliminarBienesSolicitud",
	    data : {'datos' : bienesIds ,'cp_hsh4_tk' : $("#token").val(),'IdSolicitud' : $("#idSolicitud").val()},
		dataType : "json",
		cache: false,
		type: "POST",
			beforeSend: function(){$("#loadData").show();},
			success: function(data){	
					$("#loadData").hide();
					////console.log(data);
					mensaje(data.msn, '', data.tipo);
			 		////console.log(data.msn);
					$('#tablaBienesCCT').trigger( 'reloadGrid' );
					$('#tablaBajaListado').trigger( 'reloadGrid' );
					
					/*if(data.STATUS){
						$( "#dialog_pregunta" ).dialog({ width: '90%' }); //
						////console.log(data.HTML);
						pregunta_formulario('Listado bienes seleccionados para baja', data.HTML, 'info', 'validarIncluirBienes', 'incluirBienes');
						$("#dialog_pregunta").css('overflow','visible');
						$(".ui-dialog").css('overflow','visible');

					}else{
						mensaje('Mostrar información bienes', 'Ocurrió un error al mostrar los detalles de los bienes seleccionados,por favor recarge la página e intente de nuevo.', 'ERROR');
					}*/
			    	
			    },
			error: function (){
					$("#loadData").hide();
					mensaje('No se pudo eliminar.', 'Ocurrió un error al tratar de eliminar,por favor recarge la página e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR ELIMINAR BIENES BAJA");
			    }
		});
}
function menuIncluirBien(){
	var bienesIds; var res = {};
	bienesIds = jQuery("#tablaBienesCCT").jqGrid('getGridParam','selarrrow');
	if (bienesIds.length > 0)	{
		$.each(bienesIds, function(index,val ) {res[index] = jQuery("#tablaBienesCCT").jqGrid('getRowData',val);});
		$.ajax({
	    url : uri + "ajax/detalles_incluir_bienes",
	    data : {'datosBienes' : res ,'cp_hsh4_tk' : $("#token").val(),'IdSolicitud' : $("#idSolicitud").val()},
		dataType : "json",
		cache: false,
		type: "POST",
			beforeSend: function(){ $("#loadData").show();	},
			success: function(data){	
					$("#loadData").hide();
					////console.log(data);
					if(data.STATUS){
						$( "#dialog_pregunta" ).dialog({ width: '95%'}); //
						////console.log(data.HTML);
						pregunta_formulario('Listado bienes seleccionados para baja', data.HTML, 'info', 'validarIncluirBienes', 'incluirBienes');
						$("#dialog_pregunta").css('overflow','visible');
						$(".ui-dialog").css('overflow','visible');
//						$('#dialog_pregunta').dialog("option", "position", {my: "center", at: "center", of: window});

					}else{
						mensaje('Mostrar información bienes', 'Ocurrió un error al mostrar los detalles de los bienes seleccionados,por favor recarge la página e intente de nuevo.', 'ERROR');
					}
			    	
			    },
			error: function (){
					$("#loadData").hide();
					mensaje('Mostrar información bienes', 'Ocurrió un error al mostrar los detalles de los bienes seleccionados,por favor recarge la página e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR GUARDAR SISTMAS");
			    }
		});

	} else { return undefined; }
	////console.log(res);
}

function incluirBien(){

}

function validarIncluirBienes(nombreForm){
	if (nombreForm == undefined){ mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}
	var nRows = $('#iBienes tr').length;
	var oForm = document.forms[nombreForm];
	if (oForm == undefined) { mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}
	if(nRows < 1){ mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}

	//GAC-TEST
	$(".ui-dialog").hide();
	
	var dataAnexos = new FormData();
	var datosTotal = {};
	var datosTemp = [];
	var n= 1; var alt = false;
	//N. BIENES
	$(oForm.elements['nIdBienes[]']).each(function(index, value) { 
	    ////console.log('div' + index + ':' + $(this).val()); 
	   if(($(this).val()=='')||($(this).val()<= 0)){ mensaje('Error en formulario', 'Por favor <b>seleccione los bienes que desea de dar de baja</b>. Debe de seleccionar al menos uno.', 'ERROR');alt=true;return false;}
	    datosTemp.push($(this).val());
	    n++;
	});
	datosTotal['nBienes_s'] = datosTemp;
	
	datosTotal['nBienes'] = datosTemp;
	var datosTemp = [];n= 1;
	
	//EDO. BIENES
	$(oForm.elements['edoBien[]']).each(function(index, value) { 
	    ////console.log('edo' + index + ':' + $(this).val()); 
	    if(($(this).val()=='')||($(this).val() == 0)){ mensaje('Error en formulario', 'Por favor verifique los campo de <b>estado del bien</b>. Debe de seleccionar al menos un estado.', 'ERROR'); alt = true; return false; }
	    datosTemp.push($(this).val());
	    n++;
	});
	if(alt){return false;}
	if(parseInt(n) != parseInt(nRows+1)){ mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}
	datosTotal['edoBien'] = datosTemp;
	var datosTemp = [];n= 1;
	
	//MOTIVO MOVIMIENTO
	$(oForm.elements['motMov[]']).each(function(index, value) { 
	    ////console.log('div' + index + ':' + $(this).val()); 
	    if(($(this).val() == '')||($(this).val() == 0) ){ mensaje('Error en formulario', 'Por favor verifique los campo del <b>motivo del movimiento</b>. Debe de seleccionar al menos un motivo.', 'ERROR'); alt = true; return false; }
	    datosTemp.push($(this).val());
	    n++;
	});
	if(alt){return false;}
	if(parseInt(n) != parseInt(nRows+1)){ mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}
	datosTotal['motMov'] = datosTemp;
	//var datosTemp = [];

	//ANEXO BIENES VALIDA
	n = 1;
	var datosTemp = [];
	$(oForm.elements['anexos[]']).each(function(indexA, value) { 
	    ////console.log('ANX' + indexA + ':' + $(this).val()); 
	    if( $(this).val() == null){
	   		n++;
	    }
		else{
			datosTemp.push($(this).val());
			//datosTotal['anexos'] =$(this).val()+",";
		}
	});
	if(parseInt(n)>1){mensaje('Error en formulario', 'Por favor verifique los campo del <b>Anexo</b>. Debe de seleccionar al menos uno.', 'ERROR'); return false;}
	datosTotal['anexos'] = datosTemp;
	//datosTotal['anexos_s'] = $('nIdBienes[]').val();
	var idSolicitud = $("#idSolicitud").val(); 
	if(idSolicitud == ''){ 
		mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;

	}
	datosTotal['idSolicitud'] = idSolicitud;
	datosTotal['cct'] = $("#claveCT_ADM").val();
	datosTotal['turno'] = $("#turnoCT_ADM").val();
	
	////console.log(datosTotal);
	guardarBaja(datosTotal);
	
	return false;
}

function eliminar_anexo2(t){
	pregunta('Desea Eliminar el Anexo?', '', 'ERROR', 'eliminar_anexo', t);
};
function eliminar_anexo(t){
	var dataAnexos = new FormData();
	var idAnexo =  $(t).attr('rel');
	dataAnexos.append('idAnexo', idAnexo);
	dataAnexos.append('cp_hsh4_tk', $("#token").val());
	var idSolicitud = $("#idSolicitud").val(); 
	$.ajax({
	    url : uri + "eliminarAnexo",
	    data :  dataAnexos,
		contentType: false,
    	processData: false,
		cache: false,
		type: "POST",
			beforeSend: function(){ $("#loadData").show();	},
			success: function(data){	
					$("#loadData").hide();
					//data = $.parseJSON(data);
					////console.log(data);
					if(data == '1')
						mensaje('Se Elimino Correctamente','', 'ERROR');
					else
						mensaje('Ocurrio un Erro. Por favor actualice la página e intente nuevamente','', 'ERROR');
					$.get( uri + "obtenerAnexos/"+idSolicitud, function( data ) {
						$( ".anexos" ).html( data );
					});
			    },
			error: function (){
					$("#loadData").hide();
					mensaje('Mostrar información bienes', 'Ocurrió un error al subir los archivos de anexos seleccionados,por favor recarge los archivos e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR GUARDAR ANEXOS - BAJAS");
			}
	});
}

function guardarAnexoIncluirBien(dataAnexos){
	dataAnexos.append('cp_hsh4_tk', $("#token").val());
	var idSolicitud = $("#idSolicitud").val(); if(idSolicitud == ''){ mensaje('Aviso sistema', 'Ocurrió un error en el formulario. Por favor actualice la página e intente nuevamente', 'ERROR'); return false;}
	dataAnexos.append('idSolicitud', idSolicitud);
	
	$.ajax({
	    url : uri + "ajax/guardar_incluir_bienes",
	    data :  dataAnexos ,
		contentType: false,
    	processData: false,
		cache: false,
		type: "POST",
			beforeSend: function(){ $("#loadData").show();	},
			success: function(data){	
					$("#loadData").hide();
					////console.log(data);
			    },
			error: function (){
					$("#loadData").hide();
					mensaje('Mostrar información bienes', 'Ocurrió un error al subir los archivos de anexos seleccionados,por favor recarge los archivos e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR GUARDAR ANEXOS - BAJAS");
			    }
		});
}
function guardarBaja(datosTotal){
	$.ajax({
	    url : uri + "guardar_baja_bienes",
	    data : {'datosTotal' : datosTotal ,'cp_hsh4_tk' : $("#token").val()},
		dataType : "json",
		cache: false,
		type: "POST",
			beforeSend: function(){ $("#loadData").show();	},
			success: function(data){	
					$("#loadData").hide();
					////console.log(data);
					$('#tablaBienesCCT').trigger( 'reloadGrid' );
					$('#tablaBajaListado').trigger( 'reloadGrid' );
					$("#dialog_pregunta").dialog( "close" );
					mensaje('Datos Guardados Exitosamente.', '', 'SUCCESS');

			    },
			error: function (){
					$("#loadData").hide();
					mensaje('Error al Guardar los Datos', 'Ocurrió un error al tratar de guardar los datos,por favor recarge la página e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR GUARDAR SISTMAS");
			    }
		});
}
function guardarIncluirBien(datosTotal,dataAnexos){
	$.ajax({
	    url : uri + "ajax/guardar_incluir_bienes",
	    data : {'datosFile' : dataAnexos ,'datosTotal' : datosTotal ,'cp_hsh4_tk' : $("#token").val()},
		dataType : "json",
		cache: false,
		type: "POST",
			beforeSend: function(){ $("#loadData").show();	},
			success: function(data){	
					$("#loadData").hide();
					////console.log(data);


			    },
			error: function (){
					$("#loadData").hide();
				//	mensaje('Mostrar información bienes', 'Ocurrió un error al mostrar los detalles de los bienes seleccionados,por favor recarge la página e intente de nuevo.', 'ERROR');
			 		////console.log("ERROR GUARDAR SISTMAS");
			    }
		});
}

function editar_telefono(accion){
	if(accion == "Habilitar"){
		sAccion = "Guardar";
		$("#txt_tel_sol").removeAttr("disabled");
		$("#txt_tel_sol2").removeAttr("disabled");
		$("#btn_icon_editTel").removeClass("glyphicon-pencil");
		$("#btn_icon_editTel").addClass("glyphicon-ok");
		$("#btn_editTel").attr("onclick","editar_telefono('Guardar')");
		$("#btn_editTel").attr("title","Guardar teléfono");
	}		
	if(accion == "Guardar"){
		$.ajax({				
			url : uri+"baja_edittelsol",
			data : { 'cp_hsh4_tk': $("#token").val(), 'idSolicitud': $("#idSolicitud").val(), 'tel': $("#txt_tel_sol").val(),'tel2': $("#txt_tel_sol2").val() ,'correo': $("#txt_correo_sol").val(),_c : 0},
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
				},
			success: function(data){										
				if(data.errores){ mensaje("ERROR! " + data.error_msg, "", "ERROR"); }
				else { 
					$("#txt_tel_sol").attr("disabled","disabled");
					$("#txt_tel_sol2").attr("disabled","disabled");
					$("#btn_icon_editTel").removeClass("glyphicon-ok");
					$("#btn_icon_editTel").addClass("glyphicon-pencil");
					$("#btn_editTel").attr("onclick","editar_telefono('Habilitar')");
					$("#btn_editTel").attr("title","Editar teléfono");
				}				
				$("#loadData").hide();		   	
			   },
			error: function (jqXHR, textStatus,errorThrown){
				$("#loadData").hide();				
			   }
		});
	}
}
function isValidEmailAddress(emailAddress) {
	if(emailAddress != "" && emailAddress != null)
	{
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	}
	return true;
};

function editar_correo(accion){
	if(accion == "Habilitar"){
		sAccion = "Guardar";
		$("#txt_correo_sol").removeAttr("disabled");
		$("#btn_icon_editCorreo").removeClass("glyphicon-pencil");
		$("#btn_icon_editCorreo").addClass("glyphicon-ok");
		$("#btn_editCorreo").attr("onclick","editar_correo('Guardar')");
		$("#btn_editCorreo").attr("title","Guardar teléfono");
	}		
	if(accion == "Guardar"){
		if( !isValidEmailAddress( $("#txt_correo_sol").val() ) ) {
			mensaje("ERROR! El correo electrónico no es válido","", "ERROR");
			return false;
		}
		$.ajax({				
			url : uri+"baja_editcorreosol",
			data : { 'cp_hsh4_tk': $("#token").val(), 'idSolicitud': $("#idSolicitud").val(), 'correo': $("#txt_correo_sol").val(),  'tel': $("#txt_tel_sol").val(),'tel2': $("#txt_tel_sol2").val(),_c : 1},
			dataType : "json",
			type: "POST",
			cache: false,
			beforeSend: function(){
					$("#loadData").show();
				},
			success: function(data){										
				if(data.errores){ mensaje("ERROR! " + data.error_msg, "", "ERROR"); }
				else { 
					$("#txt_correo_sol").attr("disabled","disabled");
					$("#btn_icon_editCorreo").removeClass("glyphicon-ok");
					$("#btn_icon_editCorreo").addClass("glyphicon-pencil");
					$("#btn_editCorreo").attr("onclick","editar_telefono('Habilitar')");
					$("#btn_editCorreo").attr("title","Editar teléfono");
				}				
				$("#loadData").hide();		   	
			   },
			error: function (jqXHR, textStatus,errorThrown){
				$("#loadData").hide();				
			   }
		});
	}
}
function mostrar_articulos(val){
	if(val == 3){
		$('#cim_').removeAttr('hidden');
	}
	else{
		$('#cim_').attr('hidden','hidden');
	}
}
$('#btn_can_alta_bien').click(function(e) {
    $('.form-control').val('');
	$('select').val(0);
});
$("#frm_alta_guarda_bien").submit(function(e){
	e.preventDefault();
	
	$('div.error').html('');
	n = 0;
	if($.trim($('#imp').val()) == ''){
		mensaje('Error al tratar de Guardar', 'Ocurrió un error al tratar de guardar los datos,por favor recarge la página e intente de nuevo.', 'ERROR');
		return false;
	}
	if($.trim($('#input_cantidad').val()) == '' || parseInt($.trim($('#input_cantidad').val())) <= 0 ){
		$('#input_cantidad').parent().children('.error').html('El campo <b>Cantidad</b> es obligatorio y debe de ser<b> mayor a 0</b>.');
		n++;
	}
	if($.trim($('#DescripcionBien').val()) == ''){
		$('#DescripcionBien').parent().children('.error').html('El campo <b>Descripcion</b> es obligatorio.');
		n++;
	}
	if($.trim($('#MarcaBien').val()) == ''){
		$('#MarcaBien').parent().children('.error').html('El campo <b>Marca</b> es obligatorio.');
		n++;
	}
	if($.trim($('#ModeloBien').val()) == ''){
		$('#ModeloBien').parent().children('.error').html('El campo <b>Modelo</b> es obligatorio.');
		n++;
	}
	if($.trim($('#SerieBien').val()) == ''){
		$('#SerieBien').parent().children('.error').html('El campo <b>Serie</b> es obligatorio.');
		n++;
	}
	if($.trim($('#IdEstadoBien').val()) == 0){
		$('#IdEstadoBien').parent().children('.error').html('El campo <b>Estado físico</b> es obligatorio seleccionar uno.');
		n++;
	}
	if($.trim($('#IdTipoBien').val()) == 0){
		$('#IdTipoBien').parent().children('.error').html('El campo <b>Tipo bien</b> es obligatorio seleccionar uno.');
		n++;
	}
	if($.trim($('#IdTipoBien').val()) == 3){
		if($.trim($('#cmb_articulo').val()) == 0){
			$('#cmb_articulo').parent().children('.error').html('El campo <b>Tipo de Mobiliario</b> es obligatorio seleccionar uno.');
			n++;
		}
	}	
	if($.trim($('#IdMotivoMovimiento').val()) == 0){
		$('#IdMotivoMovimiento').parent().children('.error').html('El campo <b>Motivo</b> es obligatorio seleccionar uno.');
		n++;
	}
	if($.trim($('#anexos_alta').val()) == 0){
		$('#anexos_alta').parent().children('.error').html('El campo <b>Anexos</b> es obligatorio seleccionar almenos uno.');
		n++;
	}
	if(n> 0){
		if($.trim($('#anexos_alta').val()) == 0){$('#anexos_alta').focus();}
		if($.trim($('#IdMotivoMovimiento').val()) == 0){$('#IdMotivoMovimiento').focus();}
		if($.trim($('#IdTipoBien').val()) == 3){if($.trim($('#cmb_articulo').val()) == 0){$('#cmb_articulo').focus();}}	
		if($.trim($('#IdTipoBien').val()) == 0){$('#IdTipoBien').focus();}
		if($.trim($('#IdEstadoBien').val()) == 0){$('#IdEstadoBien').focus();}
		if($.trim($('#SerieBien').val()) == ''){$('#SerieBien').focus();}
		if($.trim($('#ModeloBien').val()) == ''){$('#ModeloBien').focus();}
		if($.trim($('#MarcaBien').val()) == ''){$('#MarcaBien').focus();}				
		if($.trim($('#DescripcionBien').val()) == ''){$('#DescripcionBien').focus();}
		if($.trim($('#input_cantidad').val()) == '' || parseInt($.trim($('#input_cantidad').val())) <= 0 ){$('#input_cantidad').focus();}
		return false;
	}
	
	$.ajax({				
		url : uri+"baja_bien_guardar",
		data : $(this).serializeArray(),
		dataType : "json",
		type: "POST",
		cache: false,
		beforeSend: function(){
				$("#loadData").show();
			},
		success: function(data){
			mensaje(data.msn, '', data.tipo);
			$('.form-control').removeAttr('disabled');
			$('.verifica_chek').attr('checked', false);
			$('.form-control').val('');
			$('select').val(0);
			$("#anexos_alta").val('').trigger("liszt:updated");
			 $('.search-choice-close').trigger('click');
			//$("#anexos_alta").chosen({width:"100%", html_template: '<img style="margin-right: 5px; width: 50px; border: 2px solid black;display:none" class="{class_name}" src="{url}" />'});
			$("#loadData").hide();
			$('#tablaBienesCCT').trigger( 'reloadGrid' );
			$('#tablaBajaListado').trigger( 'reloadGrid' );

		   },
		error: function (){
			$("#loadData").hide();				
		   }
	});	

	return false;	
});