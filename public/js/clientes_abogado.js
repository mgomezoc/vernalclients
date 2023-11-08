/**
 * CLIENTES (ABOGADO)
 *
 */
const urls = {
    obtener: baseUrl + "clientes/obtener-abogado",
    asignar: baseUrl + "clientes/asignar-abogado",
    editar: baseUrl + "clientes/editar-cliente",
    borrar: baseUrl + "clientes/eliminar-cliente"
};

let $tablaClientes;
let $modalAsignarAbogado;
let tplAccionesTabla = "";
let tplEditarCliente = "";
let tplClienteSlug = "";
let tplNuevoCaso = "";

$(function () {
    setActiveMenu("clientes");
    tplAccionesTabla = $("#tplAccionesTabla").html();
    tplEditarCliente = $("#tplEditarCliente").html();
    tplClienteSlug = $("#tplClienteSlug").html();
    tplNuevoCaso = $("#tplNuevoCaso").html();
    $modalAsignarAbogado = $("#modalAsignarAbogado");

    $modalAsignarAbogado.find(".select2").select2({
        placeholder: "Seleccione una opción",
        dropdownParent: $modalAsignarAbogado,
        theme: 'bootstrap-5'
    });

    $modalAsignarAbogado.on("show.bs.modal", function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data("id");

        $("#idClienteAsignarAbogado").val(id_cliente);
    }).on("hide.bs.modal", function () {
        const $frm = $("#frmAsignarAbogado");
        $frm.find("input, select").attr("disabled", false);
        $frm[0].reset();
        $frm.find("select").trigger("change");
        $("#btnAsignarAbogado").attr("disabled", false);
    });

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: "GET",
        search: true,
        showRefresh: true,
        pagination: true,
        detailView: true,
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
        onExpandRow: function (index, row, $detail) {
            $detail.html("...cargando");
            console.log(row);
            const renderData = Handlebars.compile(tplNuevoCaso)(row);
            $detail.html(renderData);
        }
    });

    $("#btnAsignarAbogado").on("click", function () {
        $("#frmAsignarAbogado").trigger("submit");
    });

    $("#frmAsignarAbogado").on("submit", function (e) {
        e.preventDefault();
        const $frm = $(this);
        const data = $frm.serializeObject();

        if ($frm.valid()) {
            agregarAbogado(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire("¡Oops! Algo salió mal.", resultado.message, "error");
                    } else {
                        swal.fire("Listo", resultado.message, "success");
                        $tablaClientes.bootstrapTable("refresh");
                        $frm.find("input, select").attr("disabled", true);
                        $("#btnAsignarAbogado").attr("disabled", true);
                        $frm.find("select").trigger("change");
                        $modalAsignarAbogado.modal("hide");
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

function accionesTablaUsuarios(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);

    return renderData;
}

function agregarAbogado(data) {
    return $.ajax({
        type: "post",
        url: urls.asignar,
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

function formatoNombre(value, row, index, field) {
    console.log(row);
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}" target="_blank">${value}</a>`;
    return tpl;
}