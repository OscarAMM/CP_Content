var select_all = document.getElementById('select_all');
var checkboxes = document.getElementsByClassName('n_inventario');
var inputHidden = document.getElementById('nIdBienes[]');
var array = [];


function verificar() {
    array = [];
    inputHidden.setAttribute('value', "");
    for (var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked == true){
            console.log("Hola");
            array.push(checkboxes[i].value);
            var arraySplited = array.join(", ");
            console.log(arraySplited);
            inputHidden.setAttribute('value', arraySplited);
        }
        
    }


    console.log(array);
}

//Evento para el checkbox de todo. 
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
    console.log(array);
    console.log(arraySplited);

});

/***** Establece la condición del check *****/
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function (e) {
        if (this.checked == false) {
            select_all.checked = false;
        }
        if (document.querySelectorAll('.n_inventario:checked').length == checkboxes.length) {
            select_all.checked = true;
        }
    });

}
