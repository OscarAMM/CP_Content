var select_all = document.getElementById('select_all');
var checkboxes = document.getElementsByClassName('n_inventario');
var inputHidden = document.getElementById('values');
var array = [];
//Evento para el checkbox de todo. 
select_all.addEventListener("change", function(e){
    for(i=0; i<checkboxes.length; i++){
        //Se agrega en un arreglo todos los objetos de checkbox
        checkboxes[i].checked = select_all.checked;
        //Se agrega el valor de cada checkbox en otro arreglo (array)
        array.push(checkboxes[i].value);
        //Se inicializa otro arreglo que separa por comas los valores del anterior arreglo
        var arraySplited = array.join(", ");
        //Se pasa el valor directo al input "hidden" con los valores separados por coma
        inputHidden.setAttribute('value', arraySplited);
    }
    //console.log(array);
    console.log(arraySplited);
    
});

/***** Establece la condición del check *****/
for(var i = 0;i<checkboxes.length; i++){
    checkboxes[i].addEventListener('change', function(e){
        if(this.checked == false){
            select_all.checked = false;
        }
        if(document.querySelectorAll('.n_inventario:checked').length == checkboxes.length){
            select_all.checked = true;
        }
    });
    
}
