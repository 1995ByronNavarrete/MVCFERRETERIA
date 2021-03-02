$(document).ready(function(){
    const roles = ['admin'], d = document;
    const msjErrorPrivilegio = {msj:"No tienes los permisos suficientes para realizar esta acción",err:"Acceso Denegado!!!"};
    let rol = $("#rolAcceso").val();
    let Permiso = roles.includes(rol);
    let base = $("#base").val();

    const slider = function(){
        const $nextBtn = d.querySelector(".slider-btns .next"),
        $prevBtn = d.querySelector(".slider-btns .prev"),
        $slides = d.querySelectorAll(".slider-slide");
    
        let i = 0;
    
        d.addEventListener("click", e => {
            if(e.target === $prevBtn){
                e.preventDefault();
                $slides[i].classList.remove("active");
                i--;
    
                if(i < 0){
                    i = $slides.length - 1;
                }
    
                $slides[i].classList.add("active");
            }
    
            if(e.target === $nextBtn){
                e.preventDefault();
                $slides[i].classList.remove("active");
                i++;
    
                if(i >= $slides.length){
                    i = 0;
                }
    
                $slides[i].classList.add("active");
            }
        })
    }

     // Estadisticas generales de la empresa
     const getStatusPrincipal = function(){
        $.ajax({
            url: base + 'home/estadistica',
            type: 'GET',
            success: function(response){
                let datos = JSON.parse(response);
                $('.tra').html(datos.total_trabajadores);
                $('.cli').html(datos.total_cliente);
                $('.pro').html(datos.total_producto);
                $('.ven').html(datos.precio_t);
            }
        })
    }

    slider();

    const $slides = d.querySelectorAll(".slider-slide");
    let i = 0;

    setInterval(() => {
        $slides[i].classList.remove("active");
        i++;

        if(i >= $slides.length){i = 0}
        $slides[i].classList.add("active");
    },5000);

    getStatusPrincipal();

    // Actualizar registros de la empresa cada segundo
    setInterval(function(){
        getStatusPrincipal();
    },1000);
    
    //ACCIONES DE LOGIN

    // Validar Formulario login
    $("#form-login").validate
    ({
        rules:{
            password:{
                required: true,
                minlength: 3
            },
        },
        messages:{
            password:{
                required: "El password es requerido",
                minlength: "Tu contraseña debe tener 5 caracteres minimo"
            },
            required: "El campo es requerido"
        }
    });

    //----------- ACCIONES DE PRODUCTOS -------------------

    // Mostrar en el modal la informacion
    $(document).on("click",".editBoton",function(){
        const datos = JSON.parse($(this).attr("data-p"));

        $("#id").val(datos['product_ID']);
        $("#nombre").val(datos['product_nombre']);
        $("#descripcion").val(datos['product_descripcion']);
        $("#precio").val(datos['product_precio']);
        $("#nomImgAnt").val(datos['product_foto']);
        $("#proveedorname").val(datos['provee_nombre']);
        $("#img").attr("src", "http://localhost/MVCFERRETERIA/admin/Views/plantilla/img/productos/" + datos['product_foto']);
        $("#catActual").val(datos['cat_product_nombre']);
    });

    // Editar la informacion del Producto
    $(document).on("submit",".Editar",function(e){
        e.preventDefault();
        let datos = new FormData($(this)[0]);
        
        if(Permiso){
            $.ajax({
                url: base + "productos/edit",
                type: "post",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    $("#modalEditar").modal('hide');
                    Swal.fire('Producto Actualizado', '¡Correctamente!', 'success')
                    $(".nuevosProductos tbody").html(response)
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    });

    // Eliminar Producto
    $(document).on("click",".delBoton",function(){
        if(Permiso){
            const datos = JSON.parse($(this).attr("data-i"));
            let id = datos['product_ID'];
            let nomImg = datos['product_foto'];
            
            
            Swal.fire({
                title: '¿Desea Eliminar el producto?',
                showDenyButton: true,
                confirmButtonText: `Si`,
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
        
                    $.ajax({
                        url: base + "productos/eliminar",
                        type: "POST",
                        data: {id,nomImg},
                        success: function(response){
                            Swal.fire('Saved!', '', 'success')
                            $(".nuevosProductos tbody").html(response)
                        },
                        error: function(){
                            console.error("Error al eliminar");
                        }
                    })

                } else if (result.isDenied) {
                Swal.fire('Los cambios no se guardan', '', 'info')
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    });

      //------------ ACCIONES DE PROVEEDORES-------------------

    
    // Si se validan todos los campos del proveedor
    $.validator.setDefaults
    ({
		submitHandler: function() {
            if(Permiso){
                let datos = $('.addProv').serialize();
                
                $.ajax({
                    url: base + "proveedores/add",
                    type: "POST",
                    data: datos,
                    success: function(response){
                        $('.addProv')[0].reset();
                        Swal.fire('Proveedor Agregado', '¡Correctamente!', 'success')
                        $('.Proveedores tbody').html(response);
                    }
                });

            }else{
                swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
            }
		}
    });

     // Validar Formulario login
     $("#addProv").validate
     ({
         rules:{
             nombreProv:{
                required: true
             },
             direccionProv:{
                required: true
             },
             telefonoProv:{
                required: true
             }
         },
         messages:{
             nombreProv:{
                required: "El campo nombre es requerido",
            }, direccionProv:{
                required: "El campo direccion es requerido"
            },
            telefonoProv:{
                required: "El campo telefono es requerido"
            }
         }
     });

    // Visualizar Proveedor
    $(document).on('click','.editProv',function(){
        let prov = JSON.parse($(this).attr('data-p'));
        $('#idProv').val(prov['provee_ID']);
        $('#nombrePro').val(prov['provee_nombre']);
        $('#direccionPro').val(prov['provee_direccion']);
        $('#telefonoPro').val(prov['provee_telefono']);
    });

    // Actualizar el Proveedor
    $('.editarProveedor').on('submit',function(e){
        e.preventDefault();
       
        if(Permiso){
            const datos = {
                id: $('#idProv').val(),
                nombre: $('#nombrePro').val(),
                direccion: $('#direccionPro').val(),
                telefono: $('#telefonoPro').val()
            }

            $.ajax({
                url: base + 'proveedores/update',
                type: 'POST',
                data: datos,
                success: function(response){
                    $("#ProveedorShowModal").modal('hide');
                    $('.editarProveedor')[0].reset();
                    Swal.fire('Proveedor Actualizado', '¡Correctamente!', 'success')
                    $('.Proveedores tbody').html(response);
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

    // Eliminar Proveedor
    $(document).on("click", ".ElimProv", function(){
        if(Permiso){
            let data = JSON.parse($(this).attr("data-i")), id = data['provee_ID'];

            $.ajax({
                url: base + "proveedores/eliminar",
                type: "post",
                data: {id},
                success: function(response){
                    if(response == 1) Swal.fire("Advertencia","No se puede eliminar el proveedor ya que esta siendo referenciado con algunos productos","warning");
                    else{
                        Swal.fire("Proveedor Eliminado", "¡Correctamente!","success");
                        $(".Proveedores tbody").html(response);
                    }
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

    //------------ ACCCIONES DE TRABAJADORES ---------------

    // Si se validan todos los campos
    $.validator.setDefaults
    ({
		submitHandler: function() {
            if(Permiso){
                let datos = $('#AddTrabajador').serialize();
                console.log(datos)
                $.ajax({
                    url: base + "usuario/addUser",
                    type: "POST",
                    data: datos,
                    success: function(response){
                        swal.fire("Usuario Agregado","Exitosamenre!","success");
                        $(".trabaja tbody").html(response)
                        $('#AddTrabajador')[0].reset();
                    }
                });
            }else{
                swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
            }
		}
    });
    
    // Validar formulario de ingreso de trabajador
    $('.registro-trabajador').validate
    ({
        rules: {
            nombre:{
                required: true,
                minlength: 3
            },
            apellido:{
                required: true,
                minlength: 4
            },
            nombreUsuario:{
                required: true,
                minlength: 6
            },
            direccion:{
                required: true
            },
            telefono:{
                required: true
            },
            correo: {
                required: true,
                email: true
            }
        },
        messages: {
            nombre:{
                required: "El campo nombre es requerido",
                minlength: "Porfavor ingrese mas de 3 caracteres"
            },
            apellido:{
                required: "El campo apellido es requerido",
                minlength: "Porfavor ingrese mas de 4 caracteres"
            },
            nombreUsuario: {
                required: "El campo es requerido",
                minlength: "Porfavor ingrese 6 caracteres o mas"
            },
            correo: "Porfavor Ingrese un correo valido"
        }
    });

    // Validar que el nombre de usuario no se repita
    $('#nombreUsuario').on('keyup',function(){
        let usuNam = $(this).val();
        BuscarUserNameIgual(usuNam,base);
    })

    // Validar que el Correo de usuario no se repita
    $('#correo').on('keyup',function(){
        let correo = $(this).val();
        BuscarCorreo(correo,base);
    })

    // Mostrar informacion del trabajador en modal
    $(document).on('click','.showTra',function(){
        let trabajador = JSON.parse($(this).attr('data-informacion'));
        let ruta = $(this).attr('data-ruta') + 'img/users/default.jpg';
      console.log(trabajador)
        $('#nomTra').html(trabajador.admin_nombre);
        $('#apeTra').html(trabajador.admin_apellido);
        $('#nUsTra').html(trabajador.admin_usuario);
        $('#corTra').html(trabajador.admin_correo);
        $('#rolTra').html(trabajador.rol_nombre);
        $('#dirTra').html(trabajador.admin_direccion);
        $('#telTra').html(trabajador.admin_telefono);
        $('#imgTra').attr('src',ruta);

        $('#numWhat').attr('title',trabajador.telefono);
        console.log(trabajador)
    })

    // Mostrar informacion para actualizar del trabajador
    $(document).on('click','.updateTra',function(){

        let trabajador = JSON.parse($(this).attr('data-trabajador'));

        $('#updid').attr('value',trabajador.admin_ID);
        $('#updnombre').attr('value',trabajador.admin_nombre);
        $('#updapellido').attr('value',trabajador.admin_apellido);
        $('#updnombreUsuario').attr('value',trabajador.admin_usuario);
        $('#upddireccion').attr('value',trabajador.admin_direccion);
        $('#updtelefono').attr('value',trabajador.admin_telefono);
        $('#updcorreo').attr('value',trabajador.admin_correo);
        $('#updrol').attr('value',trabajador.roles_rol_ID);
    })

    $(document).on('submit','.updateTrabajador',function(e){
        e.preventDefault();
        if(Permiso){
            let datos = $(this).serialize();

            console.log(datos)
            $.ajax({
                url: base + "usuario/update",
                type: "POST",
                data: datos,
                success: function(response){
                    $("#updateTrabajadorModal").modal('hide');
                    $('.updateTrabajador')[0].reset();
                    Swal.fire('Trabajador Actualizado', '¡Correctamente!', 'success')
                    $(".trabaja tbody").html(response);
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

    $(document).on('click','.deleteTra',function(){
        if(Permiso){
            let eliminar = $(this).attr('data-eliminar');
           
            Swal.fire({
                title: '¿Desea Eliminar el Trabajador?',
                showDenyButton: true,
                confirmButtonText: `Si`,
                denyButtonText: `No`,
            })
            .then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: base + "usuario/eliminar",
                        type: "POST",
                        data: {eliminar},
                        success: function(response){
                            Swal.fire('Trabajador Eliminado', 'Exitosamente!!', 'success')
                            $(".trabaja tbody").html(response)
                        },
                        error: function(){
                            console.error("Error al eliminar");
                        }
                    })

                } else if (result.isDenied) {
                Swal.fire('No se realizo ninguna acción', '', 'info')
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

      //----------- ACCIONES PARA LOS SERVICIOS -------------

            $.validator.setDefaults
            ({
                submitHandler: function() {
                    if(Permiso){
                        const datos = {
                            servicio : $('#servicio').val(),
                            descripcion : $('#serdescripcion').val()
                        }
                    
                        let acceso = $('#acc').val();

                        if(acceso === 'admin'){
                            $.ajax({
                                url: base + 'servicios/addService',
                                type: 'POST',
                                data: datos,
                                success: function(response){
                                    swal.fire('Se ha agregado un servicio nuevo','correctamente','success');
                                    $('.addServicio')[0].reset();
                                    $('.servicioDatos tbody').html(response);
                                }
                            })
                        }else{
                            swal.fire('No tienes los permisos suficientes para realizar esta accion','','info');
                            $('.addServicio')[0].reset();
                        }
                    }else{
                        swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
                    }
                }
            });
        
            $('#validarServicio').validate({
                rules:{
                    servicio: {
                        required : true
                    },
                    descripcion:{
                        required:true
                    }
                },
                message : {
                    servicio: {
                        required: 'El campo Servicio es requerido'
                    },
                    descripcion:{
                        required: 'El ccampo Descripcion es requerido'
                    }
                }
            });
  
      //Eliminar Servicio
      $(document).on('click','.elimServicio',function(e){
          e.preventDefault();

        if(Permiso){
            let id = $(this).attr('data-id');
           
            Swal.fire({
                 title: '¿Desea Eliminar el Servicio?',
                showDenyButton: true,
                confirmButtonText: `Si`,
                denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: base + 'servicios/delete',
                        type: 'POST',
                        data: {id},
                        success: function(response){
                            swal.fire('Se ha eliminado el servicio','correctamente','success');
                            $('.servicioDatos tbody').html(response);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('No se realizo ninguna acción', '', 'info')
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
            // }else{
            //     swal.fire('No tienes suficientes privilegios para realizar esta accion','','info');
            // }
      })
  
      // Actualizar y mostra en el modal la informacion del servicio
      $(document).on('click','.editServicio',function(){
          let servicio = JSON.parse($(this).attr('data-servicio'));
          let urlImg = base + "Views/plantilla/img/servicios/" +servicio.ser_img;
          $('#idSer').val(servicio.ser_id);
          $('#img').val(servicio.ser_img);
          $('#updServicio').val(servicio.ser_nombre);
          $('#updDescripcionSer').val(servicio.ser_descripcion);
          $('#imagen').attr("src",urlImg)
         
      })

      //Actualizar Servicio
    $('.editarServicio').on('submit',function(e){
          e.preventDefault();
        if(Permiso){

            let datos = {
                id:  $('#idSer').val(),
                servicio: $('#updServicio').val(),
                descripcion: $('#updDescripcionSer').val()
            }
    
            $.ajax({
                url: base + 'servicios/updServicio',
                type: 'POST',
                data: datos,
                success: function(response){
                    swal.fire('Se ha actuaizado el servicio','correctamente','success');
                    $('#ServiciosShowModal').modal('hide');
                    $('.editarServicio')[0].reset();
                    $('.servicioDatos tbody').html(response);
                }
            });
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

    // ACCIONES DE LAS CATEGORIAS

    $(document).on("click",".edtCat",function(){
        let datos = JSON.parse($(this).attr('data-p'));
        $('#idCat').val(datos['cat_product_ID']);
        $('#updCategoriaNom').val(datos['cat_product_nombre']);
        $('#updCategoriaDesc').val(datos['cat_product_descripcion']);
    });

    $(document).on("submit",".editarCategoria",function(e){
        e.preventDefault();
        
        if(Permiso){
           
            let datos = {
                "id" : $('#idCat').val(),
                "nombre" :$('#updCategoriaNom').val(),
                "descripcion" : $('#updCategoriaDesc').val()
            };
            
            $.ajax({
                url: base + "categoria/actualizar",
                type: "POST",
                data: datos,
                success: function(response) {
                    $(".editarCategoria")[0].reset();
                    $("#CategoriaShowModal").modal('hide');
                    $(".newCategorias tbody").html(response);
                    swal.fire("Se ha modificado su categoria","Exitosamente!!","success");
                }
            });
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    });

    $(document).on("click", ".delCat", function(e){
        let idDel = JSON.parse($(this).attr("data-del"));
        if(Permiso){
            Swal.fire({
                 title: '¿Desea Eliminar la categoria?',
                showDenyButton: true,
                confirmButtonText: `Si`,
                denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: base + "categoria/delete",
                        type: "POST",
                        data: {id: idDel.cat_product_ID},
                        success: function(response){
                            swal.fire('Se ha eliminado la Categoria','correctamente','success');
                            $(".newCategorias tbody").html(response);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('No se realizo ninguna acción', '', 'info')
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }

       
    })


    // Acciones para las sucursales

    $(document).on("click", ".delSuc", function(e){
        
        let id = JSON.parse($(this).attr("data-id"));
        if(Permiso){
            Swal.fire({
                 title: '¿Desea Eliminar la categoria?',
                showDenyButton: true,
                confirmButtonText: `Si`,
                denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {   
                    $.ajax({
                        url: base + "sucursal/deleteSucursal",
                        type: "POST",
                        data: {id : id.sucursal_ID},
                        success: function(response){
                            swal.fire('Se ha eliminado la Categoria','correctamente','success');
                            $(".sucursalCuerpo tbody").html(response);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('No se realizo ninguna acción', '', 'info')
                }
            })
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    });

    $(document).on("click",".editSuc", function(e){
        const $form = document.querySelector("#sucursalFormEdit");
        let d = JSON.parse($(this).attr("data-p"));
        $form.nombreSucE.value = d.sucursal_nombre;
        $form.idSucE.value = d.sucursal_ID;
        $form.correoSucE.value = d.sucursal_correo;
        $form.direccionSucE.value = d.sucursal_direccion;
        $form.telefonoSucE.value = d.sucursal_telefono;
    });

    $("#sucursalForm").on("submit",function(e){
        e.preventDefault();

        if(Permiso){
            let datos = $("#sucursalForm").serialize();
            
            $.ajax({
                url: base + 'sucursal/addSucursal',
                type: 'POST',
                data: datos,
                success: function(response){
                    swal.fire('Se ha agregado una nueva sucursal','Correctamente','success');
                    $("#sucursalForm")[0].reset();
                    $(".sucursalCuerpo tbody").html(response);
                }
            });
        }else{
            swal.fire(msjErrorPrivilegio.msj,msjErrorPrivilegio.err,'info');
        }
    })

    $("#sucursalFormEdit").on("submit",function(e){
        e.preventDefault();
        
        let datos = $("#sucursalFormEdit").serialize();
        $.ajax({
            url: base + 'sucursal/updSucursal',
            type: 'POST',
            data: datos,
            success: function(response){
                swal.fire('Se ha Actualizado la sucursal','Correctamente','success');
                $("#sucursalFormEdit")[0].reset();
                $("#modalEditarSucursal").modal("hide");
                $(".sucursalCuerpo tbody").html(response);
            }
        });
        
    })

    // Acciones del perfil
    $(".perfilUser").on("submit",function(e){
        e.preventDefault();
        let datos = $(".perfilUser").serialize();

        $.ajax({
            url: base + "usuario/actualizarPerfil",
            method: "POST",
            data: datos,
            success: function(res){
                console.log(JSON.parse(res));
                swal.fire("Para Realizar los cambios se cerrara la sesion","Obligatorio","info");
                setTimeout(() =>{
                    window.location.href = base + "login/salir";
                },4000)
                
            }
        });
    });
});

//Funcion para buscar coincidencia en los nombres de usuarios
function BuscarUserNameIgual(nombre, base){
    $.ajax({
        url: base + "usuario/buscar",
        type: "POST",
        data: {nombre},
        success: function(response){
            console.log(response)
            if(response == 1){
                $(".repetido").html('<p class="text-danger">Nombre de usuario ya existe</p>');
                $("#btnAgregarUsu").attr('type','button');
            }else{
                $(".repetido").html('');
                $("#btnAgregarUsu").attr('type','submit');
            }
        }
    });
}

// Buscar coincidencia de correo
function BuscarCorreo(correo, base){
    $.ajax({
        url: base + "usuario/buscarCorreo",
        type: "POST",
        data: {correo},
        success: function(response){
            console.log(response)
            if(response == 1){
                $(".repetidoCorreo").html('<p class="text-danger">El correo ya existe</p>');
                $("#btnAgregarUsu").attr('type','button');
            }else{
                $(".repetidoCorreo").html('');
                $("#btnAgregarUsu").attr('type','submit');
            }
        }
    });
}
