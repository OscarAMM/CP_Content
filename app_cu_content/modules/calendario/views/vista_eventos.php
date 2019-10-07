<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="shortcut icon" media="all" type="image/x-icon" href="<?php echo INDEX_CP ?>resources/images/favicon.ico">
    <title>Eventos</title>
</head>

<body>
    <div class="container-fluid">
        <div class="jumbotron">
            <h4 class="display-4">Eventos</h4>
            <p class="lead">Esta sección se encuentran todos los eventos listados en el calendario.</p>
        </div>
        <div> <a href="<?php echo INDEX_CP?>vista_calendario" class="btn btn-primary">Regresar</a>
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteAll" data-id="#"
                data-name="#">Eliminar</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del evento</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de fin</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <?php foreach($events as $key => $data):?>
                <tr class="events">
                    <td><?php echo $data->title?></td>
                    <td><?php echo $data->start_date?></td>
                    <td><?php echo $data->end_date?></td>

                </tr>
                <?php endforeach; ?>
                <?= $this->pagination->create_links();?>
            </tbody>
        </table>
    </div>

    <!--------------------------------------------------- MODAL ------------------------------------------------------>
    <div class="modal fade" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="deleteAllLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAllLabel">¡Atención! ¿Seguro que desea eliminar todos los datos?
                        <span></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>¡Al aceptar se borrarán todos los eventos de la base de datos!</p>
                        <p>¿Estás seguro que desea seguir?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="delete-p">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------END MODAL ------------------------------------------------------------->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
    </script>

    <!--------------------MODAL SCRIPT ------------------------------>
    <script>
    var id;
    var link;
    //We call the modal id and use the link from delete
    $('#deleteAll').on('show.bs.modal', function(event) {
        link = $(event.relatedTarget) // Button that triggered the modal
        var name = link.data('name')

        //We define a new var modal and we say to find the modal-title span and put the name that is define in the modal. 
        var modal = $(this)
        modal.find('.modal-title span').text(name)
        console.log(id)
        //    modal.find('.modal-body input').val(recipient)
        //We create a new function with ajax to look for the tr and td of the data we want to delete
        $('#delete-p').click(function() {
            $.ajax({
                url: "eliminar",
                context: document.body
            }).done(function(res) {
                //$(this).addClass("done");
                $('#deleteAll').modal('hide');
                //We call the parent (tr) and then the col (td) and we remove!
                $(link).parent().parent().parent().parent().children().children().children('.table').children('.tbody').children().remove().css({
                    "color": "red",
                    "border": "2px solid red"
                });
            });
        });
    })
    </script>
</body>
<footer class="footer">
    <div class="container">
        <span class="text-muted text-center">

            <p> © Todos los Derechos Reservados 2014 <br><a href="http://www.educacion.yucatan.gob.mx"
                    target="_blank">Secretaría de Educación del Gobierno del Estado Yucatán</a></p>

        </span>
    </div>
</footer>

</html>