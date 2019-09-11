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

.disabled {
    cursor: not-allowed !important
}

#tableIconos3 tr td {
    text-align: center
}
</style>
<input type="hidden" value="<?php echo $token ?>" id="token">
<input type="hidden" value="<?php echo $perfil ?>" id="perfil"> 
<!--div class="alert alert-warning"><img src="<?php echo INDEX_CP ?>resources/images/info.png" class='icon24' alt='Info'><span>Listado de todos los Bienes en el Sistema</span></div-->
<div class="alert alert-info form-inline col-sm-6">
    <div class="form-group mb-2">
        <label>Busque clave centro de trabajo:</label>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" maxlength="200" id="claveCCT" class="form-control" value=""></div>

    <?php //<div class="form-group"><label>Turno:</label><br><select name="turno" id="turno" class="form-control"><option value="0">Seleccione</option></select></div> ?>
    <div class="form-group"><button id="buscar" class="btn btn-success">Buscar</button>
    </div>
</div>
<div class="alert alert-warning form-inline col-sm-6">
    <div class="form-group mb-2">
        <label class="label-form-col">Busque por No.Serie</label>
       <!--  PHP INDEX_CP/Nombre de la ruta/En la ruta se pone controlador/función del controlador --->
    </div>
    
        <div class="form-group mx-sm-3 mb-2">
        <?php echo form_open(INDEX_CP.'SerieSearch') ?> <!--- This works --->
            <input type="text" name="search" id ="search" class="form-control">
        </div>
        <input type="submit" value="Buscar" name="submit" class="btn btn-success">
    <?php echo form_close()?>

</div>
<!--- NEW SEARCH FOR SERIE NUMBER ---------------------------------------->

<!-------------------------END NEW SECTION-------------------------------->
<!--div class="alert alert-warning form-inline col-sm-6">
        <a target="_blank" href="javascript:reporteBienes();" class="btn btn-success" style="font-size:20px"><span class="glyphicon glyphicon-list"></span> Reporte de <b>Bienes</b> Excel</a>
    </div-->
<div style="clear:both"></div>
<table id="tablaBienes"></table>
<div id="paginacionBienes"></div>

<!---------------------------------------------------------->

<script type="text/javascript" src="<?php echo INDEX_CP ?>resources/js/gestionBienes.js"></script>
