function rfcValido(rfc, aceptarGenerico = true) {
    const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var validado  = rfc.match(re);
    
    

    if (!validado)  //Coincide con el formato general del regex?
        return false; //false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
        rfcSinDigito = validado.slice(1).join(''),
        len = rfcSinDigito.length,

        //Obtener el digito esperado
        diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
        indice = len + 1;
    var suma,
        digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for (var i = 0; i < len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
        && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return "Válido";//rfcSinDigito + digitoVerificador + "VERDADERO";
}
//Handler para el evento cuando cambia el input
// -Lleva la RFC a mayúsculas para validarlo
// -Elimina los espacios que pueda tener antes o después
function validarInput(input) {
    var rfc = input.value.trim().toUpperCase(),
        resultado = document.getElementById("resultado"),
        valido;

    var rfcCorrecto = rfcValido(rfc);   // Acá se comprueba
    if(rfc.length == 12 || rfc.length==13 || rfc.length == 0 ||rfc.length >0){
    if (rfc == "") {
        valido = "Vacio";
        var vacio = "Ingrese un RFC";
        var correcciones = "Ingrese un RFC";
        resultado.classList.remove("ok");
        resultado.classList.remove("mal");
        resultado.classList.remove("captura");
        resultado.classList.add("none");
        $("#Aceptar").hide();
    } else if (rfcCorrecto) {
        valido = "Válido";
        resultado.classList.remove("mal");
        resultado.classList.remove("none");
        resultado.classList.remove("captura");
        resultado.classList.add("ok");
        $("#Aceptar").show();
    } else if(rfc.length < 13  ){
        valido = "Capturando";
        resultado.classList.remove("ok");
        resultado.classList.remove("none");
        resultado.classList.remove("mal");
        resultado.classList.add("captura");
        $("#Aceptar").hide();
    }else {
        valido = "No válido"
        correcciones = "Revisar el RFC"
        resultado.classList.remove("ok");
        resultado.classList.remove("none");
        resultado.classList.remove("captura");
        resultado.classList.add("mal");
        $("#Aceptar").hide();
        if (valido === "No válido" && input.value.length == 13) {
            alert("Ingrese un RFC correcto");
        }
    }
    
        if (rfcCorrecto) {
            resultado.innerText = "RFC: " + rfc
                //+ "\nResultado: " + rfcCorrecto
                + "\nFormato: " + valido;
        } else {
            resultado.innerText = "RFC: " + rfc
                //+ "\nResultado: " + rfcCorrecto
                + "\nFormato: " + valido
                + "\nCorrecciones: " + correcciones;
            if (rfcCorrecto != rfcCorrecto.valueOf("Válido")) {
                "\nCorrecciones: " + vacio;
            } else if(valido == "Capturando"){
                resultado.innerText = "RFC: "+rfc+"\nEstatus: "+ valido;
            }
        }
    }
   
}