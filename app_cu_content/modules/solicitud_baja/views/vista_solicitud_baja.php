<script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/jquery.jqGrid.min.js"></script>
<link rel="stylesheet" href="<?php echo INDEX_CP;?>resources/css/chosen.css">
<script src="<?php echo INDEX_CP;?>resources/js/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo INDEX_CP;?>resources/js/image_chosen.js" type="text/javascript"></script>
<link href="<?php echo INDEX_CP ?>resources/css/ui.jqgrid.css" rel="stylesheet" />
<style>
td,
th {
    word-break: break-all;
}
</style>
<input type="hidden" value="<?php echo $token ?>" id="token">
<input type="hidden" value="<?php echo $idSolicitud ?>" id="idSolicitud">
<div style="display:inline">
    <span class="tituloInicio">Solicitud de Baja</span>
    <span class="right"><span class="tituloInicio">Folio:</span>
        <span class="textLarge"><?=@$datos_cabecera[0]->FolioSolicitud?></span>
    </span>
</div>
<br /><br />
<div class="panel panel-danger">
    <div class="panel-heading"><b>Centro de trabajo que entrega: </b></div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <td colspan="2"><span class="titleInfo"><b>Área o plantel: </b>
                        <?php echo $datosCCT['NOMBRECT']; ?></span></td>
            </tr>
            <tr>
                <td><span class="titleInfo"><b>Domicilio: </b> <?php echo $datosCCT['DOMICILIO']; ?></span></td>
                <td><span class="titleInfo"><b>Población: </b>
                        <?php echo $datosCCT['NOM'].', '.$datosCCT['NOMBRELOC']; ?></span></td>
            </tr>
            <tr>
                <td><span class="titleInfo"><b>Clave: </b> <?php echo $datosCCT['CLAVECCT']; ?></span></td>
                <td><span class="titleInfo"><b>Zona: </b> <?php echo $datosCCT['ZONAESCOLA']; ?></span></td>
            </tr>
            <tr>
                <td><span class="titleInfo"><b>Turno: </b> <span
                            style="text-transform:uppercase;"><?php echo $datosCCT['TURNO']; ?></span></span></td>
                <td><span class="titleInfo"><b>Teléfono(s): </b>
                        <!--input type="text" value="<?php echo $datosCCT['TELEFONO']; ?>" name="telContacto" required-->
                        <input type="text" id="txt_tel_sol" value="<?=@$datos_cabecera[0]->TELEFONOS?>"
                            name="telContacto" style="margin-right:3px;" disabled maxlength="15" size="18" /><input
                            type="text" id="txt_tel_sol2" value="<?=@$datos_cabecera[0]->TELEFONOS2?>"
                            name="telContacto2" disabled maxlength="15" size="18" />
                        <button id="btn_editTel" type="button" title="Editar teléfono" class="btn btn-default btn-xs"
                            style="border:0" onclick="editar_telefono('Habilitar')"></span>
                    <span id="btn_icon_editTel" class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td><span class="titleInfo"><b>Correo electrónico: </b>
                        <input type="text" id="txt_correo_sol" value="<?=@$datos_cabecera[0]->CorreoElectronico?>"
                            name="correoContacto" style="margin-right:4px;" disabled size="40" />
                        <button id="btn_editCorreo" type="button" title="Editar Correo electrónico"
                            class="btn btn-default btn-xs" style="border:0" onclick="editar_correo('Habilitar')"></span>
                    <span id="btn_icon_editCorreo" class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </td>
                <td></td>
            </tr>

        </table>
    </div>
</div>
<style>
.contenidos {
    display: none;
}

.no_bold {
    font-weight: normal;
}

.anexos_preview {
    min-height: 140px;
    max-height: 140px;
}

@media (max-width: 768px) {
    .ui-dialog {
        top: 2% !important;
        left: 2% !important;
    }
}
</style>
<!--div id="tabsBajas">
  <ul>
    <li><a href="#tabsB-1">Bienes registrados en centro de trabajo</a></li>
    <li><a href="#tabsB-2">Bienes que no estan registrados en centro de trabajo </a></li>
    <li><a href="#tabsB-3" id="anexo__">Anexos solicitud </a></li>
  </ul-->
<div class="well btn-group" role="group">


    <label for="1"><span class="label label-danger">Paso 1</span> <a href="javascript:;"
            onclick="mensaje('Ayuda','Por favor, primero ingrese los archivos correspondientes a las evidencias para los bienes de esta solicitud','INFO');"
            class="btn btn-xs btn-info"> ? </a><br /><button rel="tabsB-3" type="button"
            class="botones btn btn-purple">Agregar evidencia</button></label>

    <label for="2"><span class="label label-danger">Paso 2</span> <a href="javascript:;"
            onclick="mensaje('Ayuda','<div><h4>Agregar bienes a la solicitud de baja</h4><br>Permite agregar los bienes que están en este centro de trabajo a una solicitud.</div>','INFO');"
            class="btn btn-xs btn-info"> ? </a> <br /><button rel="tabsB-1" type="button"
            class="botones btn btn-purple">Agregar bienes a la solicitud de baja</button> <button rel="tabsB-4"
            type="button" class="botones btn btn-purple" id="ver_anexos">Ver Evidencias de la solicitud</button></label>
    <?php /* <button rel="tabsB-2" type="button" id="nuev" class="botones btn btn-purple">Bajas por diferencia de inventario</button></label> */ ?>

</div>
<div id="tabsB-1" class="contenidos">
    <div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all">
        <div class="ui-widget-header ui-corner-all textLarge">Agregar bien</div>
        <p><img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> En el siguiente listado
            puede encontrar los bienes que se tienen registrados en su centro de trabajo.
            Por favor seleccione los bienes del listado que quiere agregar a esta <b>solicitud de baja</b>
            haciendo clic en la casilla de la izquierda ( <input disabled type="checkbox"> ) y posteriormente clic en el
            botón ( <span class="label label-success">Incluir bien </span> )</p>
        <div class="alert alert-danger">
            <table id="tablaBienesCCT"></table>
            <div id="paginacionB"></div>
            <div class="alert alert-warning"><a href="javascript:;" onclick="menuIncluirBien();"
                    class="btn btn-success textWhite"><img src="<?php echo INDEX_CP;?>resources/images/incluir.png"
                        alt="Incluir" class="icon16"> Incluir bien</a></div>
        </div>
    </div>
</div>
<?php /*  <div id="tabsB-2" class="contenidos">
  <div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all" ><div class="ui-widget-header ui-corner-all textLarge">Bajas por diferencia de inventario</div>
    <p><img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'> El siguiente formulario
sirve para los bienes que no se encuentren en el listado de bienes asignados a su centro de trabajo, por lo que se dan
de baja sin un número de inventario.
Por favor rellene los campos necesario para ingresar bienes a esta <b>solicitud de baja</b> y posteriormente clic en el
botón ( <span class="label label-success">Incluir bien </span> )</p>

<form id="frm_alta_guarda_bien" class="form-horizontal" name="frm_guarda_anexo" method="post"
    action="alta_bien_guardar">
    <div class="form-group">
        <label for="lbl_tipoBien" class="col-sm-2 control-label">Tipo <span class="error">*</span></label>
        <div class="col-sm-4">
            <select name="IdTipoBien" id="IdTipoBien" onchange="mostrar_articulos(this.value)" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($tipo as $k => $val){?>
                <option value="<?php echo $val['id'] ?>"><?php echo $val['val'] ?></option>
                <?php }?>
            </select>
            <div class="error"></div>
        </div>
    </div>
    <div class="row" style="margin:0;padding:0" hidden="hidden" id="cim_">
        <label for="lbl_tipoBien" class="col-sm-2 control-label"><span class="error">*</span></label>
        <div class="col-sm-4" id="div_cmb_articulo">
            <select name="IdArticulo" id="cmb_articulo" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($cim_tipo as $k => $val){?>
                <option value="<?php echo $val['id'] ?>"><?php echo $val['val'] ?></option>
                <?php }?>
            </select>
            <div class="error"></div><br />
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_cantidad" class="col-sm-2 control-label">Cantidad <span class="error">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="input_cantidad" value="" id="input_cantidad" maxlength="5" size="10"
                class="form-control w50">
            <div class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_descripcion" class="col-sm-2 control-label">Descripción <span class="error">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="DescripcionBien" value="" id="DescripcionBien" maxlength="45" size="50"
                class="form-control">
            <div class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_marca" class="col-sm-2 control-label">Marca <span class="error">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="MarcaBien" value="" id="MarcaBien" maxlength="45" size="50" class="form-control">
            <div class="error"></div>
            <label><input type="checkbox" id="marca_check" class="verifica_chek btn" /> <em><b>NA (No
                        Aplica)</b></em></label>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_modelo" class="col-sm-2 control-label">Modelo <span class="error">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="ModeloBien" value="" id="ModeloBien" maxlength="45" size="50" class="form-control">
            <div class="error"></div>
            <label><input type="checkbox" id="marca_check" class="verifica_chek btn" /> <em><b>NA (No
                        Aplica)</b></em></label>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_serie" class="col-sm-2 control-label">Serie <span class="error">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="SerieBien" value="" id="SerieBien" maxlength="45" size="50" class="form-control">
            <div class="error"></div>
            <label><input type="checkbox" id="marca_check" class="verifica_chek btn" /> <em><b>NA (No
                        Aplica)</b></em></label>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_edoFisico" class="col-sm-2 control-label">Estado físico <span class="error">*</span></label>
        <div class="col-sm-4">
            <select name="IdEstadoBien" id="IdEstadoBien" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($edo_fis as $k => $val){?>
                <option value="<?php echo $val['id'] ?>"><?php echo $val['val'] ?></option>
                <?php }?>
            </select>
            <div class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="lbl_motivoMovimiento" class="col-sm-2 control-label">Motivo <span class="error">*</span></label>
        <div class="col-sm-4">
            <select name="IdMotivoMovimiento" id="IdMotivoMovimiento" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($motivo as $k => $val){?>
                <option value="<?php echo $val['id'] ?>"><?php echo $val['val'] ?></option>
                <?php }?>
            </select>
            <div class="error"></div>
        </div>

    </div>

    <!-- inicio div anexos -->
    <div class="form-group">
        <label for="lbl_bienAnexos" class="col-sm-2 control-label">Evidencias <span class="error">*</span></label>
        <div class="col-sm-10">
            <p>Nota: Si no le aparece alguna Evidencia, favor de recargar la página.</p>
            <select name="anexos[]" id="anexos_alta" class="anexos_agregar chosen-select form-control"
                data-placeholder="Seleccione Evidencia(s)" style="width:100%;min-width:350px; max-width:350px;" multiple
                tabindex="3">
                <?php echo $ANEXOS2; ?>
            </select>
            <div class="error"></div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $token ?>" name="cp_hsh4_tk">
    <input type="hidden" value="<?php echo $idSolicitud ?>" name="solicitud_alta" id="imp">
    <script type="text/javascript">
    $('.verifica_chek').change(function(e) {
        if ($(this).is(':checked')) {
            $(this).parent('label').parent('div').children('input').val('N/A');
            $(this).parent('label').parent('div').children('input').attr('disabled', 'disabled');
        } else {
            $(this).parent('label').parent('div').children('input').val('');
            $(this).parent('label').parent('div').children('input').removeAttr('disabled');
        }

    });
    $(".chosen-select").chosen({
        width: "100%",
        html_template: '<img style="margin-right: 5px; width: 50px; border: 2px solid black;" class="{class_name}" src="{url}" />'
    });
    $('#input_cantidad').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    $('#IdTipoBien').change(function(e) {
        $('#input_cantidad').removeAttr('disabled');
        if ($(this).val() == 1) {
            $('#input_cantidad').val(1);
            $('#input_cantidad').attr('disabled', 'disabled');
        }
    });
    $('#IdMotivoMovimiento').change(function(e) {
        $('#IdEstadoBien').removeAttr('disabled');
        if ($(this).val() == 16) {
            $('#IdEstadoBien').val(5);
            $('#IdEstadoBien').attr('disabled', 'disabled');
        }
        if ($(this).val() == 17) {
            $('#IdEstadoBien').val(7);
            $('#IdEstadoBien').attr('disabled', 'disabled');
        }
    });
    </script>
    <!-- fin div anexos -->

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" name="btn_enviar" value="Guardar" id="btn_submit_form_bien"
                class="btn btn-success textWhite"> <input type="reset" name="btn_cancelar" value="Cancelar"
                id="btn_can_alta_bien" class="btn btn-warning textWhite">
        </div>
    </div>
</form>
<div class="error">* Campos obligatorios</div>
</div>
</div> */?>
<div id="tabsB-3" class="contenidos">
    <div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all">
        <div class="ui-widget-header ui-corner-all textLarge">Agregar evidencia</div>
        <?php echo $vista_anexos; ?>
    </div>
    <div id="tabsB-4" class="contenidos">
        <div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all">
            <div class="ui-widget-header ui-corner-all textLarge">Evidencia de solicitud</div>
            <div class="alert alert-warning" role="alert">
                <p>
                    <img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'>Evidencias
                    relacionadas a los
                    bienes de esta <b>solicitud de baja</b>.
                </p><br>
                <p>
                    <b>NOTAS: </b> <span>
                    </span></p>
                <ul>
                    <li> Presione en la <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> para
                        eliminar la evidencia.</li>
                    <!--li> Si no aparece la <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>, entonces la evidencia está relacionada a algún(algunos) bien(es).</li-->
                    <li> Presione encima de la imagen para descargar la evidencia.</li>
                </ul>

                <p></p>
            </div>
            <div class="well well-sm anexos">
                <?php echo $ANEXOS; ?>
            </div>
        </div>
    </div>

    <!--/div-->



    <table id="tablaBajaListado"></table>
    <div id="paginacion"></div>

    <a href="#" id="iconoG3" class="btn btn-default" title="Mostrar glosario de íconos"
        style="margin-top:5px !important; margin-bottom:0px !important">Ver glosario de íconos</a>
    <table border="0" cellpadding="0" id="tableIconos3"
        style="border-top:#CCCCCC solid 1px;font-size: 10px; display:none;margin-top:5px">
        <tbody>
            <tr>
                <td><img src="<?php echo INDEX_CP ?>resources/images/edit.png" class='icon24' alt='Editar'></td>
                <td><img src="<?php echo INDEX_CP ?>resources/images/zoom.png" class='icon24' alt='Vista previa'></td>
                <td><img src="<?php echo INDEX_CP ?>resources/images/error.png" class='icon24' alt='Eliminar'></td>
                <td><img src="<?php echo INDEX_CP ?>resources/images/refresh.png" class='icon24' alt='Recargar'></td>
            </tr>
            <tr>
                <th>Editar</th>
                <th>Vista previa</th>
                <th>Eliminar</th>
                <th>Recargar datos</th>
            </tr>
        </tbody>
    </table>
    <hr />
    <div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span> Para enviar esta y otras
        solicitudes a autorización dirigirse al menú de solicitudes:
        <a href="<?php echo INDEX_CP ?>solicitudes" class="btn btn-xs btn-success"> <img
                src="<?php echo INDEX_CP ?>resources/images/ico_solicitud.png" class="icon24"> Solicitudes</a>
    </div>

    <script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/solicitud_baja_listado.js"></script>
    <script>
    $(function() {
        $("#tabsBajas").tabs();
    });



    $(document).ready(function(e) {
        $('#btn_can_alta_anexo').click(function(e) {
            $('#numAnexo').val('');
            $('#fechaAnexo').val('');
            $("#anexos").replaceWith($("#anexos").clone());
        });
        $('.botones').click(function(e) {
            var t = $(this).attr('rel');
            if ($('#' + t).is(":visible")) {
                $('#' + t).slideUp(400);
            } else {
                $('.contenidos').hide();
                setTimeout(function() {
                    $('#' + t).slideDown(400);
                }, 10);
            }
        });
        //$('#nuev').trigger('click');
    });
    </script>