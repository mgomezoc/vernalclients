/**
 * SUCURSALES
 */
const urls = {
    obtener: "sucursales/obtener-sucursales",
    agregar: "sucursales/agregar-sucursal",
    editar: "sucursales/editar-sucursal",
    borrar: "sucursales/eliminar-sucursal"
};

let tplAccionesTabla = "";
let tplEditarSucursal = "";
let $tablaSucursales;
let $modalNuevaSucursal;

$(function () {
    setActiveMenu("sucursales");

    tplAccionesTabla = $("#tplAccionesTabla").html();
    tplEditarSucursal = $("#tplEditarSucursal").html();
    $modalNuevaSucursal = $("#modalNuevaSucursal");

    $tablaSucursales = $("#tablaSucursales").bootstrapTable({
        url: urls.obtener,
        method: "GET",
        search: true,
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
            const sucursales = $tablaSucursales.bootstrapTable("getData");
            const sucursal = encontrarSucursalPorId(sucursales, row.id);
            const renderData = Handlebars.compile(tplEditarSucursal)(sucursal);
            $detail.html(renderData);
            $detail.find(".frmEditarSucursal").validate();
        }
    });

    $("#btnAgregarNuevaSucursal").on("click", function () {
        $("#frmAgregarSucursal").trigger("submit");
    });

    $("#frmAgregarSucursal").validate({
        submitHandler: function (form) {
            const $frm = $(form);
            const data = $frm.serializeObject();

            agregarSucursal(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire("¡Oops! Algo salió mal.", resultado.message, "error");
                    } else {
                        swal.fire("Listo", resultado.message, "success");
                        $tablaSucursales.bootstrapTable("refresh");
                        $modalNuevaSucursal.modal("hide");
                        form.reset();
                    }
                })
                .catch(function (error) {
                    swal.fire("¡Oops! Algo salió mal.", "Hubo un problema al agregar el usuario.", "error");
                });

            return false;
        }
    });

    $(document).on("submit", ".frmEditarSucursal", function (e) {
        e.preventDefault();
        const $frm = $(this);
        const data = $frm.serializeObject();

        if ($frm.valid()) {
            editarSucursal(data).then(function (resultado) {
                if (!resultado.success) {
                    swal.fire("¡Oops! Algo salió mal.", resultado.message, "error");

                } else {
                    swal.fire("Listo", resultado.message, "success");
                    $tablaSucursales.bootstrapTable("refresh");
                }
            });
        }

        return false;
    });

    $(document).on("click", ".btnEliminarSucursal", function () {
        const id = $(this).data("id");
        mostrarConfirmacion("¿Seguro que deseas borrar este usuario?", EliminarSucursal, id)
    });
});

function accionesTabla(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);

    return renderData;
}

//formatoUbicacion
function formatoUbicacion(value, row, index, field) {
    const html = `<a href="{{this}}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fa-duotone fa-map-location-dot"></i></a>`;
    const renderData = Handlebars.compile(html)(value);

    return renderData;
}

function agregarSucursal(data) {
    return $.ajax({
        type: "post",
        url: urls.agregar,
        data: data,
        dataType: "json"
    });
}

function editarSucursal(data) {
    return $.ajax({
        type: "post",
        url: urls.editar,
        data: data,
        dataType: "json"
    });
}

function EliminarSucursal(id) {
    $.ajax({
        type: "post",
        url: urls.borrar,
        data: { id: id },
        dataType: "json"
    }).then(function (resultado) {
        swal.fire("Listo", resultado.message, "success");
        $tablaSucursales.bootstrapTable("refresh");
    });
}

function encontrarSucursalPorId(sucursales, id) {
    for (const sucursal of sucursales) {
        if (sucursal.id === id) {
            return sucursal;
        }
    }
    return null;
}