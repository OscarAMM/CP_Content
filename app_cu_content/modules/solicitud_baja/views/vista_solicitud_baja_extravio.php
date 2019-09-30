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
<input type="hidden" value="<?php echo $claveCT_ADM ?>" id="claveCT_ADM">
<input type="hidden" value="<?php echo $turnoCT_ADM ?>" id="turnoCT_ADM">
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
<div class="well btn-group" role="group">
    <label for="2">
        <span class="label label-danger">Paso 1</span>
        <!--<a href="javascript:;" onclick="mensaje('Ayuda','<div><h4>Baja por Extravío</h4>Permite dar de baja bienes que fueron extraviados</div>','INFO');" class="btn btn-xs btn-info"> ? </a>--><br>
        <button rel="tabsB-1" type="button" class="botones btn btn-purple">Agregar bienes a la solicitud de
            baja</button>
    </label>
    <label for="1">
        <span class="label label-danger">Paso 2</span>
        <!--<a href="javascript:;" onclick="mensaje('Ayuda','Por favor, primero ingrese los archivos correspondientes a las evidencias para los bienes de esta solicitud','INFO');" class="btn btn-xs btn-info"> ? </a>-->
        <br />
        <button rel="tabsB-2" type="button" id="nuev" class="botones btn btn-purple">Acta Circunstanciada</button>
        <button rel="tabsB-3" type="button" class="botones btn btn-purple">Agregar evidencia</button>
        <button rel="tabsB-4" type="button" class="botones btn btn-purple" id="ver_anexos">Ver Evidencias de la
            solicitud</button></label>

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

<div id="tabsB-2" class="contenidos">
    <div id="tab-form-agregaBien" class="ui-widget-content ui-corner-all">
        <div class="ui-widget-header ui-corner-all textLarge">Capturar Acta Circunstanciada de Hechos</div>
        <div class="alert alert-danger">
            <div class="well">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Nombre del Responsable del Centro Escolar</label>
                        <input type="text" class="form-control" value="<?php echo $NombreDirector; ?>"
                            id="nombreDirector">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Fecha de Ingreso al Centro de Trabajo</label>
                        <input type="text" class="form-control" onfocus="this.blur()"
                            value="<?php echo $FechaEntregaRecepcion; ?>" id="fechaRecepcion">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Nombre del Jefe Inmediato</label>
                        <input type="text" class="form-control" value="<?php echo $NombreJefeInmediato; ?>"
                            id="nombreJefeInmediato">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Puesto del Jefe Inmediato</label>
                        <input type="text" class="form-control" value="<?php echo $FuncionJefeInmediato; ?>"
                            id="puestoJefeInmediato">
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Fecha del Inventario</label>
                        <input type="text" class="form-control" onfocus="this.blur()"
                            value="<?php echo $FechaLevantamiento; ?>" id="fechaLevantamiento">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Fecha de Denuncia</label>
                        <input type="text" class="form-control" onfocus="this.blur()"
                            value="<?php echo $FechaDenuncia; ?>" id="fechaDenuncia">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>Fecha de la elaboración del Acta</label>
                        <input type="text" class="form-control" onfocus="this.blur()"
                            value="<?php echo $FechaReunion; ?>" id="fechaReunion">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <div class="alert alert-warning">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <strong> ¡Importante! </strong> La <b>Denuncia</b> puede ser tramitada a través de <b>Juez
                                de Paz, Comisario Ejidal, Fiscalía o Ministerio Público.</b>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" onclick="guardarActa()" class="btn btn-success textWhite">Guardar Acta</a>
            </div>
        </div>
    </div>
</div>


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
                    <img src="<?php echo INDEX_CP?>resources/images/info.png" class="icon24" alt="Info"> Evidencias relacionadas a los
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

    <script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/solicitud_baja_listado_extravio.js"></script>
    <script>
    $(function() {
        $("#tabsBajas").tabs();

    });

    function editarFechas() {
        $("#fechaLevantamiento").datepicker("option", "changeYear", true);
        $("#fechaDenuncia").datepicker("option", "changeYear", true);
        $("#fechaReunion").datepicker("option", "changeYear", true);
        $("#fechaRecepcion").datepicker("option", "changeYear", true);

        $("#fechaLevantamiento").datepicker("option", "yearRange", "1950:" + new Date().getFullYear());
        $("#fechaDenuncia").datepicker("option", "yearRange", "1950:" + new Date().getFullYear());
        $("#fechaReunion").datepicker("option", "yearRange", "1950:" + new Date().getFullYear());
        $("#fechaRecepcion").datepicker("option", "yearRange", "1950:" + new Date().getFullYear());

        $("#fechaLevantamiento").datepicker("option", "changeMonth", true);
        $("#fechaDenuncia").datepicker("option", "changeMonth", true);
        $("#fechaReunion").datepicker("option", "changeMonth", true);
        $("#fechaRecepcion").datepicker("option", "changeMonth", true);

        //Fecha Elaboración Acta En Modo Edición
        if ($("#fechaDenuncia").datepicker('getDate') != null) {
            test = $("#fechaDenuncia").datepicker('getDate');
            testm = new Date(test.getTime());
            testm.setDate(testm.getDate() + 1);
            $("#fechaReunion").datepicker("option", "minDate", (
                $("#fechaDenuncia").datepicker('getDate') < new Date("2018-03-17") ?
                new Date("2018-03-17") :
                testm));
        }
        //Fecha de Denuncia en modo Edición
        if ($("#fechaLevantamiento").datepicker('getDate') != null) {
            test = $("#fechaLevantamiento").datepicker('getDate');
            testm = new Date(test.getTime());
            testm.setDate(testm.getDate() + 1);
            $("#fechaDenuncia").datepicker("option", "minDate",
                testm);
        }
        //Fecha del Inventario en modo Edición
        if ($("#fechaRecepcion").datepicker('getDate') != null) {
            test = $("#fechaRecepcion").datepicker('getDate');
            testm = new Date(test.getTime());
            testm.setDate(testm.getDate() + 1);
            $("#fechaLevantamiento").datepicker("option", "minDate", testm);
        }



    }

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


        //GAC
        $("#fechaRecepcion").datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            onSelect: function(dateText, inst) {
                editarFechas();

                test = $(this).datepicker('getDate');
                testm = new Date(test.getTime());
                testm.setDate(testm.getDate() + 1);


                $("#fechaLevantamiento").datepicker("option", "minDate", testm);
                $("#fechaDenuncia").datepicker("option", "minDate", testm);
                $("#fechaReunion").datepicker("option", "minDate", (testm < new Date("2018-03-16") ?
                    '16-03-2018' : testm));
                $("#fechaLevantamiento").datepicker("setDate", null);
                $("#fechaDenuncia").datepicker("setDate", null);
                $("#fechaReunion").datepicker("setDate", null);
            }
        });

        $("#fechaLevantamiento").datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            onSelect: function(dateText, inst) {
                editarFechas();
                test = $(this).datepicker('getDate');
                testm = new Date(test.getTime());
                testm.setDate(testm.getDate() + 1);
                $("#fechaDenuncia").datepicker("option", "minDate", testm);
                $("#fechaReunion").datepicker("option", "minDate", (testm < new Date("2018-03-16") ?
                    '16-03-2018' : testm));
                $("#fechaDenuncia").datepicker("setDate", null);
                $("#fechaReunion").datepicker("setDate", null);
            }
        });

        $("#fechaDenuncia").datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            onSelect: function(dateText, inst) {
                editarFechas();
                test = $(this).datepicker('getDate');
                testm = new Date(test.getTime());
                testm.setDate(testm.getDate() + 1);
                $("#fechaReunion").datepicker("option", "minDate", (testm < new Date("2018-03-16") ?
                    new Date("2018-03-17") : testm));
                $("#fechaReunion").datepicker("setDate", null);
            }
        });

        $("#fechaReunion").datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            onSelect: function(dateText, inst) {
                editarFechas();
            }
        });



        $("#fechaReunion").datepicker({
            beforeShowDay: $.datepicker.noWeekends
        });
        $("#fechaLevantamiento").datepicker({
            beforeShowDay: $.datepicker.noWeekends
        });
        $("#fechaRecepcion").datepicker({
            beforeShowDay: $.datepicker.noWeekends
        });
        $("#fechaDenuncia").datepicker({
            beforeShowDay: $.datepicker.noWeekends
        });


        $("#fechaDenuncia,#fechaReunion,#fechaLevantamiento,#fechaRecepcion").attr('readonly');

        editarFechas();

        //Si ya se han guardado previamente las fechas, se valida.

        /*$("#fechaLevantamiento").datepicker("option", "minDate", ( $("#fechaLevantamiento").datepicker('getDate') == null  ?  '16-03-2018' : $("#fechaLevantamiento").datepicker('getDate')));
        $("#fechaRecepcion").datepicker("option", "minDate", ( $("#fechaRecepcion").datepicker('getDate') == null  ?  '16-03-2018' : $("#fechaRecepcion").datepicker('getDate')));
        $("#fechaDenuncia").datepicker("option", "minDate", ( $("#fechaDenuncia").datepicker('getDate') == null  ?  '16-03-2018' : $("#fechaDenuncia").datepicker('getDate')));*/


        /*
        	$( "#fechaDenuncia" ).datepicker({beforeShowDay: $.datepicker.noWeekends,onSelect: function(dateText, inst){test = $(this).datepicker('getDate');
          testm = new Date(test.getTime());
          testm.setDate(testm.getDate() + 1);
          testmin = new Date(test.getTime());
          testmin.setDate(testmin.getDate() - 1);
          $("#fechaReunion").datepicker("option", "minDate", testm);
          $("#fechaLevantamiento").datepicker("option", "maxDate", testmin);}});
        	$( "#fechaReunion" ).datepicker({beforeShowDay: $.datepicker.noWeekends});
        	$( "#fechaLevantamiento" ).datepicker({beforeShowDay: $.datepicker.noWeekends});
        	$( "#fechaRecepcion" ).datepicker({beforeShowDay: $.datepicker.noWeekends});
        	$( "#fechaDenuncia,#fechaReunion,#fechaLevantamiento,#fechaRecepcion").attr('readonly');
        */
    });
    </script>