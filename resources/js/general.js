var uri = '/controlpatrimonial/';
var def_width = '600px';
var def_height = '400px';
function abrirHref(link, id)
{
	if (id == undefined)
	{
		id='';
	}else{
		id='/'+id;
	}
	if (link != undefined)
	{
		window.location.href = uri + link + id;
	}
	else
	{
		return undefined;
	}
	
}
function enArreglo(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
function diferenciaArreglo(array1, array2){
	var foo = [];
	if ((array1 == undefined)||(array2 == undefined)){ return foo;}
	var i = 0;
	jQuery.grep(array2, function(el) {

    	if (jQuery.inArray(el, array1) == -1) foo.push(el);
    	i++;
	});
	return foo;

}
//MENSAJES UI
function obtenerIconoMensaje(tipo){
	if(tipo == undefined){tipo = 'INFO';}
	switch(tipo){
		case 'WARNING':
			icon = uri+'resources/images/warning.png';
			break;
		case 'ERROR':
			icon = uri+'resources/images/error.png';
			break;
		case 'OK':
			icon = uri+'resources/images/success.png';
			break;
		case 'INFO':
		default:
			icon = uri+'resources/images/info.png';
			break;
	}
	var image = '<img src="'+icon+'" alt="'+tipo+'" class="icon24"> ';
	return image;
}
function mensaje(titulo, mensaje, tipo){
	if(titulo == undefined){titulo = '';}
	if(mensaje == undefined){mensaje = '';}
	var image = obtenerIconoMensaje(tipo);
	$("#dialog_aviso .aviso1").html( image + titulo );
	$("#dialog_aviso .aviso2").html( mensaje );
	$( "#dialog_aviso" ).dialog("open");
}
function pregunta(titulo, mensaje, tipo, funcion, args){
	if(titulo == undefined){titulo = '';}
	if(mensaje == undefined){mensaje = '';}
	if(funcion == undefined){ return undefined;}
	var image = obtenerIconoMensaje(tipo);
	$("#dialog_pregunta .pregunta1").html( image + titulo );
	$("#dialog_pregunta .pregunta2").html( mensaje );
	$("#dialog_pregunta").dialog({
		buttons: [{ 
			text: "Aceptar", 
			click: function() { 
				window[funcion](args);
				$(this).dialog("close");
			}
		},{ 
			text: "Cancelar", 
			click: function() { 
				$(this).dialog("close");
			}
		}]
	});
	$( "#dialog_pregunta" ).dialog("open");
}
function preguntaConCancelar(titulo, mensaje, tipo, funcion, args, funcion2, args2){
	if(titulo == undefined){titulo = '';}
	if(mensaje == undefined){mensaje = '';}
	if(funcion == undefined){ return undefined;}
	var image = obtenerIconoMensaje(tipo);
	$("#dialog_pregunta .pregunta1").html( image + titulo );
	$("#dialog_pregunta .pregunta2").html( mensaje );
	$("#dialog_pregunta").dialog({
		buttons: [{ 
			text: "Aceptar", 
			click: function() { 
				window[funcion](args);
				$(this).dialog("close");
			}
		},{ 
			text: "Cancelar", 
			click: function() {
			 	window[funcion2](args2);
				$(this).dialog("close");
			}
		}],
	});
	$( "#dialog_pregunta" ).dialog("open");
}
function pregunta_input(titulo, mensaje, tipo, input , funcion){
	if(titulo == undefined){titulo = '';}
	if(mensaje == undefined){mensaje = '';}
	if(input == undefined){ return undefined;}
	if(funcion == undefined){ return undefined;}
	var image = obtenerIconoMensaje(tipo);

	$("#dialog_pregunta .pregunta1").html( image + titulo );
	$("#dialog_pregunta .pregunta2").html( mensaje );
	$("#dialog_pregunta").dialog({
		buttons: [{ 
			text: "Aceptar", 
			click: function() { 
				var valor = $("#"+input).val();
				if(String(valor) == ''){ window["mensaje"]("Por favor complete los datos solicitados.", "", "WARNING"); return undefined;}
				window[funcion](valor);
				$(this).dialog("close");
			}
		},{ 
			text: "Cancelar", 
			click: function() { 
				$(this).dialog("close");
			}
		}]
	});
	$( "#dialog_pregunta" ).dialog("open");
}

function pregunta_formulario(titulo, contenido, tipo, funcionForm, nombreForm ){
	if(titulo == undefined){titulo = '';}
	if(contenido == undefined){mensaje = '';}
	if(nombreForm == undefined){ return undefined;}
	if(funcionForm == undefined){ return undefined;}
	var image = obtenerIconoMensaje(tipo);

	$("#dialog_pregunta .pregunta1").html( image + titulo );
	$("#dialog_pregunta .pregunta2").html( contenido );
	$("#dialog_pregunta").dialog({
		buttons: [{ 
			id:"Guardar",
			text: "Guardar", 
			click: function() { 
				var resFcn = window[funcionForm](nombreForm); //función que valida ese formulario
				if(!resFcn){ 
					return undefined;
				}else{
					window["mensaje"]("Datos guardados correctamente.", "", "OK"); 
					$(this).dialog("close");	
				}
				
				
			}
		},{ 
			text: "Cancelar", 
			click: function() { 
				$(this).dialog("close");
			}
		}]
	});
	$( "#dialog_pregunta" ).dialog("open");
}
//USA LIBRERIA tinymce
function estiloTextAreaClase(nombreClase, miWidth, miHeight, tiempo, miRead){
	if (nombreClase == undefined){return undefined;}
	else{
		nombreBase = 'textarea.'+nombreClase;	
	}
	if (miWidth == undefined){
		miWidth = def_width;
	}
	if (miHeight == undefined){
		miHeight = def_height;
	}
	if (tiempo == undefined){
		tiempo = 500;
	}
	if (miRead == undefined){
		miRead = false;
	}
	
	
	setTimeout(function(){
		tinymce.init({
		    selector: nombreBase,
		    theme: "modern",
		    width: miWidth,
		    height: miHeight,
		    language : "es",
		    relative_urls: false,
		    remove_script_host: false,
		    readonly : miRead,
		    plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
		         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		         "save table contextmenu directionality emoticons template paste textcolor"
		   ],
		   //toolbar1: "bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink image | inserttime preview | forecolor backcolor | table | hr removeformat | subscript superscript | charmap emoticons | fullscreen | ltr rtl |  visualchars visualblocks template",
           toolbar1: "bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink image | inserttime preview | forecolor backcolor | table | hr removeformat | subscript superscript | charmap emoticons | fullscreen ",

		   style_formats: [
		        {title: 'Bold text', inline: 'b'},
		        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		        {title: 'Example 1', inline: 'span', classes: 'example1'},
		        {title: 'Example 2', inline: 'span', classes: 'example2'},
		        {title: 'Table styles'},
		        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		    ]
		 }); 
	}, tiempo);
}

$( document ).ready(function() {
    $("#loadData").hide(); //ESCONDE LA BARRA DE CARGA
    $( document ).tooltip(); //ACTIVA LOS TOOLTIPS
    //DIALOGS!!
   	$( "#dialog_aviso" ).dialog({
   		height: 'auto',
		width: 'auto',
		maxWidth: '446px',		
		resizable: false,
		draggable: false,
        autoOpen: false,
        modal: true,
        draggable: true,
        buttons: [{ 
            text: "Cerrar", 
            click: function() { 
                $( this ).dialog( "close" );
            }
            }],
	        close: function() {
	        	$("#dialog_aviso .aviso1").html('');
	        	$("#dialog_aviso .aviso2").html('');
     	  }
	});
   	
	$( "#dialog_pregunta" ).dialog({
   		height: 'auto',
		width: 'auto',
		maxWidth: '500px',
		fluid: false, //new option
		resizable: false,
		draggable: false,
        autoOpen: false,
        modal: true,
        dialogClass:'estilo_dialog_edit',
        draggable: true,
	        close: function() {
	        	$("#dialog_pregunta .pregunta1").html('');
	        	$("#dialog_pregunta .pregunta2").html('');
	        	$( "#dialog_pregunta" ).dialog({
						width: 'auto'
					});
     	  }
	});
	
	$('a[href="ReporteControlPatrimonial"]').click(function(e) {
        e.preventDefault();
		var t = $(this);
		$("#loadData").show();
		$(t).html('<img src="/resources/images/load_transparent.gif" width="25" style="margin-top: -4px;margin-right: 10px;">Generando Reporte, por favor espere...');
		$.get( uri + "ReporteControlPatrimonial", function( data ) {
			window.location.href =  uri + "descargar_reporte/"+data;
			$(t).html('<span class="glyphicon glyphicon-list"></span> Reporte <b>Listado de Bienes</b>');
			$("#loadData").hide();
		});
    });
	$('a[href="ReporteBienesVerificacion"]').click(function(e) {
        e.preventDefault();
		$("#loadData").show();
		var t = $(this);
		$(t).html('<img src="/resources/images/load_transparent.gif" width="25" style="margin-top: -4px;margin-right: 10px;">Generando Reporte, por favor espere...');
		$.get( uri + "ReporteBienesVerificacion", function( data ) {
			window.location.href =  uri + "descargar_reporte/"+data;
			$(t).html('<span class="glyphicon glyphicon-list"></span> Reporte de <b>Bienes</b> para verificación');
			$("#loadData").hide();
		});
    });
	$('a[href="ReporteBienesVerificacion2"]').click(function(e) {
        e.preventDefault();
		$("#loadData").show();
		var t = $(this);
		$(t).html('<img src="/resources/images/load_transparent.gif" width="25" style="margin-top: -4px;margin-right: 10px;">Generando Reporte, por favor espere...');
		$.get( uri + "ReporteBienesVerificacion", function( data ) {
			window.location.href =  uri + "descargar_reporte/"+data;
			$(t).html('<span class="glyphicon glyphicon-list"></span> Reporte de <b>Verificación de Bienes</b>');
			$("#loadData").hide();
		});
    });
	
});