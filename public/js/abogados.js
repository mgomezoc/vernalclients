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

    $('#modalNuevoAbogado .select2').select2({
        placeholder: 'Seleccione una opción',
        dropdownParent: $('#modalNuevoAbogado'),
        theme: 'bootstrap-5'
    });

    $tablaAbogados = $('#tablaAbogados').bootstrapTable({
        url: urls.obtener,
        method: 'GET',
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
            $detail.html('...cargando');
            console.log(row);
            const renderData = Handlebars.compile(tplEditarAbogado)(row);
            $detail.html(renderData);
            $detail.find('.frmEditarAbogado').validate();
            $detail
                .find('select')
                .each(function (index, el) {
                    const $combo = $(el);
                    const selected = $combo.data('selected');

                    $combo.find(`option[value="${selected}"]`).attr('selected', true);
                    console.log(index, el, selected);
                })
                .select2({
                    placeholder: 'Seleccione una opción',
                    theme: 'bootstrap-5'
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

    $('#frmAgregarAbogado').validate({
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
                        form.reset();
                        $frm.find('select').trigger('change');
                    }
                })
                .catch(function (error) {
                    swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar el usuario.', 'error');
                });

            return false;
        }
    });

    $(document).on('submit', '.frmEditarAbogado', function (e) {
        e.preventDefault();
        const $frm = $(this);
        const data = $frm.serializeObject();

        if ($frm.valid()) {
            editarAbogado(data).then(function (resultado) {
                if (!resultado.success) {
                    swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                } else {
                    swal.fire('¡Listo!', resultado.message, 'success');
                    $tablaAbogados.bootstrapTable('refresh');
                }
            });
        }

        return false;
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
