const obtenerSucursal = function(){
    $.ajax({
        url: base + "home/getSucursalActual",
        type: "GET",
        success: function(response){ 
            let template = '';
            let suc = JSON.parse(response);
            console.log(suc)
            suc.forEach(e => {
                    template += `<li class="breadcrumb-item"><a href="#" id="${e['sucursal_ID']}">${e['sucursal_nombre']}</a></li> `;
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

obtenerSucursal();
getActualSucursal();