const base = document.getElementById('base').getAttribute('value'),
fotoAdmin = document.getElementById('fotosAdmin').getAttribute('value'),
accesoSistema = document.getElementById('accesoSistema').getAttribute('value'),
clienteId = document.getElementById('clienteId').getAttribute('value');

let DB= [],
    copy = [],
    carrito = [],
    total = 0,
    getCarrito,
    count = 0;
let $carrito = document.querySelector('#carrito');
let $total = document.querySelector('#total');
let $botonVaciar = document.querySelector('#boton-vaciar');
let $items = document.querySelector('#items'),
    $badge = document.querySelector('.cant');

const getProductos = function(){
    $.ajax({
        url: base + "producto/generarProductos",
        type: "GET",
        async: false,
        success: function(resp) {

            let template = ``;
            let productos = JSON.parse(resp);
            
            copy.push(productos);
            copy[0].forEach(elem => DB.push(elem));

            
            productos.forEach((elem) => {
                template += `
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="${fotoAdmin}/productos/${elem['product_foto']}" alt="" />
                                <h2>C$ ${elem['product_precio']}</h2>
                                <p>${elem['product_descripcion']}</p>`;

                            if(accesoSistema)
                                template += `<button type="button" marcador="${elem['product_ID']}" class="btn btn-default add-a-proforma add"><i class="fa fa-shopping-cart"></i>Añadir a proforma</button>`;
                            else
                            
                            template += `<button type="button" class="btn btn-default add-a-proforma loginEntrar"><i class="fa fa-shopping-cart"></i>Añadir a proforma</button>`;
                template += `    
                            </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="${base}producto/showProducto/${elem['product_ID']}"><i class="fa fa-plus-square"></i> Ver detalle de productos</a></li> 
                            </ul>                                    
                        </div>
                    </div>
                </div>
                `;
            });

            $(".allProduct").html(template);
        }
    })
}

$(document).ready(function(){
    //Primera Ejecucion
    getProductos();

    // validamos la proforma para el acceso del sistema
    if(!accesoSistema) $('#proformaOcultar').hide();
    else $('#proformaOcultar').show();

    // Si no se ha registrado no podra agregar productos a la proforma
    $('.loginEntrar').on("click", () => swal.fire("Ingrese al sistema para poder agregar productos","","info"));

    //Creamos una variable de localStorage para almacenar los registros de los productos
    if(!localStorage.getItem('proforma')){localStorage.setItem('proforma','[]');}
    getCarrito = JSON.parse(localStorage.getItem('proforma'));

    //si encontramos productos en la localStorage la agregamos al la proforma
    if(getCarrito) getCarrito.forEach(elm => elm.forEach(el => {
        carrito.push(el['product_ID']);
    }))

    //al agregar productos a la proforma
    $(document).on("click", ".add", function(e){
        e.preventDefault();
        carrito.push(this.getAttribute('marcador'));
        calcularTotal();
        renderizarProforma();
        swal.fire('Se ha agregado el producto a la proforma','Exitosamente!!','success');
        $badge.innerHTML = countProduct();
    });

    //para vaciar la proforma
    $botonVaciar.addEventListener('click',function(){
        Swal.fire({
            title: '¿Desea eliminar todos los elementos de la proforma?',
            showDenyButton: true,
            confirmButtonText: `Si`,
            denyButtonText: `No`
        })
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                carrito = [];
                $badge.innerHTML = countProduct();
                calcularTotal();
                renderizarProforma();
                Swal.fire('Se han removido todos los elementos', 'Exitosamente', 'success');
            } else if (result.isDenied) {
                Swal.fire('No se realizo ninguna acción', '', 'info');
            }
        })
    })

    //ocultar la proforma y mostrarla
    $('.proformaToggle').on('click', function(){
        $('.Mostraocultar').toggle("slow");
    });
    
    //alamcenamos la cantidad de elementos que se han agregado a la proforma y los mostramos
    $badge.innerHTML = countProduct();
    calcularTotal();
    renderizarProforma();

    // al imprimirlo almacenarlo en la base de datos para recuperar los productos
    $("#imprimir").on('click', function(){
        let datos = JSON.parse($(this).attr('data-datos'));
        let imprimirPDF = [], idCliente = $("#clienteId").val();
        
        for (const item of datos) {
            let newElement = DB.filter(el => el['product_ID'] == item);
            imprimirPDF.push(newElement[0])
        }
  
        $.ajax({
            url: base + "producto/save",
            type: "POST",
            data: {imprimirPDF,clienteId},
            success: function(response){
                console.log("GOOD JOB");
                localStorage.clear();
                location.href = base + "home";
            }
        });

        window.open(base + `Views/plantilla/tcpdf/pdf/factura.php`,"imprimir"); 
       
    })

});

//funcion para contar los productos agregados a a proforma
function countProduct(){ return carrito.length; }

//calcula el precio total de los productos
function calcularTotal(){
    total = 0;
    localStorage.setItem("proforma",'[]');
    getCarrito = JSON.parse(localStorage.getItem('proforma'));

    for (let item of carrito) {
        let miItem = DB.filter(items =>{
            return items['product_ID'] == item;
        })

        getCarrito.push(miItem);
        localStorage.setItem("proforma",JSON.stringify(getCarrito));
        
        total += parseFloat(miItem[0]['product_precio']);
    }

    let totalDosDecimales = total.toFixed(2);
    $total.textContent = totalDosDecimales;

}

//muestra y crea los elementos que se mostraran en la proforma
function renderizarProforma(){
    $carrito.textContent = '';
    let proformaDuplicado = [...new Set(carrito)];

    proformaDuplicado.forEach((item, indice) => {
        let miItem = DB.filter(itemDB => itemDB['product_ID'] == item);

        let numeroUnidadesItem = carrito.reduce(function(total,itemId){
            return (itemId === item) ? total += 1 : total;
        },0);

        let miNodo = document.createElement('li');
        miNodo.classList.add('list-group-item','text-right','mx-2','font-black');
        miNodo.textContent = `${numeroUnidadesItem} x ${miItem[0]['product_nombre']} - C$ ${miItem[0]['product_precio']}`;

         // Boton de borrar
         let miBoton = document.createElement('button');
         miBoton.classList.add('btn', 'btn-danger', 'mx-5');
         miBoton.textContent = 'X';
         miBoton.style.marginLeft = '1rem';
         miBoton.setAttribute('item', item);
         miBoton.addEventListener('click', borrarItemCarrito);          

        miNodo.appendChild(miBoton);
        $carrito.appendChild(miNodo);
    })

    //Boton Imprimir
    let btnImprimir = document.getElementById('imprimir');
    btnImprimir.setAttribute('data-datos',JSON.stringify(carrito));
}

//borra elementos de la proforma 
function borrarItemCarrito() {
    Swal.fire({
        title: '¿Desea eliminar el elemento de la proforma?',
        showDenyButton: true,
        confirmButtonText: `Si`,
        denyButtonText: `No`
    })
    .then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // Obtenemos el producto ID que hay en el boton pulsado
            let id = this.getAttribute('item');
            // Borramos todos los productos
            carrito = carrito.filter(function (carritoId) {
                return carritoId !== id;
            });
            // volvemos a renderizar
            renderizarProforma();
            // Calculamos de nuevo el precio
            calcularTotal();
            $badge.innerHTML = countProduct();
            Swal.fire('Se han removido el elemento', 'Exitosamente', 'success');
        } else if (result.isDenied) {
            Swal.fire('No se realizo ninguna acción', '', 'info');
        }
    })
}
