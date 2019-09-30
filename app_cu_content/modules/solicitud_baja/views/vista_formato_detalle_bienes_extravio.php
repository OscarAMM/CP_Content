<div class="panel panel-danger">
    <div class="panel-heading"><b>Bienes seleccionados: </b></div>
    <div class="panel-body">
        <form method="POST" name="incluirBienes" enctype="multipart/form-data">
            <table id="iBienes" class="table">
                <!--thead>
	          <tr><th>Cant.</th><th width="18%">No. Inventarios</th><th>Descripción</th><th>Estado Actual</th><th>Motivo de baja</th><th>Anexos <imp src="<?php echo INDEX_CP;?>resources/images/info.png" title="Documentos de soporte para la baja de bienes"></th></tr>
	        </thead-->
                <?php foreach ($datosBienes as $key => $valueB) { ?>
                <tr>
                    <!--td><div class="col-sm-12"><b>Cant.</b></div><span class="titleTable"><input type="text" maxlength="3" name="nBienes[]" id="nBienes[]" <?php if($valueB['nBienes'] == 1) echo 'disabled'; ?> value="<?php echo $valueB['nBienes']; ?>" class="w50 form-control"></span-->
                    <td style="max-width: 365px;">
                        <div class="col-sm-12"><b>Seleccione que bienes desea dar de baja:</b></div>
                        <?php
					$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['nIdBienes']); 
        			$valueB['nIdBienes'] = $this->encrypt->decode($enc_url); 
					
					$enc_url=str_replace(array('-', '_', '~'),array('+', '/', '='), $valueB['inventario']); 
        			$valueB['nInventarios'] = $this->encrypt->decode($enc_url); 
		 
					$ids = explode(',',$valueB['nIdBienes']);  $inventario = explode(',',$valueB['nInventarios']);?>
                        <ul>
                            <li class="main-parent">
                                <label>Seleccionar todo:</label>
                                <input type="checkbox" name="select_all" id="select_all" class="main-checkbox">
                                <?php
					foreach($ids as $k => $val){?>
                                <label style="margin-right:15px;">
                                    <ul>
                                        <li>
                                            <input type="checkbox" class="n_inventario" value="<?php echo $val;?>">
                                            <span class="no_bold">No. Inv.:</span><?php echo $inventario[$k];?>
                                        </li>
                                    </ul>
                                </label>
                                <?php }?>
                            </li>
                        </ul>
                    </td>
                    <!--td><div class="col-sm-12"><b>No. Inventarios</b></div><span class="titleTable"><?php echo $valueB['nInventarios']; ?></span></td-->
                    <td>
                        <div class="col-sm-12"><b>Descripción</b></div><span
                            class="titleTable"><?php echo $valueB['DescripcionBien']; ?></span>
                    </td>
                    <td style="display:none">
                        <div class="col-sm-12"><b>Motivo de baja* </b></div><span class="titleTable"><input
                                type="hidden" name="motMov[]" value="17"></span>
                    </td>
                    <td class="t_9">
                        <input type="text" maxlength="3" name="nIdBienes[]" id="nIdBienes[]" class="i_b" value=""
                            class="form-control">
                        <input type="hidden" maxlength="3" name="maxBienes[]" id="maxBienes[]"
                            value="<?php echo $valueB['nBienes']; ?>" class="form-control">
                    </td>
                </tr>
                <?php } ?>
            </table>
            <div class="error">* Campos obligatorios</div>
        </form>
        <script src="<?php echo INDEX_CP?>resources/js/check_all.js"></script>
    </div>
</div>