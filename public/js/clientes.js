/**
 * CLIENTES
 *
 */
const urls = {
    obtener: baseUrl + "clientes/obtener-clientes",
    agregar: baseUrl + "clientes/agregar-cliente",
    editar: baseUrl + "clientes/editar-cliente",
    borrar: baseUrl + "clientes/eliminar-cliente"
};

let $tablaClientes;
let $modalNuevoCliente;
let tplAccionesTabla = "";
let tplEditarCliente = "";
let tplClienteSlug = "";

$(function () {
    setActiveMenu("clientes");
    tplAccionesTabla = $("#tplAccionesTabla").html();
    tplEditarCliente = $("#tplEditarCliente").html();
    tplClienteSlug = $("#tplClienteSlug").html();
    $modalNuevoCliente = $("#modalNuevoCliente");

    $modalNuevoCliente.find(".select2").select2({
        placeholder: "Seleccione una opción",
        dropdownParent: $modalNuevoCliente,
        theme: 'bootstrap-5'
    });

    $modalNuevoCliente.on("hide.bs.modal", function () {
        const $frm = $("#frmNuevoCliente");
        $frm.find("input, select").attr("disabled", false);
        $frm[0].reset();
        $frm.find("select").trigger("change");
        $("#clienteSlug").html("");
        $("#btnAgregarCliente").attr("disabled", false);
    });

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: "GET",
        search: true,
        showRefresh: true,
        pagination: true,
        iconsPrefix: 'fa-duotone',
        icons: {
            paginationSwitchDown: 'fa-caret-square-down',
            paginationSwitchUp: 'fa-caret-square-up',
            refresh: 'fa-sync',
            toggleOff: 'fa-toggle-off',
            toggleOn: 'fa-toggle-on',
            columns: 'fa-th-list',
            detailOpen: 'fa-circle-plus',
            detailClose: 'fa-circle-minus'
        },
    });

    $("#btnAgregarCliente").on("click", function () {
        $("#frmNuevoCliente").trigger("submit");
    });

    $("#frmNuevoCliente").on("submit", function (e) {
        e.preventDefault();
        const $frm = $(this);
        const data = $frm.serializeObject();

        if ($frm.valid()) {
            agregarCliente(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire("¡Oops! Algo salió mal.", resultado.message, "error");
                    } else {
                        swal.fire("Listo", resultado.message, "success");
                        $tablaClientes.bootstrapTable("refresh");
                        $frm.find("input, select").attr("disabled", true);
                        $("#btnAgregarCliente").attr("disabled", true);
                        $frm.find("select").trigger("change");
                        const renderData = Handlebars.compile(tplClienteSlug)(resultado.slug);
                        $("#clienteSlug").html(renderData);
                    }
                })
                .catch(function (error) {
                    swal.fire("¡Oops! Algo salió mal.", "Hubo un problema al agregar el usuario.", "error");
                });
        }
    }).validate();

    $(document).on("click", "#btnCopiarSlug", function () {
        const url = $("#linkSlug").prop("href");
        copyToClipboard(url);
    });
});

function formatoNombre(value, row, index, field) {
    console.log(row);
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}">${value}</a>`;
    return tpl;
}

function accionesTablaUsuarios(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);

    return renderData;
}

function agregarCliente(data) {
    return $.ajax({
        type: "post",
        url: urls.agregar,
        data: data,
        dataType: "json"
    });
}

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text)
            .then(function () {
                console.log('Texto copiado al portapapeles');
            })
            .catch(function (err) {
                console.error('No se pudo copiar el texto: ', err);
            });
    } else {
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    document.body.appendChild(textArea);

    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var message = successful ? 'Texto copiado al portapapeles' : 'Error al copiar el texto';
        console.log(message);
    } catch (err) {
        console.error('No se pudo copiar el texto: ', err);
    }

    document.body.removeChild(textArea);
}

