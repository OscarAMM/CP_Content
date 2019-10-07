<!DOCTYPE html>
<html>

<head>
    <title>Calendario de Eventos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="sticky-footer.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="shortcut icon" media="all" type="image/x-icon"
        href="<?php echo INDEX_CP ?>resources/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-md-1">
                <div class="jumbotron text-white" style="background-color:#0D58A6">

                    <h4 class="display-4">Calendario de eventos próximos</h4>
                    <hr>
                    <p class="lead">Se presenta el calendario con todos los eventos agregados.</p>
                </div>
                <div class="row" style="width:60%">
                    <div class="col-md-12">
                        <div id="calendar" class="align-center"></div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 order-md-2 mb-4">

                <h4 class="mb-3">Agregar evento a calendario</h4>
                <div class="form-groups">
                    <?php echo form_open(INDEX_CP . 'calendario_agregar') ?>
                    <label for="title">Título del evento</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="start_date">Fecha de inicio</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date">Fecha de fin de evento</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
                <div class="form-group">
                    <a href="<?php echo INDEX_CP ?>" class="btn btn-primary">Regresar</a>
                    <a href="<?php echo INDEX_CP ?>calendario_eventos" class="btn btn-warning">Lista de eventos</a>
                    <input type="submit" value="Agregar" name="submit" class="btn btn-success">
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-md-4 order-md-3 alert alert-info">
                <h3 class="text-muted text-center">¡Información!</h3>
                <div class="card card-body">
                    <p>El siguiente apartado consta de tres secciones.
                        <ol>
                            <li>Calendario: El calendario se desplegará todos los eventos registrados, mientras exista
                                al menos un evento registrado.</li>
                            <li>Lista de eventos: Aquí se desplegará una lista con todos los eventos agregados en el
                                calendario</li>
                            <li>Agregar: Se puede agregar eventos al calendario. Todos los agregados aparecerá en el
                                calendario de arriba</li>
                        </ol>
                    </p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        var events = <?php echo json_encode($data) ?>;

        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            events: events
        })
        </script>
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