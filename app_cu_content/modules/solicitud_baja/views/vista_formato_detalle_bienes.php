<div class="panel panel-primary">
    <div class="panel-heading"><b>Bienes seleccionados</b></div>
    <div class="panel-body">
        <form method="POST" name="incluirBienes" enctype="multipart/form-data">
            <table id="iBienes" class="table">
                <?php foreach ($datosBienes as $key => $valueB) {?>
                <tbody>
                    <tr>
                        <!--td><div class="col-sm-12"><b>Cant.</b></div><span class="titleTable"><input type="text" maxlength="3" name="nBienes[]" id="nBienes[]" <?php if ($valueB['nBienes'] == 1) {
    echo 'disabled';
}
    ?> value="<?php echo $valueB['nBienes']; ?>" class="w50 form-control"></span-->
                        <td class="col-sm-5">
                            <div><b>Seleccionar bienes</b><span style="color:#d64161">*</span></div>

                            <?php
                            $enc_url = str_replace(array('-', '_', '~'), array('+', '/', '='), $valueB['nIdBienes']);
                            $valueB['nIdBienes'] = $this->encrypt->decode($enc_url);

                            $enc_url = str_replace(array('-', '_', '~'), array('+', '/', '='), $valueB['inventario']);
                            $valueB['nInventarios'] = $this->encrypt->decode($enc_url);

                            $ids = explode(',', $valueB['nIdBienes']);
                            $inventario = explode(',', $valueB['nInventarios']);?>
                            <ul>
                                <li class="main-parent">
                                    <label>Seleccionar todo:</label>
                                    <input class="main-checkbox" type="checkbox" name="select_all" id="select_all">
                                    <?php
                            foreach ($ids as $k => $val) {?>
                                    <label style="margin-right:15px;">
                                        <ul>
                                            <li>
                                                <input type="checkbox" class="n_inventario" name="select[]"
                                                    id="n_inventario" value="<?php echo $val; ?>">
                                                <span class="no_bold">No. Inv.:</span>
                                                <?php echo $inventario[$k]; ?>
                                            </li>
                                        </ul>
                                    </label>
                                    <?php }?>
                                </li>
                            </ul>
                        </td>
                        <!--td><div class="col-sm-12"><b>No. Inventarios</b></div><span class="titleTable"><?php echo $valueB['nInventarios']; ?></span></td-->
                        <td class="col-sm-2">
                            <div><strong>Descripción</strong></div>
                            <p><?php echo $valueB['DescripcionBien']; ?></p>
                        </td>
                        <td class="col-sm-2">
                            <div><strong>Motivo de baja</strong><span style="color:#d64161">*</span></div>
                            <div class="titleTable">
                                <?php $nOp = 'motMov_' . $key;
                                    echo form_dropdown('motMov[]', $catMotMov, '', 'class="form-control mot_b" rel="edo_b_' . $key . '"');?>
                            </div>

                        </td>
                        <td class="col-sm-2">
                            <div><strong>Estado</strong><span style="color:#d64161">*</span></div>
                            <div class="titleTable">
                                <?php $nOp = 'edoBien_' . $key;
                                    echo form_dropdown('edoBien[]', $opEdoBien, '', 'class="form-control edo_b_' . $key . ' "');?>
                            </div>
                        </td>
                        <td class="t_9">
                            <div><strong>Evidencias <span style="color:#d64161">*</span></strong></div>
                            <!--input type="file" class="form-control" name="anexo[]" id="anexo[]"-->
                            <div>
                                <select id="anexos" name="anexos[]" class="anexos_agregar chosen-select2 form-control"
                                    data-placeholder="Seleccione Evidecia(s)"
                                    style="width:100%;min-width:350px; max-width:350px;" multiple tabindex="3">

                                    <?php echo $ANEXOS; ?>

                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <!--input type="text" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value="<?php echo $valueB['nIdBienes']; ?>" class="form-control"-->
                            <input type="text" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value=""
                                class="form-control" disabled>
                            <input type="hidden" maxlength="3" name="maxBienes[]" id="maxBienes[]"
                                value="<?php echo $valueB['nBienes']; ?>" class="form-control">
                        </td>
                    </tr>
                </tbody>
                <?php }?>
            </table>
            <div class="error" style="color: #d64161">* Campos obligatorios</div>
        </form>
        <script type="text/javascript">
        //CHECKBOX DE SELECCION DE TODOS
        /** FUNCIONA SOLO FALTA AGREGARLO AL CAMPO Y SEPARAR POR COMAS */
        $(function() {
            $('input:checkbox.main-checkbox').click(function() {
                var array = [];
                var arraysplited = [];
                var parent = $(this).closest('.main-parent');
                $(parent).find('.n_inventario').prop("checked", $(this).prop("checked"));
                if ($(this).is(':checked')) {
                    $(parent).find('.n_inventario:checked').each(function() {
                        arraysplited = array.push($(this).val().split(','));
                        $(parent).parent().parent().parent().children('.t_9').children('.i_b')
                            .val(
                                array).css({
                                "color": "green",
                                "border": "2px solid green"
                            });

                        //array.push($(this).val());

                    });
                } else {
                    $(parent).parent().parent().parent().children('.t_9').children('.i_b')
                        .val(
                            "").css({
                            "color": "red",
                            "border": "2px solid red"
                        });
                }

            });
        });

        /*** FUNCIONA SOLO FALTA AGREGARLO AL CAMPO Y SEPARAR POR COMAS */
        /*  $(function() {
            $('input:checkbox.n_inventario').change(function() {
                var array = [];
                $.each($('input:checkbox.n_inventario'), function() {
                    array.push($(this).val().split(','));
$('input:checkbox.n_inventario').parent().parent().parent().parent()
                        .parent().parent().parent().children('.t_9').children('.i_b').val(array)
                        .css({
                            "color": "chocolate",
                            "border": "2px solid chocolate"
                        });
                });
            });
        });*/


        $('.nInventarios').removeClass('nInventarios');
        $('.n_inventario').change(function(e) {
            valores = [];
            valor = $(this).parent().parent().parent().parent().parent().parent().parent().children('.t_9').children('.i_b').val();
            valores = (valor != '') ? valor.split(',') : [];
            v = $(this).val();
            if ($(this).is(':checked')) {
                if ($.inArray(v, valores) == -1) {
                    valores.push(v);
                }
                $(this).parent().parent().parent().parent().parent().parent().parent().children('.t_9').children('.i_b').val(valores.toString());
            } else {
                //valores.splice($.inArray(v, val),1);
                valor = valor.replace(v + ',', '');
                valor = valor.replace(',' + v, '');
                valor = valor.replace(v, '');
                $(this).parent().parent().parent().parent().parent().parent().parent().children('.t_9').children('.i_b').val(valor);
            }
        });

        $(".chosen-select2").chosen({
            width: "100%",
            html_template: '<img style="margin-right: 5px; width: 50px; border: 2px solid black;" class="{class_name}" src="{url}" />'
        });
        $(".mot_b").change(function(e) {
            edo = $(this).attr('rel');
            $('.' + edo).removeAttr('disabled');
            /*if($(this).val() == 16){
            	$('.'+edo).val(5);
            	$('.'+edo).attr('disabled','disabled');
            }*/
            if ($(this).val() == 17) {
                $('.' + edo).val(7);
                $('.' + edo).attr('disabled', 'disabled');
            }
            if ($(this).val() == 18) {
                $('.' + edo).val(5);
                $('.' + edo).attr('disabled', 'disabled');
            }
            if ($(this).val() == 20) {
                $('.' + edo).val(7);
                $('.' + edo).attr('disabled', 'disabled');
            }
        });
        </script>
        <!--
            FUNCIONA DE UNO EN UNO
        <script src="<?php echo INDEX_CP ?>resources/js/check_all.js"></script>  -->
    </div>
</div>