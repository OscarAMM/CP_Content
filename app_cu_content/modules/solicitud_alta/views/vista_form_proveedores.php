<?php
	$label_atributos = array("class" => "col-sm-2 control-label");	
	$input_proveedor_rfc = array(
			"name" 		=> "RfcProveedor",
			"id"		=> "rfc_input",
			"maxlength"	=> "13",
			"size"		=> "50",
			"class"		=> "form-control",
			"value"		=> set_value("RfcProveedor",@$datos_proveedor[0]->RfcProveedor,""),
			"oninput" 	=> "validarInput(this)"
			
		);
	$input_proveedor_nombre = array(
			"name" 		=> "NombreProveedor",
			"id"		=> "NombreProveedor",
			"maxlength"	=> "255",			
			"size"		=> "50",
			"class"		=> "form-control",
			"value"		=> set_value("NombreProveedor",@$datos_proveedor[0]->NombreProveedor,"")
		);
	$input_proveedor_direccion = array(
			"name"		=> "DireccionProveedor",
			"id"		=> "DireccionProveedor",
			"maxlength" => "255",
			"size"		=> "50",
			"class"		=> "form-control",
			"value"		=> set_value("DireccionProveedor",@$datos_proveedor[0]->DireccionProveedor,"")
		);
	$input_proveedor_telefono = array(
			"name"		=> "TelefonoProveedor",
			"id"		=> "TelefonoProveedor",
			"maxlength" => "100",
			"size"		=> "50",
			"class"		=> "form-control",
			"value"		=> set_value("TelefonoProveedor",@$datos_proveedor[0]->TelefonoProveedor,"")
		);	
?>
<style>
#resultado {
    background-color: white;
    color: black;
    font-weight: bold;
}
#resultado.ok {
    background-color: green;
	color:white;
}
#resultado.none{
	background-color:orange;
	color: black;
	font-weight:bold;
}
#resultado.mal{
	background-color:red;
	color: white;
	font-weight:bold;
}
</style>
<script type="text/javascript">
/*
	$(function(){
		$("#rfc_input").prop('disabled', true);
	});*/
	$(document).ready(function(){
		$(':input[type="submit"]').prop('disabled', true);
		$('#rfc_input').keyup(function(){
			if($(this).val() !=''){
				$(':input[type="submit"]').prop('disabled', false);
			}
		});
	});
</script>
<script type="text/javascript">
	$(function() {
		$("#frm_proveedores").on("submit",function(e){
			e.preventDefault();
			$("#token").attr("form","frm_proveedores");
        	
        	$.ajax({				
			    url : uri+"safb_addProv",
			    data : $(this).serializeArray(),
				dataType : "json",
				type: "POST",
				cache: false,
				beforeSend: function(){
						
						$("#loadData").show();
					},
				success: function(data){
					if(data.errores){	
						$("#hdn_dlg_frmProv").html(data.contenido);
						if(data.error_msg != "")
							mensaje(data.error_msg,"Por favor, intente nuevamente","ERROR");
					}		
					else{
						$("#cmb_idProveedor").html(data.cmb_options);					
						$( "#hdn_dlg_frmProv" ).dialog("close");						
					}

					$("#loadData").hide();				   	
				   },
				error: function (){
				   	$("#loadData").hide();				
				   }
			});

			return false;	
		});
	});
</script>
<div  class="alert alert-warning" role="alert">
	<p>
		<img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> Por favor utilice el siguiente formulario para agregar un proveedor.
	</p>
	<p>Evite usar caracteres especiales. El RFC consta de 13 caracteres.</p>
</div>
<form id="frm_proveedores" class="form-horizontal" method="post" action="">
	<div class="form-group">
		<?=form_label("RFC  <span class='error'>*</span>","lbl_rfc",$label_atributos)?>
		<div class="col-sm-10">
			<?=form_input($input_proveedor_rfc)?>
			<div class="error"><?=@$error_rfc?></div>
			<pre id="resultado"></pre>		
		</div>
	</div>
	<div class="form-group">
		<?=form_label("Nombre  <span class='error'>*</span>","lbl_nombre",$label_atributos)?>
		<div class="col-sm-10">
			<?=form_input($input_proveedor_nombre)?>
			<div class="error"><?=@$error_nombre?></div>		
		</div>
	</div>
	<div class="form-group">
		<?=form_label("Dirección","lbl_direccion",$label_atributos)?>
		<div class="col-sm-10">
			<?=form_input($input_proveedor_direccion)?>
			<div class="error"></div>	
		</div>
	</div>
	<div class="form-group">
		<?=form_label("Teléfono","lbl_telefono",$label_atributos)?>
		<div class="col-sm-10">
			<?=form_input($input_proveedor_telefono)?>
			<div class="error"></div>
		</div>
	</div>
</form>
<div class="error">* Campos obligatorios</div><br/>
<?=form_hidden("IdProveedor",set_value("IdProveedor",@$datos_proveedor[0]->IdProveedor))?>
<?=form_hidden("IdUsuario",set_value("IdUsuario",@$datos_proveedor[0]->IdUsuario))?>
<script src="<?php echo INDEX_CP?>resources/js/RFCVerification.js"></script>