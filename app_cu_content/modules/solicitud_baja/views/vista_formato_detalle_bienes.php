<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<div class="panel panel-primary">
    <div class="panel-heading"><b>Bienes seleccionados</b></div>
    <div class="panel-body">
        <form method="POST" name="incluirBienes" enctype="multipart/form-data">
            <table id="iBienes" class="table table-responsive">
                <?php foreach ($datosBienes as $key => $valueB) { ?>
                <tbody>
                    <tr>
                        <!--td><div class="col-sm-12"><b>Cant.</b></div><span class="titleTable"><input type="text" maxlength="3" name="nBienes[]" id="nBienes[]" <?php if($valueB['nBienes'] == 1) echo 'disabled'; ?> value="<?php echo $valueB['nBienes']; ?>" class="w50 form-control"></span-->
                        <td class="col-sm-2">
                            <div>
                                <label>Seleccionar todo:</label>
                                <input type="checkbox" name="select_all" id="select_all">
                            </div>
                        </td>
                        <td class="col-sm-3">
                            <div><b>Seleccionar bienes</b><span style="color:#d64161">*</span></div>

                            <?php
					$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['nIdBienes']); 
        			$valueB['nIdBienes'] = $this->encrypt->decode($enc_url); 
					
					$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['inventario']); 
        			$valueB['nInventarios'] = $this->encrypt->decode($enc_url); 
		 
					$ids = explode(',',$valueB['nIdBienes']);  $inventario = explode(',',$valueB['nInventarios']);       
					foreach($ids as $k => $val){?>
                            <label style="margin-right:15px;">
                                <input type="checkbox" class="n_inventario" name="select[]"
                                    value="<?php echo $val;?>">
                                <span class="no_bold">No. Inv.:</span>
                                <?php echo $inventario[$k];?></label>
                            <?php }?>

                        </td>
                        <!--td><div class="col-sm-12"><b>No. Inventarios</b></div><span class="titleTable"><?php echo $valueB['nInventarios']; ?></span></td-->
                        <td class="col-sm-2">
                            <div><strong>Descripción</strong></div>
                            <p><?php echo $valueB['DescripcionBien']; ?></p>
                        </td>
                        <td class="col-sm-2">
                            <div><strong>Motivo de baja</strong><span style="color:#d64161">*</span></div>
                            <div class="titleTable">
                                <?php $nOp = 'motMov_'.$key; echo form_dropdown('motMov[]', $catMotMov, '','class="form-control mot_b" rel="edo_b_'.$key.'"'); ?>
                            </div>

                        </td>
                        <td class="col-sm-2">
                            <div><strong>Estado</strong><span style="color:#d64161">*</span></div>
                            <div class="titleTable">
                                <?php $nOp = 'edoBien_'.$key; echo form_dropdown('edoBien[]', $opEdoBien, '','class="form-control edo_b_'.$key.'"'); ?>
                            </div>
                        </td>
                        <td class="t_9">
                            <div><strong>Evidencias <span style="color:#d64161">*</span></strong></div>
                            <!--input type="file" class="form-control" name="anexo[]" id="anexo[]"-->
                            <div>
                                <select name="anexos[]" class="anexos_agregar chosen-select2 form-control"
                                    data-placeholder="Seleccione Evidecia(s)"
                                    style="width:100%;min-width:350px; max-width:350px;" multiple tabindex="3">
                                    <?php echo $ANEXOS; ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <!--input type="text" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value="<?php echo $valueB['nIdBienes']; ?>" class="form-control"-->
                            <input type="hidden" maxlength="3" name="nIdBienes[]" id="values" class="i_b" value=""
                                class="form-control">
                            <input type="hidden" maxlength="3" name="maxBienes[]" id="maxBienes[]"
                                value="<?php echo $valueB['nBienes']; ?>" class="form-control">
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
            <div class="error" style="color: #d64161">* Campos obligatorios</div>
        </form>
        <script type="text/javascript">
        //CHECKBOX DE SELECCION DE TODOS

        /***** SECOND SELECT ALL TEST ***** */
        /* Functional code Don't delete. This get the object and not the values. 
        $('#select_all').change(function(){
            var check = $(this).closest('form').find(':checkbox');
            check.prop('checked', $(this).is(':checked'));
         
        });*/
        /*** END SECOND SELECT ALL TEST*** */

        $('.nInventarios').removeClass('nInventarios');
        $('.n_inventario').change(function(e) {
            valores = "";
            val = $(this).parent('label').parent('td').parent('tr').children('.t_9').children('.i_b').val();
            valores = (val != '') ? val.split(',') : [];
            v = $(this).val();
            if ($(this).is(':checked')) {
                if ($.inArray(v, valores) == -1) {
                    valores.push(v);
                    console.log(v);
                    console.log(valores);
                }
                $(this).parent('label').parent('td').parent('tr').children('.t_9').children('.i_b').val(valores
                    .toString())
            } else {
                //valores.splice($.inArray(v, val),1);
                val = val.replace(v + ',', '');
                val = val.replace(',' + v, '');
                val = val.replace(v, '');
                $(this).parent('label').parent('td').parent('tr').children('.t_9').children('.i_b').val(val)
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
        <script src="<?php echo INDEX_CP?>resources/js/check_all.js"></script>
    </div>
</div>