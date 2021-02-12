$(document).ready(function(){
    $(".chosen").chosen(); 
    // $(".productosFiltrados").isotope();
    
    $(document).on('click','.filtrar',function(){
        let filtro = $(this).attr('data-filter');
        
        $(".productosFiltrados").isotope({
            filter: filtro
        });
    })
})