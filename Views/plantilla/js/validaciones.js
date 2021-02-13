// Elementos a utilizar
import {registrar, validacionCadena } from "./funcionesValidacion";

// Validar Formulario registro
$("#createNewUsuario").validate
({
    rules:{
        createNombres:{
           required: true
        },
        createApellidos:{
           required: true
        },
        createTelefono:{
           required: true,
           number:true,
           minlength: 8
        },
        createDireccion:{
           required: true
        },
        createCedula:{
           required: true,
           minlength: 16
        },
        createUsuario:{
           required: true
        },
        createCorreo:{
           required: true,
           email: true
        },
        createPassword:{
           required: true
        },
        createPassword2:{
           equalTo:"#createPassword"
        }
    },
    messages:{
        createNombres:{
            required: "<p class='text-danger'>El campo es requerido</p>"
         },
         createApellidos:{
            required: "<p class='text-danger'>El campo es requerido</p>"
         },
         createTelefono:{
            required: "<p class='text-danger'>El campo es requerido</p>",
            number: "<p class='text-danger'>Ingrese un numero valido</p>",
            minlength: "<p class='text-danger'>como minimo 8 digitos</p>",
         },
         createDireccion:{
            required: "<p class='text-danger'>El campo es requerido</p>"
         },
         createCedula:{
            required: "<p class='text-danger'>El campo es requerido</p>",
            minlength: "<p class='text-danger'>Como maximo 16 caraceres usando (-)</p>",
         },
         createUsuario:{
            required: "<p class='text-danger'>El campo es requerido</p>"
         },
         createCorreo:{
            required: "<p class='text-danger'>El campo es requerido</p>",
            email: "<p class='text-danger'>Ingrese un correo valido</p>"
         },
         createPassword:{
            required: "<p class='text-danger'>El campo es requerido</p>"
         },
         createPassword2:{
            equalTo: "<p class='text-danger'>Las conraseñas no coinciden</p>"
         }
    }
});


$(document).ready(function(){
   // Validacion de los elementos que no se pueden repetir
   validacionCadena("#createCorreo","#errCor","registro/buscar","correo",registrar);
   validacionCadena("#createUsuario","#errNomUsu","registro/buscar","nombre_usuario",registrar);
   validacionCadena("#createCedula","#errCed","registro/buscar","cedula",registrar);
   validacionCadena("#createTelefono","#errTel","registro/buscar","telefono",registrar);

   //si pasa las validaciones al hacer submit permitimos el envio de los datos
   $("#createNewUsuario").on("submit", function(e){
      if(!registrar.correo && !registrar.nombreUsuario) return false;
      return true;
   })
   
})
