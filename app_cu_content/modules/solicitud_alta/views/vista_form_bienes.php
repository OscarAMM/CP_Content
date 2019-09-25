<link rel="stylesheet" href="<?php echo INDEX_CP; ?>resources/css/chosen.css" />
<script src="<?php echo INDEX_CP; ?>resources/js/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo INDEX_CP; ?>resources/js/image_chosen.js" type="text/javascript"></script>
<script src="<?php echo INDEX_CP; ?>resources/js/solicitud_alta_frmbjs.js" type="text/javascript"></script>
<?php
$label_atributos = array("class" => "col-sm-2 control-label");
$select_atributos = "class='form-control'";

$input_bien_cantidad = array(
    "name" => "input_cantidad",
    "id" => "input_cantidad",
    "maxlength" => "5",
    "class" => "form-control w50",
    "size" => "10",
    "value" => set_value("input_cantidad", (isset($datos_bienes)) ? $datos_bienes[0]->Cantidad : "1"),
);
if (isset($datos_bienes) && $datos_bienes[0]->IdTipoBien == '1') {
    $input_bien_cantidad["readonly"] = "readonly";
}

$input_bien_descripcion = array(
    "name" => "DescripcionBien",
    "id" => "DescripcionBien",
    "maxlength" => "45",
    "class" => "form-control",
    "size" => "50",
    "value" => set_value("DescripcionBien", @$datos_bienes[0]->DescripcionBien, ""),
);
$input_bien_marca = array(
    "name" => "MarcaBien",
    "id" => "MarcaBien",
    "maxlength" => "45",
    "size" => "50",
    "class" => "form-control",
    "value" => set_value("MarcaBien", @$datos_bienes[0]->MarcaBien, ""),
);
$input_bien_modelo = array(
    "name" => "ModeloBien",
    "id" => "ModeloBien",
    "maxlength" => "45",
    "size" => "50",
    "class" => "form-control",
    "value" => set_value("ModeloBien", @$datos_bienes[0]->ModeloBien, ""),
);
$input_bien_serie = array(
    "name" => "SerieBien",
    "id" => "SerieBien",
    "maxlength" => "45",
    "size" => "50",
    "class" => "form-control",
    "value" => set_value("SerieBien", @$datos_bienes[0]->SerieBien, ""),
);
$input_bien_precioUnitario = array(
    "name" => "PrecioUnitario",
    "id" => "PrecioUnitario",
    "size" => "50",
    "class" => "form-control",
    "value" => set_value("PrecioUnitario", (isset($datos_bienes)) ? $datos_bienes[0]->PrecioUnitario : "0"),
);
$input_observaciones = array(
    "name" => "Observaciones",
    "id" => "Observaciones",
    "size" => "50",
    "rows" => "5",
    "class" => "form-control noresize",
    "value" => set_value("Observaciones", (isset($datos_bienes)) ? $datos_bienes[0]->Observaciones : ""),
);
?>

<script type="text/javascript">
$(function() {
    $("#dlg_seleccione_anexos").dialog({
        autoOpen: false,
        height: 400,
        width: 550,
        modal: true,
        buttons: {
            Cancelar: function() {
                $(this).dialog("close");
            },
            Aceptar: function() {
                var anexosIDs = $("#anexosID").val();
                var token = $("#token").val();
                var chk_anexos = $("#safrmb_frm_asol_cont").serialize();

                if (chk_anexos == "") {
                    mensaje("Seleccione al menos una evidencia", "", "ERROR");
                } else {
                    $.ajax({
                        url: uri + "safb_agregaAnexoBien",
                        data: {
                            'anexosIDs': anexosIDs,
                            'cp_hsh4_tk': token,
                            'chk_anexos': chk_anexos,
                            'accion': 'add'
                        },
                        dataType: "json",
                        type: "POST",
                        cache: false,
                        beforeSend: function() {
                            $("#loadData").show();
                        },
                        success: function(data) {
                            $("#safb_lista_anexos").html(data.contenido);
                            $("#loadData").hide();
                            $("#dlg_seleccione_anexos").dialog("close");
                        },
                        error: function() {
                            $("#loadData").hide();
                        }
                    });
                }
            }
        },
        close: function() {
            $("#safrmb_frm_asol_cont").html("");
        }
    });
    $("#hdn_dlg_frmProv").dialog({

        autoOpen: false,
        height: 500,
        width: 600,
        modal: true,
        buttons: [{
                id: "Cancelar",
                text: "Cancelar",
                click: function() {
                    $(this).dialog("close");
                }
            }, {
                id: "Aceptar",
                text: "Aceptar",
                click: function() {
                    $("#frm_proveedores").submit();
                }
            },
            {
                id: "Verificar",
                text: "Verificar",
                click: function() {
                    var RFCInput = $("#rfc_input").val().toUpperCase();
                    if (RFCInput !== '') {
                        var rfc_moral_regex =
                            /^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$/;

                        var rfc_fisico_regex =
                            /^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$/;

                        if (RFCInput.match(rfc_moral_regex) || RFCInput.match(
                            rfc_fisico_regex)) {
                            console.log("MATCH");
                            if (rfc_fisico_regex.test(RFCInput) == true || rfc_moral_regex.test(
                                    RFCInput) == true) {
                                $("#Aceptar").show();
                            }
                            return true;
                        } else {
                            console.log("NOT MATCH");
                            alert("RFC NO VÁLIDO. INGRESE NUEVAMENTE.");
                            $("#Aceptar").hide();
                            return false;
                        }
                    } else {
                        alert("Llenar el campo de RFC.");
                        return false;
                    }
                }
            }
        ],
        close: function() {
            $(this).html("");
        }
        /*{
	        Cancelar: function() {
	          $(this).dialog( "close" );
	        },
	        Aceptar: function() {
	        	$("#frm_proveedores").submit();
			},
			Verificar: function(){
				var RFCInput = $("#rfc_input").val().toUpperCase();
                    if (RFCInput !== '') {
                        var rfc_moral_regex =
                            /^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$/;

                        var rfc_fisico_regex =
                            /^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$/;

                        if (RFCInput.match(rfc_moral_regex) || RFCInput.match(
                            rfc_fisico_regex)) {
                            console.log("MATCH");
                            if (rfc_fisico_regex.test(RFCInput) == true || rfc_moral_regex.test(
                                    RFCInput) == true) {
                                $("#Aceptar").show();
                            }
                            return true;
                        } else {
                            console.log("NOT MATCH");
                            alert("RFC NO VÁLIDO. INGRESE NUEVAMENTE.");
                            $("#Aceptar").hide();
                            return false;
                        }
                    } else {
                        alert("Llenar el campo de RFC.");
                        return false;
                    }
			}
	      },
	      close: function() {
	      	$(this).html("");
	      }*/
    });

    $("#btn_ver_anexos").click(function() {
        var anexosID = $("#anexosID").val();
        var idSolicitud = $("#hdn_IdSolicitud").val();
        var token = $("#token").val();

        $.ajax({
            url: uri + "safb_listaAnexosSol",
            data: {
                'IdSolicitud': idSolicitud,
                'cp_hsh4_tk': token,
                'anexosIDs': anexosID
            },
            dataType: "json",
            type: "POST",
            cache: false,
            beforeSend: function() {
                $("#loadData").show();
            },
            success: function(data) {
                $("#loadData").hide();
                $("#safrmb_frm_asol_cont").html(data.contenido);
                $("#dlg_seleccione_anexos").dialog("open");
            },
            error: function() {
                $("#loadData").hide();
            }
        });
    });

    $("#frm_alta_guarda_bien").submit(function(e) {
        e.preventDefault();

        $("#token").attr("form", "frm_alta_guarda_bien");
        $("#hdn_IdSolicitud").attr("form", "frm_alta_guarda_bien");
        $('input[type="submit"]').prop('disabled', true);

        $.ajax({
            url: uri + "alta_bien_guardar",
            data: $(this).serializeArray(),
            dataType: "json",
            type: "POST",
            cache: false,
            beforeSend: function() {
                $("#loadData").show();
            },
            success: function(data) {
                $("#form_bienes_content").html(data.contenido);
                $("#loadData").hide();
                if (!data.errores) {
                    $("#tab-anexos-solicitud-content").html(data.anexos);
                    $("#btn_can_alta_bien").click();

                    if ($("#tab-form-agregaBien").css("display") != "none")
                        $("#tab-form-agregaBien").toggle("Blind");
                    $("#tablaListadoAlta").jqGrid('setGridParam', {
                        datatype: 'json'
                    }).trigger('reloadGrid');
                } else {
                    $(".error").each(function(index) {
                        if ($(this).text()) {
                            var id = $(this).attr('id');
                            var element_position = $("#" + id).offset().top - 40;
                            $("html, body").animate({
                                scrollTop: element_position + "px"
                            });
                            return false;
                        }
                    });
                }
            },
            error: function() {
                $("#loadData").hide();
            }
        });
        //$('#btn_submit_form_bien').prop('disabled', false);
        return false;
    });

    $("#btn_can_alta_bien").on("click", function() {
        $("#tab-form-agregaBien").css("display", "none");
    });

    $("#btn_add_proveedor").on("click", function() {
        //Verification button
        $("#Aceptar").hide();
        $("pre.resultado").hide();
        //Panel with message

        $.ajax({
            url: uri + "safb_frmprov",
            data: {
                'cp_hsh4_tk': $("#token").val()
            },
            dataType: "json",
            type: "POST",
            cache: false,
            beforeSend: function() {
                $("#loadData").show();
            },
            success: function(data) {
                $("#loadData").hide();
                $("#hdn_dlg_frmProv").html(data.formulario);
                $("#hdn_dlg_frmProv").dialog("open");
            },
            error: function() {
                $("#loadData").hide();
            }
        });
    });
    $("#Verificar").on("click", function() {
        $("pre").show();
    });


    $("#btn_tg_caracteristicas").on("click", function() {
        var css_display = $("#panel_caracteristicas").css("display");
        $("#panel_caracteristicas").toggle("blind");
        if (css_display == "none") {
            $("#btn_tg_caracteristicas span").removeClass("glyphicon-circle-arrow-down");
            $("#btn_tg_caracteristicas span").addClass("glyphicon-circle-arrow-up");
            $("#btn_tg_caracteristicas b").html("Ocultar características");
        } else {
            $("#btn_tg_caracteristicas span").removeClass("glyphicon-circle-arrow-up");
            $("#btn_tg_caracteristicas span").addClass("glyphicon-circle-arrow-down");
            $("#btn_tg_caracteristicas b").html("Mostrar características");
        }

    });

    $("#chk_MarcaBien_NA").prop('checked', ($("#MarcaBien").val().toUpperCase() == "N/A") ? true : false);
    $(
        "#chk_ModeloBien_NA").prop('checked', ($("#ModeloBien").val().toUpperCase() == "N/A") ? true :
        false);
    $(
        "#chk_SerieBien_NA").prop('checked', ($("#SerieBien").val().toUpperCase() == "N/A") ? true : false);

});

function onChangeIdMotivoM(motivo) {
    $.post(uri + "safb_obcmbrecb", {
        'cp_hsh4_tk': $("#token").val(),
        idmotivom: motivo
    }, function(data) {
        $("#IdRecursoBien").html(data);
    });
}

function eliminaAnexo(idAnexo) {
    var anexosIDs = $("#anexosID").val();
    var token = $("#token").val();

    $.ajax({
        url: uri + "safb_agregaAnexoBien",
        data: {
            'anexosIDs': anexosIDs,
            'cp_hsh4_tk': token,
            'del_idAnexo': idAnexo,
            'accion': 'del'
        },
        dataType: "json",
        type: "POST",
        cache: false,
        beforeSend: function() {
            $("#loadData").show();
        },
        success: function(data) {
            $("#safb_lista_anexos").html(data.contenido);
            $("#loadData").hide();
        },
        error: function() {
            $("#loadData").hide();
        }
    });
}

function onChangeTipoBien(idTipoBien) {
    if (idTipoBien == 1)
        $("#input_cantidad").val("1").prop("readonly", true);
    else
        $("#input_cantidad").prop("readonly", false);
}

function mostrar_articulos(idTipoBien) {
    var chkBienCompartido, aResponsables;

    $("#div_cmb_articulo").hide();
    $("#color_oculto").hide();

    $("#cmb_articulo").html("<option value='0'>Seleccione..</option>");

    if (idTipoBien > 0) {
        $.ajax({
            url: uri + "safb_listart",
            data: {
                'cp_hsh4_tk': $("#token").val(),
                'idTipoBien': idTipoBien
            },
            dataType: "json",
            type: "POST",
            cache: false,
            beforeSend: function() {
                $("#loadData").show();
            },
            success: function(data) {
                $("#cmb_articulo").html(data.articulos);

                if (data.cont > 1) {
                    $("#div_cmb_articulo").show();
                    $("#color_oculto").show();
                }

                $("#loadData").hide();
            },
            error: function() {
                $("#cmb_articulo").html("<option value='0'>Seleccione..</option>");
                $("#loadData").hide();
            }
        });
    }

    if (idTipoBien == 3) {
        chkBienCompartido = document.getElementById('BienCompartido');
        aResponsables = document.getElementsByName('responsables[]');
        if (aResponsables.length > 1)
            chkBienCompartido.checked = true;

        for (var i = 0; i < aResponsables.length; i++) {
            aResponsables[i].checked = true;
            //aResponsables[i].disabled = true;
        };
    } else {
        chkBienCompartido = document.getElementById('BienCompartido');
        chkBienCompartido.checked = false;
        aResponsables = document.getElementsByName('responsables[]');
        for (var i = 0; i < aResponsables.length; i++) {
            aResponsables[i].checked = false;
            valor = $(aResponsables[i]).val().split("-");
            if (valor[0] == $('#cct_back').val() && valor[2] == $('#turno_back').val()) {
                aResponsables[i].checked = true;
            }
            console.log($(aResponsables[i]).val());
            //aResponsables[i].disabled = false;
        };
    }
}

function send_form(id_form) {
    $("#" + id_form).submit();
}

function refresh_responsables() {
    $.ajax({
        url: uri + "safb_refreshlistresp",
        data: {
            'cp_hsh4_tk': $("#token").val(),
            'idBien': $("#IdBien").val()
        },
        dataType: "json",
        type: "POST",
        cache: false,
        beforeSend: function() {
            $("#loadData").show();
        },
        success: function(data) {
            $("#panel_responsables").html(data.html);

            if (data.disabled_guardar)
                $("#btn_submit_form_bien").attr("disabled", "disabled");
            else
                $("#btn_submit_form_bien").removeAttr("disabled");

            $("#loadData").hide();
        },
        error: function() {
            $("#loadData").hide();
        }
    });
}

function escribeNA(id) {
    $("#" + id).val($("#chk_" + id + "_NA").is(":checked") ? "N/A" : "");
}
</script>
<style type="text/css">
#safb_lista_anexos {
    height: 100px;
    /*border:solid 1px #aaaaaa;*/
    overflow: auto;
}

#safb_lista_anexos div {
    margin: 2px;
    padding: 1px;
    height: auto;
    width: 88px;
    float: left;
    text-align: center;
}

#safb_lista_anexos div div {
    text-align: center;
    font-weight: normal;
    width: 88px;
    margin: 2px;
    position: bottom;
    padding-left: 5px;
}

#safb_lista_anexos div a img {
    display: inline;
    margin: 2px;
    border: 1px solid #ffffff;
}

#safb_lista_anexos div button {
    border: 0;
    float: left;
}

#btn_add_proveedor {
    border: 0;
}

/*.custom-combobox {
	    position: relative;
	    display: inline-block;
	}*/
.custom-combobox-toggle {
    /*position: absolute;*/
    /*top: 0;*/
    /*bottom: 0;*/
    /*margin-left: -1px;*/
    /*padding: 0;*/
    height: 32px;
    border-left: 0;
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
    width: 16px !important;
}

.custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
    width: 83%;
    font-size: 14px !important;
    display: inline;
    border-right: 0;
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}

.ui-menu {
    height: 300px;
    overflow: auto;
}

.noresize {
    resize: none;

}
</style>
<form id="frm_alta_guarda_bien" class="form-horizontal" name="frm_guarda_anexo" method="post"
    action="alta_bien_guardar">
    <div class="form-group">
        <?=form_label("Tipo  <font color='red'>*</font>", "lbl_tipoBien", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_dropdown("IdTipoBien", $listado_tiposBien, set_value("IdTipoBien", @$datos_bienes[0]->IdTipoBien, "0"), $select_atributos . " onchange='mostrar_articulos(this.value);onChangeTipoBien(this.value)'")?>
            <div id="error_IdTipoBien" class="error"><?=form_error('IdTipoBien')?></div>
        </div>
    </div>
    <div class="form-group" id="div_cmb_articulo" <?=(isset($hidden)) ? $hidden : 'hidden="hidden"'?>>
        <?=form_label("Articulo  <font color='red'>*</font>", "lbl_articulo", $label_atributos)?>
        <div class="col-sm-4">
            <?php $listado_articulos = isset($listado_articulos) ? $listado_articulos : array("0" => "Seleccione");?>
            <?=form_dropdown("articulos", $listado_articulos, set_value("articulos", @$datos_bienes[0]->articulos, "0"), $select_atributos . " id='cmb_articulo'")?>
            <div id="error_articulos" class="error"><?=form_error('articulos')?></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
            <div class="checkbox">
                <label>
                    <?php $checked_BienCompartido = (set_value("BienCompartido", @$datos_bienes[0]->BienCompartido)) ? "checked" : "";?>
                    <input type="checkbox" name="BienCompartido" id="BienCompartido" value="1"
                        <?=$checked_BienCompartido?>> <b>Compartido</b>
                </label>
            </div>
            <div id="error_BienCompartido" class="error"><?=form_error("BienCompartido")?></div>
        </div>
    </div>
    <!-- inicio div responsables -->
    <div class="form_group">
        <?=form_label("Responsables  <font color='red'>*</font>", "lbl_responsables", $label_atributos)?>
        <div class="col-sm-10">
            <?php if ($Plantilla == 1) {?>
            <div class="alert alert-warning"><span>El listado que se muestra a continuación de responsables, es
                    capturada en el sistema de Plantilla de personal. Si desea hacer alguna <b>actualización</b> ó
                    <b>corrección</b> de click al siguiente boton: </span><button type="button" class="btn btn-warning"
                    aria-label="Left Align" onclick="<?=@$btn_sist_ext_click?>">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Plantilla de personal
                </button>
            </div>
            <?php }?>
            <div id="panel_responsables">
                <?php if (!empty($responsables)) {?>
                <?php $disabled_btn_guardar = "";?>
                <?php foreach ($responsables as $r_key => $r_value) {?>
                <div class="checkbox" style="margin:0">
                    <label>
                        <input type="checkbox" name="responsables[]"
                            value="<?=$r_value['ClaveCT'] . '-' . $r_value['RfcDirector'] . '-' . $r_value['iTurno']?>"
                            <?=$r_value['seleccionado']?> <?=$r_value['habilitado']?>
                            <?php if (@$cct == $r_value['ClaveCT'] && @$turno == $r_value['iTurno']) {echo "checked";}?> />
                        <?=$r_value["NombreDirector"] . " (" . $r_value["RfcDirector"] . ")";?>
                        <div>
                            <em><b><small><?=$r_value["ClaveCT"] . " - " . $r_value["NombreCT"] . " (" . $r_value["Turno"] . ")"?></small></b></em>
                        </div>
                    </label>
                </div>
                <?php }?>
                <?php } else {?>
                <?php $disabled_btn_guardar = "disabled"; /*?>
                <button type="button" class="btn btn-sm btn-danger" aria-label="Left Align"
                    onclick="<?=@$btn_sist_ext_click?>">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <?=@$btn_sist_ext_text?>
                </button>
                <?php*/?>
                <?php if ($Plantilla == 1) {?>
                <div class="alert alert-danger"><b>No se encontró ningun RESPONSABLE, favor de ir al sistema de
                        Plantilla de Personal para capturar dicha información.</b></div>
                <button type="button" class="btn btn-default" style="border:0" onclick="refresh_responsables()">
                    <span class="ui-icon refresh_btn"></span>
                </button>
                <?php } else {?>
                <div class="alert alert-danger"><b>No se encontró ningun RESPONSABLE, para capturar dicha información de
                        click en el siguiente boton:</b><br>
                    <a target="_blank" href="javascript:PlantillaDirector();" class="btn btn-warning"
                        style="font-size:12px">Capturar Responsable</a>
                    <br><br><b>NOTA:</b> Una vez que tenga capurado la informacion <b>Recargue</b> la pagina.</div>
                <?php }?>
                <?php }?>
                <?php if (!empty($responsables) && $Plantilla == 0) { /*?>
                <div class="alert alert-warning"><b>Para capturar Otro Responasble de click en el siguiente
                        boton:</b><br>
                    <a target="_blank" href="javascript:PlantillaDirector();" class="btn btn-warning"
                        style="font-size:12px">Capturar Responsable</a>
                    <br><br><b>NOTA:</b> Una vez que tenga capurado la informacion <b>Recargue</b> la pagina.</div>
                <?php */}?>
            </div>
            <div id="error_lbl_responsables" class="error"><?=@$error_responsables?></div>
        </div>
    </div>
    <div class="form_group">&nbsp;</div>
    <!-- fin div responsables -->
    <div class="form-group">
        <?=form_label("Cantidad  <font color='red'>*</font>", "lbl_cantidad", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_cantidad)?>

            <div id="error_Cantidad" class="error"><?=form_error('input_cantidad')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Descripción  <font color='red'>*</font>", "lbl_descripcion", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_descripcion)?>
            <div id="error_DescripcionBien" class="error"><?=form_error('DescripcionBien')?></div>
        </div>
    </div>
    <!-- inicio div caracteristicas -->
    <div class="form-group" id="color_oculto" <?=(isset($hidden)) ? $hidden : 'hidden="hidden"'?>>
        <?=form_label("Color  <font color='red'>*</font>", "lbl_modelo", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_dropdown("caracteristicas[4]", $colores, $caracteristicas[4]['DescripcionCaracteristica'], $select_atributos)?>
            <div id="error_Color" class="error"><?=form_error('caracteristicas[4]')?></div>
        </div>
        <?php /*
    <?=form_label("Características","lbl_caracteristicas",$label_atributos)?>
        <div class="col-sm-4">
            <div>
                <button id="btn_tg_caracteristicas" type="button" class="btn btn-primary btn-sm" aria-label="Left Align"
                    style="width:100%">
                    <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"></span> <b>Ocultar
                        características</b>
                </button>
            </div>
            <div id="panel_caracteristicas" style="padding:10px;" class="panel panel-default">
                <!--ui-widget-content ui-corner-all-->
                <p>
                    <?php if(!empty($caracteristicas)){ ?>
                    <?php foreach($caracteristicas as $id => $c){ ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?=$c["NombreCaracteristica"]?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" size="40" maxlength="100"
                                name="caracteristicas[<?=$id?>]" value="<?=$c['DescripcionCaracteristica']?>">
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </p>
            </div>
        </div>
        */?>
    </div>
    <!-- fin div caracteristicas -->
    <div class="form-group">
        <?=form_label("Marca  <font color='red'>*</font>", "lbl_marca", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_marca)?>
            <label><input type="checkbox" id="chk_MarcaBien_NA" onchange="escribeNA('MarcaBien')" />
                <em><b>NA (No Aplica)</b></em></label>
            <div id="error_MarcaBien" class="error"><?=form_error('MarcaBien')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Modelo  <font color='red'>*</font>", "lbl_modelo", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_modelo)?>
            <label><input type="checkbox" id="chk_ModeloBien_NA" onchange="escribeNA('ModeloBien')" />
                <em><b>NA (No Aplica)</b></em></label>
            <div id="error_ModeloBien" class="error"><?=form_error('ModeloBien')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Serie  <font color='red'>*</font>", "lbl_serie", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_serie)?>
            <label><input type="checkbox" id="chk_SerieBien_NA" onchange="escribeNA('SerieBien')" />
                <em><b>NA (No Aplica)</b></em></label>
            <div id="error_SerieBien" class="error"><?=form_error('SerieBien')?></div>
        </div>
    </div>

    <div class="form-group">
        <?=form_label("Estado físico  <font color='red'>*</font>", "lbl_edoFisico", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_dropdown("IdEstadoBien", $listado_estadosFisico, set_value("IdEstadoBien", @$datos_bienes[0]->IdEstadoBien, "0"), $select_atributos)?>
            <div id="error_IdEstadoBien" class="error"><?=form_error('IdEstadoBien')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Proveedor  <font color='red'>*</font>", "lbl_proveedor", $label_atributos)?>
        <div class="col-sm-4 ui-widget">
            <?php $select_proveedor_attr = "class='form-control' id='cmb_idProveedor' data-placeholder='Seleccione' style='width:334px;display:inline'";?>
            <?=form_dropdown("IdProveedor", $listado_proveedores, set_value("IdProveedor", @$datos_bienes[0]->IdProveedor, "0"), $select_proveedor_attr)?>
            <button id="btn_add_proveedor" type="button" class="btn btn-default btn-xs" aria-label="Left Align"
                title="Agregar nuevo proveedor">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <div id="error_IdProveedor" class="error"><?=form_error('IdProveedor')?></div>
        </div>
    </div>

    <div class="form-group">
        <?=form_label("Motivo  <font color='red'>*</font>", "lbl_motivoMovimiento", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_dropdown("IdMotivoMovimiento", $listado_motivos, set_value("IdMotivoMovimiento", @$datos_bienes[0]->IdMotivoMovimiento, "0"), $select_atributos . ' onchange="onChangeIdMotivoM(this.value)"')?>
            <div id="error_IdMotivoMovimiento" class="error"><?=form_error('IdMotivoMovimiento')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Forma de adquisición  <font color='red'>*</font>", "lbl_recursoBien", $label_atributos)?>
        <div class="col-sm-4">
            <select id="IdRecursoBien" name="IdRecursoBien" class="form-control"><?=$selectrecursos?></select>
            <!--<? //=form_dropdown("IdRecursoBien",$listado_recursosBien,set_value("IdRecursoBien",@$datos_bienes[0]->IdRecursoBien,"0"),$select_atributos)?>-->
            <div id="error_IdRecursoBien" class="error"><?=form_error('IdRecursoBien')?></div>
        </div>
    </div>
    <div class="form-group">
        <?=form_label("Precio unitario (con I.V.A.)<font color='red'>*</font>", "lbl_precioUnitario", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_input($input_bien_precioUnitario)?>
            <div class="error"><?=form_error("PrecioUnitario")?></div>
        </div>
    </div>
    <!-- inicio div anexos -->
    <div class="form-group">
        <?=form_label("Evidencias  <font color='red'>*</font>", "lbl_bienAnexos", $label_atributos)?>
        <div class="col-sm-4">
            <input type="button" id="btn_ver_anexos" name="btn_seleccionar_anexo" value="Seleccione..." />
            <div class="error"><?=form_error("hdn_anexosBien")?> <?=@$error_evidenciaFactura?></div>
            <div id="safb_lista_anexos" class="panel panel-default">

                <?php if (!empty($listado_anexos)) {?>
                <?php $anexosID = "";?>
                <?php foreach ($listado_anexos as $a) {?>
                <div>
                    <?php $urlImg = ($a->ExtensionAnexo == ".pdf") ? INDEX_CP . "resources/images/pdf_64x64.png" : INDEX_CP . $a->UbicacionAnexo . $a->NombreAnexo . $a->ExtensionAnexo;?>
                    <button type="button" title="Quitar evidencia" class="btn btn-default btn-xs"
                        aria-label="Left Align" onClick="eliminaAnexo('<?=$a->IdAnexo?>')">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                    <a target="_blank">
                        <img src="<?=$urlImg?>" width="60px" />
                    </a>
                    <div><?=$a->NoFacturaAnexo?></div>
                </div>
                <?php $anexosID .= ($anexosID == "") ? $a->IdAnexo : "," . $a->IdAnexo;?>
                <?php }?>
                <?php }?>

                <input type="hidden" name="hdn_anexosBien" id="anexosID" value="<?=@$anexosID?>" />
            </div>
        </div>
    </div>
    <!-- fin div anexos -->

    <div class="form-group">
        <?=form_label("Observaciones", "lbl_observaciones", $label_atributos)?>
        <div class="col-sm-4">
            <?=form_textarea($input_observaciones)?>
            <div class="error"><?=form_error("Observaciones")?></div>
        </div>
    </div>
    <input type="hidden" name="cct" value="<?=@$cct?>" id="cct_back" />
    <input type="hidden" name="turno" value="<?=@$turno?>" id="turno_back" />
    <input type="hidden" id="hdn_IdBien" name="IdBien" value="<?=@$IdBien?>" />
    <?=form_hidden("IdEstatus", set_value("IdEstatus", @$datos_bienes[0]->IdEstatus, "1"))?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?=form_submit("btn_enviar", "Guardar", "id = 'btn_submit_form_bien' class = 'btn btn-success textWhite' $disabled_btn_guardar")?>
            <?=form_reset("btn_cancelar", "Cancelar", "id = 'btn_can_alta_bien' class = 'btn btn-warning textWhite'")?>
        </div>
    </div>
</form>
<div>
    <font color='red'>* Campos obligatorios</font>
</div><br />

<!-- inicio: seleccione anexos -->
<div name="hdn_idSolicitud" id="dlg_seleccione_anexos" title="Seleccione evidencias">
    <form class="form-horizontal" id="safrmb_frm_asol_cont" style="overflow:auto"></form>
</div>
<!-- fin: seleccione anexos -->

<!-- inicio: frm proveedores -->
<div name="hdn_dlg_fmrProv" id="hdn_dlg_frmProv" title="Agregar proveedor"></div>
<!-- fin: frm proveedores -->
<div hidden="hidden">
    <form action='<?=@$url_sistema_externo?>' method='POST' target='_blank' id="frm_sistema_ext">
        <input type='hidden' name='ses' value='<?=@$ses?>' />
        <input type='hidden' name='<?=@$token_sist_ext_name?>' value='<?=@$token_sist_ext_val?>' />
    </form>
</div>
<?php if ($Plantilla == 0) {?>
<script type="text/javascript">
function PlantillaDirector() {
    $.ajax({
        url: uri + 'vistaHTML',
        data: {
            'cp_hsh4_tk': $("#token").val(),
            'vista': 'altaPersonal',
            'cct': $.trim($('#cct_back').val()),
            'turno': $.trim($('#turno_back').val())
        },
        dataType: "text",
        cache: false,
        type: "POST",
        beforeSend: function() {
            $("#loadData").show();
        },
        success: function(data) {
            $("#loadData").hide();
            var HTMLCONTENIDO = data;
            $("#dialog_pregunta").dialog({
                position: {
                    my: 'top',
                    at: 'top',
                    of: $(document)
                },
                width: '650px',
                title: "Alta de Personal"
            });
            pregunta_formulario('Alta de Personal a Plantilla', HTMLCONTENIDO, 'info',
                'funcionAltaPersonal', 'incluirBienes');
            $("#dialog_pregunta").css('overflow', 'visible');
            $(".ui-dialog").css('overflow', 'visible');
            $("#_fecha").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-60:+1",
                dateFormat: 'dd/mm/yy',
                maxDate: '0',
            });
        },
        error: function() {
            $("#loadData").hide();
            console.log("ERROR RECUPERAR VISTA");
        }
    });
}

function funcionAltaPersonal() {
    var men1 = $(this);
    var msn = "";
    if ($.trim($("#rfc").val()).length == 0) {
        msn += "<b>* RFC</b><br />";
    }
    if ($.trim($("#homo").val()).length == 0) {
        msn += "<b>* Homoclave</b><br />";
    }
    if ($.trim($("#curp").val()).length == 0) {
        msn += "<b>* CURP</b><br />";
    }
    if ($.trim($("#app").val()).length == 0) {
        msn += "<b>* Apellido paterno</b><br />";
    }
    if ($.trim($("#nombre").val()).length == 0) {
        msn += "<b>* Nombre</b><br />";
    }
    if ($("#_genero").val() == 0) {
        msn += "<b>* Género</b><br />";
    }
    if ($.trim($("#_fecha").val()).length == 0) {
        msn += "<b>* Fecha de nacimiento</b><br />";
    }
    if ($("#funcion").val() == 0) {
        msn += "<b>* Función</b><br />";
    }
    if ($("#situacion").val() == 0) {
        msn += "<b>* Situación</b><br />";
    }
    if (msn.length > 0) {
        mensaje("<b>Los siguientes campos son requeridos:</b><br /><br />" + msn);
        return false;
    } else {
        if ($.trim($("#rfc").val()).length < 10) {
            mensaje("El RFC es incorrecto");
            return false;
        } else if ($.trim($("#homo").val()).length < 3) {
            mensaje("La Homoclave es incorrecta");
            return false;
        } else if ($.trim($("#curp").val()) != "" && $.trim($("#curp").val()).length < 18) {
            mensaje("El CURP es incorrecto");
            return false;
        }
        var _rfc = $.trim($("#rfc").val());
        var _newRfc = _rfc.substring(4, 10);

        var _curp = $.trim($("#curp").val());
        var _newCurp = _curp.substring(4, 10);
        if (parseInt(_newRfc) != parseInt(_newCurp)) {
            mensaje("Revise el RFC con el CURP");
            return false;
        }

        var _fecha = $.trim($("#_fecha").val());
        if (_fecha != "") {
            var _arrayFecha = _fecha.split("/");
            var _year = _arrayFecha[2].substring(2, 4);
            var _newFecha = _year + _arrayFecha[1] + _arrayFecha[0];
            if (parseInt(_newFecha) != parseInt(_newRfc)) {
                mensaje("Revise la Fecha de nacimiento con el RFC");
                return false;
            }
        }

        var _genero = $("#_genero").val();
        if (_genero != "") {
            var _newGenero = _curp.substring(10, 11);
            _newGenero = _newGenero.toUpperCase();
            if (_genero != _newGenero) {
                mensaje("El curp proporcionado es incorrecto");
                return false;
            }
        }

        $.post(uri + "plantilla_ALTA", $("#formulario").serialize(), function(r) {
            $("#dialog_pregunta").remove();
            mensaje('Se ha ingresado el Responsable al Sistema. Favor de Actualizar la Pagina.', '', 'SUCCESS');
        });
    }
}
</script>
<?php }?>