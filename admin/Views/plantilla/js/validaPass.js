$(document).ready(function(){
    $('#pass').complexify({},function(valid,complexify){
        console.log(valid,complexify)

        $(".progress-bar").css('width',complexify+'%');

        if(valid){
            $('.btnAgregar').prop('disabled',false);
            $('.progress-bar').addClass('bg-success').removeClass('bg-danger');
            $('.btnAgregar').attr('estado',true);
        }else{
            $('.btnAgregar').prop('disabled',true);
            $('.progress-bar').addClass('bg-danger').removeClass('bg-success');
            $('.btnAgregar').attr('estado',false);    
        }
    })
})