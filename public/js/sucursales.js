/**
 * SUCURSALES
 */
const urls = {
    obtener: 'sucursales/obtener-sucursales',
    agregar: 'sucursales/agregar-sucursal',
    editar: 'sucursales/editar-sucursal',
    borrar: 'sucursales/eliminar-sucursal'
};

let tplAccionesTabla = '';
let tplEditarSucursal = '';
let $tablaSucursales;
let $modalNuevaSucursal;

$(function () {
    setActiveMenu('sucursales');

    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplEditarSucursal = $('#tplEditarSucursal').html();
    $modalNuevaSucursal = $('#modalNuevaSucursal');

    $tablaSucursales = $('#tablaSucursales').bootstrapTable({
        url: urls.obtener,
        method: 'GET',
        search: true,
        pagination: true,
        showColumns: true,
        showRefresh: true,
        pageSize: 50,
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
            $detail.html('...cargando');
            const sucursales = $tablaSucursales.bootstrapTable('getData');
            const sucursal = encontrarSucursalPorId(sucursales, row.id);
            const renderData = Handlebars.compile(tplEditarSucursal)(sucursal);
            $detail.html(renderData);

            // Validaciones al editar sucursal
            $detail.find('.frmEditarSucursal').validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 3,
                        remote: {
                            url: `${baseUrl}sucursales/verificar-nombre-sucursal`,
                            type: 'post',
                            data: {
                                nombre: function () {
                                    return $('#nombre').val();
                                },
                                id: function () {
                                    return $('[name="id"]').val();
                                }
                            }
                        }
                    },
                    direccion: {
                        required: true,
                        minlength: 5
                    },
                    telefono: {
                        required: false,
                        digits: true,
                        rangelength: [10, 10]
                    },
                    url_google_maps: {
                        required: true,
                        url: true
                    }
                },
                messages: {
                    nombre: {
                        required: 'Este campo es obligatorio.',
                        minlength: 'El nombre debe tener al menos 3 caracteres.',
                        remote: 'Ya existe una sucursal con este nombre.'
                    },
                    direccion: {
                        required: 'Este campo es obligatorio.',
                        minlength: 'La dirección debe tener al menos 5 caracteres.'
                    },
                    telefono: {
                        digits: 'Solo se permiten números.',
                        rangelength: 'El teléfono debe tener 10 dígitos.'
                    },
                    url_google_maps: {
                        required: 'Este campo es obligatorio.',
                        url: 'Debe ser una URL válida.'
                    }
                },
                submitHandler: function (form) {
                    const $frm = $(form);
                    const data = $frm.serializeObject();

                    editarSucursal(data).then(function (resultado) {
                        if (!resultado.success) {
                            swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                        } else {
                            swal.fire('¡Listo!', resultado.message, 'success');
                            $tablaSucursales.bootstrapTable('refresh');
                        }
                    });

                    return false;
                }
            });
        }
    });

    $('#btnAgregarNuevaSucursal').on('click', function () {
        $('#frmAgregarSucursal').trigger('submit');
    });

    // Validación de formulario para agregar nueva sucursal
    $('#frmAgregarSucursal').validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                remote: {
                    url: `${baseUrl}sucursales/verificar-nombre-sucursal`,
                    type: 'post',
                    data: {
                        nombre: function () {
                            return $('#nombre').val();
                        }
                    }
                }
            },
            direccion: {
                required: true,
                minlength: 5
            },
            telefono: {
                required: false,
                digits: true,
                rangelength: [10, 10]
            },
            url_google_maps: {
                required: true,
                url: true
            }
        },
        messages: {
            nombre: {
                required: 'Este campo es obligatorio.',
                minlength: 'El nombre debe tener al menos 3 caracteres.',
                remote: 'Ya existe una sucursal con este nombre.'
            },
            direccion: {
                required: 'Este campo es obligatorio.',
                minlength: 'La dirección debe tener al menos 5 caracteres.'
            },
            telefono: {
                digits: 'Solo se permiten números.',
                rangelength: 'El teléfono debe tener 10 dígitos.'
            },
            url_google_maps: {
                required: 'Este campo es obligatorio.',
                url: 'Debe ser una URL válida.'
            }
        },
        submitHandler: function (form) {
            const $frm = $(form);
            const data = $frm.serializeObject();

            agregarSucursal(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                    } else {
                        swal.fire('¡Listo!', resultado.message, 'success');
                        $tablaSucursales.bootstrapTable('refresh');
                        $modalNuevaSucursal.modal('hide');
                        form.reset();
                        $('#frmAgregarSucursal').find('.form-control').trigger('blur');
                    }
                })
                .catch(function (error) {
                    swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar la sucursal.', 'error');
                });

            return false;
        }
    });

    $(document).on('click', '.btnEliminarSucursal', function () {
        const id = $(this).data('id');
        mostrarConfirmacion('¿Seguro que deseas borrar esta sucursal?', eliminarSucursal, id);
    });
});

function accionesTabla(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);
    return renderData;
}

// Formato Ubicación
function formatoUbicacion(value, row, index, field) {
    const html = `<a href="${value}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fa-duotone fa-map-location-dot"></i></a>`;
    return html;
}

function agregarSucursal(data) {
    return $.ajax({
        type: 'post',
        url: urls.agregar,
        data: data,
        dataType: 'json'
    });
}

function editarSucursal(data) {
    return $.ajax({
        type: 'post',
        url: urls.editar,
        data: data,
        dataType: 'json'
    });
}

function eliminarSucursal(id) {
    return $.ajax({
        type: 'post',
        url: urls.borrar,
        data: { id: id },
        dataType: 'json'
    }).then(function (resultado) {
        swal.fire('¡Listo!', resultado.message, 'success');
        $tablaSucursales.bootstrapTable('refresh');
    });
}

function encontrarSucursalPorId(sucursales, id) {
    return sucursales.find((sucursal) => sucursal.id === id) || null;
}
