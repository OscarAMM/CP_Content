<div class="panel panel-primary">
    <div class="panel-heading"><b>Bienes seleccionados: </b></div>
    <div class="panel-body">
        <form method="POST" name="incluirBienes" enctype="multipart/form-data">
            <table id="iBienes" class="table">
                <?php foreach ($datosBienes as $key => $valueB) { ?>
                <tbody>
                    <tr>
                        <!--td><div class="col-sm-12"><b>Cant.</b></div><span class="titleTable"><input type="text" maxlength="3" name="nBienes[]" id="nBienes[]" <?php if($valueB['nBienes'] == 1) echo 'disabled'; ?> value="<?php echo $valueB['nBienes']; ?>" class="w50 form-control"></span-->
                        <td class="col-sm-3">
                            <div><b>Seleccionar bienes</b><span style="color:#d64161">*</span></div>
                            <?php 					
							$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['nIdBienes']); 
							$valueB['nIdBienes'] = $this->encrypt->decode($enc_url); 
							
							$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['inventario']); 
							$valueB['nInventarios'] = $this->encrypt->decode($enc_url); 
							
							$ids = explode(',',$valueB['nIdBienes']);  
							$inventario = explode(',',$valueB['nInventarios']); ?>
                            <ul>
                                <li class="main-parent">
                                    <label>Seleccionar todo</label>
                                    <input type="checkbox" class="main-checkbox" name="select_all" id="select_all">
                                    <br>
                                    <?php
							foreach($ids as $k => $val){?>
                                    <label style="margin-right:15px;">
                                        <ul>
                                            <li>
                                                <input type="checkbox" class="n_inventario" id="n_inventario" name="select[]"
                                                    value="<?php echo $val;?>">
                                                <span class="no_bold">No. Inv.:
                                                </span><?php echo $inventario[$k];?>
                                            </li>
                                        </ul>
                                    </label>
                                    <?php }?>
                                </li>
                            </ul>
                        </td>
                        <!--td><div class="col-sm-12"><b>No. Inventarios</b></div><span class="titleTable"><?php echo $valueB['nInventarios']; ?></span></td-->
                        <td class="col-sm-2">
							<div><b>Descripción</b></div>
                            <p><?php echo $valueB['DescripcionBien']; ?></p>
                        </td>
                        <td class="col-sm-2">
                            <div><b>Estado</b> <span style="color:#d64161">*</span></div>
                            <div class="titleTable">
                                <?php $nOp = 'edoBien_'.$key; echo form_dropdown('edoBien[]', $opEdoBien, '','class="form-control edo_b_'.$key.'"'); ?>
                            </div>
                        </td>
                        <td class="col-sm-2">
                            <div><strong>Motivo</strong> <span style="color:#d64161">*</span></div>
                            <div
                                class="titleTable"><?php $nOp = 'motMov_'.$key; echo form_dropdown('motMov[]', $catMotMov, '28','class="form-control mot_b" rel="edo_b_'.$key.'"'); ?></div>
                        </td>
                        <td class="t_9" style="max-width:215px;">
                            <div><b>Evidencias</b> <span style="color:#d64161">*</span></div>
                            <!--input type="file" class="form-control" name="anexo[]" id="anexo[]"-->
                            <select name="anexos[]" class="anexos_agregar chosen-select2 form-control"
                                data-placeholder="Seleccione Evidecia(s)"
                                style="width:100%;min-width:350px; max-width:350px;" multiple tabindex="3">
                                <?php echo $ANEXOS; ?>
                            </select>
                            <div class="clearfix"></div>
                            <!--input type="text" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value="<?php echo $valueB['nIdBienes']; ?>" class="form-control"-->
                            <input type="hidden" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value=""
                                class="form-control">
                            <input type="hidden" maxlength="3" name="maxBienes[]" id="maxBienes[]"
                                value="<?php echo $valueB['nBienes']; ?>" class="form-control">
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
            <div class="error">* Campos obligatorios</div>
		</form>
		<script src="<?php echo INDEX_CP ?>resources/js/check_all.js"></script>
        <script type="text/javascript">
        
        $(".chosen-select2").chosen({
            width: "100%",
            html_template: '<img style="margin-right: 5px; width: 50px; border: 2px solid black;" class="{class_name}" src="{url}" />'
        });
        $(".mot_b").change(function(e) {
            edo = $(this).attr('rel');
            $('.' + edo).removeAttr('disabled');
            if ($(this).val() == 16) {
                $('.' + edo).val(5);
                $('.' + edo).attr('disabled', 'disabled');
            }
            if ($(this).val() == 17) {
                $('.' + edo).val(7);
                $('.' + edo).attr('disabled', 'disabled');
            }
        });
        $(".mot_b").attr("disabled", "disabled");
        </script>
    </div>
</div>