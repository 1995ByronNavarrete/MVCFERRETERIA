$(document).ready(function(){
    $.mask.definitions['~'] = "[+-]";

    // mascaras para trabajadores
    $('.telefonoTra').mask("+999 9999-9999");
   
    // $("input").blur(function() {
    //     $("#info").html("Unmasked value: " + $(this).mask());
    // }).dblclick(function() {
    //     $(this).unmask();
    // });
})