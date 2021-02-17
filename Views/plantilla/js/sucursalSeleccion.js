const obtenerSucursal = function(){
    $.ajax({
        url: base + "home/getSucursalActual",
        type: "GET",
        success: function(response){ 
            let template = '';
            let suc = JSON.parse(response);
            suc.forEach(e => {
                    template += `<li class="breadcrumb-item"><a href="#" class="sucCam" id="${e['sucursal_ID']}">${e['sucursal_nombre']}</a></li> `;
            })
            
            $("#sucursalMostrar").html(template);
        }
    });
}

const getActualSucursal =  function(){
    $.ajax({
        url: base + "home/getSuc",
        type: "GET",
        success: function(response){ 
            let sucursalActual = JSON.parse(response);
            $("#telefonoSucursal").html(sucursalActual['sucursal_telefono']);
            $("#correoSucursal").html(sucursalActual['sucursal_correo']);
            $("#nameSucursal").html(sucursalActual['sucursal_nombre']);
            $("#nameSucursal").css({"font-size":"20px","padding-left":"20px","color":"#000","font-weight":"bold"})
        }
    });
}

$(document).on("click", ".sucCam", function(){
    let idSuc = $(this).attr("id");

    $.ajax({
        url: base + "home/cambioSucursal",
        type: "POST",
        data:{idSuc},
        success: function(){
            location.href = "home";
        }
    })
})

obtenerSucursal();
getActualSucursal();