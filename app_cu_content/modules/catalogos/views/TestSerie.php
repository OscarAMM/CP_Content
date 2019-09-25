<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="shortcut icon" media="all" type="image/x-icon"
        href="<?php echo INDEX_CP ?>resources/images/favicon.ico" />
    <link href="sticky-footer.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba</title>
</head>

<body>
    <main role="main" class="container">
        <div class="card">
            <div class="card-title text-center">
                <?php if($results == ''){
                echo "No se pudo encontrar!";
            } ?>
                <h4>Resultado de la búsqueda de la serie</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nombre Centro Trabajo</th>
                            <th>Descripción</th>
                            <th>ClaveCCT</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                        </tr>
                    </thead>
                    <?php foreach($results as $key => $res) :?>
                    <tr>
                        <th><?php echo $res->IdBien?></th>
                        <td><?php echo $res->NOMBRECT?></td>
                        <td><?php echo $res->CLAVECCT?></td>
                        <td><?php echo $res->DescripcionBien?></td>
                        <td><?php echo $res->MarcaBien?></td>
                        <td><?php echo $res->ModeloBien?></td>
                        <td><?php echo $res->SerieBien?></td>
                    </tr>
                    <?endforeach; ?>
                </table>
                <div class="card-footer">
                    <a href="<?php echo INDEX_CP?>bienes_adm" class="btn btn-primary">Regresar</a>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <span class="text-muted text-center">

                <p> © Todos los Derechos Reservados 2014 <br><a href="http://www.educacion.yucatan.gob.mx"
                        target="_blank">Secretaría de Educación del Gobierno del Estado Yucatán</a></p>

            </span>
        </div>
    </footer>
</body>


</html>