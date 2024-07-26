/**
 * USUARIOS
 */
const urls = {
    obtenerUsuarios: 'usuarios/obtener-usuarios',
    agregarUsuario: 'usuarios/agregar-usuario',
    editarUsuario: 'usuarios/editar-usuario',
    borrarUsuario: 'usuarios/borrar-usuario'
};

let tplAccionesTabla = '';
let tplEditarUsuario = '';
let $tablaUsuarios;
let $modalAgregarUsuario;

$(function () {
    setActiveMenu('usuarios');

    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplEditarUsuario = $('#tplEditarUsuario').html();
    $modalAgregarUsuario = $('#modalAgregarUsuario');

    $modalAgregarUsuario.find('.select2').select2({
        placeholder: 'Seleccione una opción',
        dropdownParent: $('#modalAgregarUsuario'),
        theme: 'bootstrap-5'
    });

    $tablaUsuarios = $('#tablaUsuarios').bootstrapTable({
        url: urls.obtenerUsuarios,
        showRefresh: true,
        search: true,
        pagination: true,
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
            const usuarios = $tablaUsuarios.bootstrapTable('getData');
            const usuario = encontrarUsuarioPorId(usuarios, row.id);
            const renderData = Handlebars.compile(tplEditarUsuario)(usuario);
            $detail.html(renderData);
            const $comboPerfiles = $detail.find('.cbPerfiles');
            $comboPerfiles.find(`option[value=${row.perfil}]`).prop('selected', true);
            $comboPerfiles.select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5'
            });
            $detail.find('.frmEditarUsuario').validate();
        }
    });

    $('#btnAgregarUsuario').on('click', function () {
        $('#frmAgregarUsuario').trigger('submit');
    });

    $('#frmAgregarUsuario').validate({
        rules: {
            contrasena: {
                required: true,
                minlength: 5
            },
            confirmarPassword: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            contrasena: {
                required: 'Este campo es obligatorio',
                minlength: 'La contraseña debe tener al menos 5 caracteres'
            },
            confirmarPassword: {
                required: 'Este campo es obligatorio',
                equalTo: 'Las contraseñas no coinciden'
            }
        },
        submitHandler: function (form) {
            const $frm = $(form);
            const data = $frm.serializeObject();

            agregarUsuario(data)
                .then(function (resultado) {
                    if (!resultado.success) {
                        swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                    } else {
                        swal.fire('¡Listo!', resultado.message, 'success');
                        $tablaUsuarios.bootstrapTable('refresh');
                        $modalAgregarUsuario.modal('hide');
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

    $(document).on('submit', '.frmEditarUsuario', function (e) {
        e.preventDefault();
        const $frm = $(this);
        const data = $frm.serializeObject();

        if ($frm.valid()) {
            editarUsuario(data).then(function (resultado) {
                if (!resultado.success) {
                    swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                } else {
                    swal.fire('¡Listo!', resultado.message, 'success');
                    $tablaUsuarios.bootstrapTable('refresh');
                }
            });
        }

        return false;
    });

    $(document).on('click', '.btnEliminarUsuario', function () {
        const id = $(this).data('id');
        mostrarConfirmacion('¿Seguro que deseas borrar este usuario?', eliminarUsuario, id);
    });

    // Convierte a minúsculas el texto en el input #email cada vez que se escribe algo
    $('#email').on('input', function () {
        this.value = this.value.toLowerCase();
    });

    // Aplica el mismo comportamiento al input de correo electrónico del formulario de editar usuario
    $(document).on('input', 'input[name="correo_electronico"]', function () {
        this.value = this.value.toLowerCase();
    });
});

function accionesTablaUsuarios(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);

    return renderData;
}

function formatoPerfiles(value, row, index, field) {
    switch (value) {
        case '1':
            return 'CALL';
        case '2':
            return 'RECEPTION';
        case '3':
            return 'PARALEGAL';
        case '4':
            return 'ADMIN';
        case '5':
            return 'MARKETING';
        case '6':
            return 'ATTORNEY';
    }
}

function agregarUsuario(data) {
    return $.ajax({
        type: 'post',
        url: urls.agregarUsuario,
        data: data,
        dataType: 'json'
    });
}

function editarUsuario(data) {
    return $.ajax({
        type: 'post',
        url: urls.editarUsuario,
        data: data,
        dataType: 'json'
    });
}

function eliminarUsuario(id) {
    $.ajax({
        type: 'post',
        url: urls.borrarUsuario,
        data: { id: id },
        dataType: 'json'
    }).then(function (resultado) {
        swal.fire('¡Listo!', resultado.message, 'success');
        $tablaUsuarios.bootstrapTable('refresh');
    });
}

function encontrarUsuarioPorId(usuarios, id) {
    for (const usuario of usuarios) {
        if (usuario.id === id) {
            return usuario;
        }
    }
    return null;
}
