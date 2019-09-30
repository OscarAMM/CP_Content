var select_all = document.getElementById('select_all');
var checkboxes = document.getElementsByClassName('n_inventario');
var inputHidden = document.getElementById('nIdBienes[]');
var formulario = document.getElementById('iBienes');
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

/**** MÉTODO BUENO *** */
/*
formulario.addEventListener("click", function () {
    array = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked == true) {
            array.push(checkboxes[i].value);
            var arraySplited = array.join(", ");
            inputHidden.setAttribute('value', arraySplited);
            console.log(array);
        }
    }

});

*/
//Evento para el checkbox de todo. 
/* FUNCIONA PARA UNO CUANDO ES getById*/
/*
select_all.addEventListener("change", function (e) {
    array = [];
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = select_all.checked;
        array.push(checkboxes[i].value);
        var arraySplited = array.join(", ");
        if (this.checked == true) {
            inputHidden.setAttribute('value', arraySplited);
        }
        if (this.checked == false) {
            inputHidden.removeAttribute('value', arraySplited);
            array = [];
        }

    }
    //alert("Al seleccionar esta acción, se añadirá todos los bienes ¿Está seguro que desea continuar?");
    console.log(array);
    console.log(arraySplited);

});

*/


/***** Establece la condición del check *****/
/*
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function (e) {
        if (this.checked == false) {
            select_all.checked = false;
        }
        if (document.querySelectorAll('.n_inventario:checked').length == checkboxes.length) {
            select_all.checked = true;
        }
    });

}*/
