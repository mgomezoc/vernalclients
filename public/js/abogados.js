/***
 *
 * ABOGADOS
 *
 */
const urls = {
    obtener: 'abogados/obtener-abogados',
    agregar: 'abogados/agregar-abogado',
    editar: 'abogados/editar-abogado',
    borrar: 'abogados/eliminar-abogado',
    obtenerUsuarios: 'usuarios/obtener-usuario'
};
let tplAccionesTabla = '';
let tplEditarAbogado = '';
let tplInfoUsuario = '';
let $tablaAbogados;
let $modalNuevoAbogado;

$(function () {
    setActiveMenu('abogados');

    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplEditarAbogado = $('#tplEditarAbogado').html();
    tplInfoUsuario = $('#tplInfoUsuario').html();
    $modalNuevoAbogado = $('#modalNuevoAbogado');

    $('#modalNuevoAbogado .select2')
        .select2({
            placeholder: 'Seleccione una opción',
            dropdownParent: $('#modalNuevoAbogado'),
            theme: 'bootstrap-5'
        })
        .on('change', function () {
            $(this).valid();
        });

    // Limpiar y resetear el formulario cuando se oculta el modal
    $modalNuevoAbogado.on('hidden.bs.modal', function () {
        const $form = $('#frmAgregarAbogado');

        // Resetear el formulario
        $form[0].reset();

        // Resetear Select2
        $form.find('select').val('').trigger('change');

        // Limpiar la información del usuario
        $('#containerInfoUsuario').html('');

        // Limpiar mensajes de error y estado de validación
        $form.validate().resetForm();
        $form.find('.is-invalid').removeClass('is-invalid'); // Remover clases de error
    });

    $tablaAbogados = $('#tablaAbogados').bootstrapTable({
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
            const renderData = Handlebars.compile(tplEditarAbogado)(row);
            $detail.html(renderData);

            const $formEditar = $detail.find('.frmEditarAbogado');

            // Inicializar Select2 para formularios de edición
            $formEditar
                .find('select')
                .each(function (index, el) {
                    const $combo = $(el);
                    const selected = $combo.data('selected');
                    $combo.find(`option[value="${selected}"]`).attr('selected', true);
                })
                .select2({
                    placeholder: 'Seleccione una opción',
                    theme: 'bootstrap-5'
                });

            // Validar formulario de edición
            $formEditar.validate({
                rules: {
                    id_sucursal: {
                        required: true
                    },
                    especialidad: {
                        required: true
                    },
                    telefono: {
                        required: true,
                        digits: true,
                        minlength: 7,
                        maxlength: 20
                    }
                },
                messages: {
                    id_sucursal: {
                        required: 'Seleccione una sucursal.'
                    },
                    especialidad: {
                        required: 'Seleccione una especialidad.'
                    },
                    telefono: {
                        required: 'Ingrese un número de teléfono.',
                        digits: 'Ingrese solo números.',
                        minlength: 'El número de teléfono debe tener al menos 7 dígitos.',
                        maxlength: 'El número de teléfono no debe exceder los 20 dígitos.'
                    }
                },
                submitHandler: function (form) {
                    const $frm = $(form);
                    const data = $frm.serializeObject();

                    editarAbogado(data).then(function (resultado) {
                        if (!resultado.success) {
                            swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                        } else {
                            swal.fire('¡Listo!', resultado.message, 'success');
                            $tablaAbogados.bootstrapTable('refresh');
                        }
                    });

                    return false;
                }
            });
        }
    });

    $('#nuevo_usuario').on('change', async function () {
        const id = $(this).val();
        const resultado = await obtenerUsuarios(id);
        const renderData = Handlebars.compile(tplInfoUsuario)(resultado);

        $('#containerInfoUsuario').html(renderData);
    });

    $(document).on('change', '.cbUsuarios', async function () {
        const id = $(this).val();
        const resultado = await obtenerUsuarios(id);
        const target = $(this).data('target');
        const renderData = Handlebars.compile(tplInfoUsuario)(resultado);

        $(target).html(renderData);
    });

    $('#btnAgregarAbogado').on('click', function () {
        $('#frmAgregarAbogado').trigger('submit');
    });

    // Validación de formulario de agregar abogado
    $('#frmAgregarAbogado').validate({
        rules: {
            id_usuario: {
                required: true
            },
            id_sucursal: {
                required: true
            },
            especialidad: {
                required: true
            },
            telefono: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 20
            }
        },
        messages: {
            id_usuario: {
                required: 'Seleccione un usuario.'
            },
            id_sucursal: {
                required: 'Seleccione una sucursal.'
            },
            especialidad: {
                required: 'Seleccione una especialidad.'
            },
            telefono: {
                required: 'Ingrese un número de teléfono.',
                digits: 'Ingrese solo números.',
                minlength: 'El número de teléfono debe tener al menos 7 dígitos.',
                maxlength: 'El número de teléfono no debe exceder los 20 dígitos.'
            }
        },
        submitHandler: function (form) {
            const $frm = $(form);
            const data = $frm.serializeObject();

            agregarAbogado(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                    } else {
                        swal.fire('¡Listo!', resultado.message, 'success');
                        $tablaAbogados.bootstrapTable('refresh');
                        $modalNuevoAbogado.modal('hide');
                    }
                })
                .catch(function (error) {
                    swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar el usuario.', 'error');
                });

            return false;
        }
    });

    $(document).on('click', '.btnEliminarAbogado', function () {
        const id = $(this).data('id');
        mostrarConfirmacion('¿Seguro que deseas borrar este abogado?', eliminarAbogado, id);
    });
});

function accionesTablaUsuarios(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);
    return renderData;
}

function obtenerUsuarios(id) {
    return $.ajax({
        type: 'get',
        url: `${baseUrl}${urls.obtenerUsuarios}/${id}`,
        dataType: 'json'
    });
}

function agregarAbogado(data) {
    return $.ajax({
        type: 'post',
        url: urls.agregar,
        data: data,
        dataType: 'json'
    });
}

function editarAbogado(data) {
    return $.ajax({
        type: 'post',
        url: urls.editar,
        data: data,
        dataType: 'json'
    });
}

function eliminarAbogado(id) {
    $.ajax({
        type: 'post',
        url: urls.borrar,
        data: { id: id },
        dataType: 'json'
    }).then(function (resultado) {
        swal.fire('¡Listo!', resultado.message, 'success');
        $tablaAbogados.bootstrapTable('refresh');
    });
}
