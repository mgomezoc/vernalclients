/**
 * 
 * CLIENTE
 * 
 */

let tplFormulario = "";

$(function () {
    tplFormulario = $("#tplFormulario").html();

    const renderData = Handlebars.compile(tplFormulario)(datos);

    $("#formulario_admision").html(renderData);
});