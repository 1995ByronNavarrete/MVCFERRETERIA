// VARIABLES GLOBALS PARA LA VALIDACION DEL FORMULARIO
export const registrar = {correo : false, nombre_usuario : false, cedula : false, telefono: false};
let val = false;

export function buscarCoincidencia(input,valor, metodo, tipo){

    $.ajax({
        url: metodo,
        type: "POST",
        data: {valor,tipo},
        async: false,
        success: function(response){
           let res = JSON.parse(response);
            if(res){
                $(input).css({"borer":"red"});
                $(input).html(`<span class='text-danger m-5'>${tipo} ${valor.replace("_"," ")} Ya existe</span>`);
                val = true; 
             }else{
                $(input).html(`<span class='text-dark'>${(tipo.charAt()).toLocaleUpperCase() + tipo.substr(1).replace("_", " ")}*</span>`);
                val = false;
            }
        }
    });
 
    return val;
 }
 
export function validacionCadena(input,id,metodo,tipo,obj){
    $(input).on('keyup',function(e){
       e.preventDefault();
       
       let cadena = $(input).val();
       if(buscarCoincidencia(id,cadena,base+metodo,tipo)) obj[tipo] = false;
       else obj[tipo] = true;
   }) 
 }
