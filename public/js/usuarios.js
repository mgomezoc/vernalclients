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

    // Inicializar Select2 y configurar jQuery Validate para trabajar con Select2
    $modalAgregarUsuario.on('show.bs.modal', function () {
        $('#comboPerfiles')
            .select2({
                placeholder: 'Seleccione una opción',
                dropdownParent: $modalAgregarUsuario,
                theme: 'bootstrap-5'
            })
            .on('change', function () {
                $(this).valid(); // Hacer que jQuery Validate valide el campo Select2 cuando cambia
            });
    });

    // Limpiar el formulario cuando se oculta el modal
    $modalAgregarUsuario.on('hidden.bs.modal', function () {
        const $frm = $('#frmAgregarUsuario');
        $frm[0].reset(); // Resetear el formulario
        $frm.find('select').val(null).trigger('change'); // Resetear los campos Select2
        $frm.validate().resetForm(); // Limpiar los mensajes de error de jQuery Validate
        $frm.find('.is-invalid').removeClass('is-invalid'); // Remover las clases de error
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
            $comboPerfiles
                .select2({
                    placeholder: 'Seleccione una opción',
                    theme: 'bootstrap-5'
                })
                .on('change', function () {
                    $(this).valid(); // Hacer que jQuery Validate valide el campo Select2 cuando cambia
                });
            $detail.find('.frmEditarUsuario').validate();
        }
    });

    $('#btnAgregarUsuario').on('click', function () {
        $('#frmAgregarUsuario').trigger('submit');
    });

    $('#frmAgregarUsuario').validate({
        rules: {
            nombre: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            contrasena: {
                required: true,
                minlength: 5
            },
            confirmarPassword: {
                required: true,
                equalTo: '#password'
            },
            perfil: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: 'Este campo es obligatorio'
            },
            email: {
                required: 'Este campo es obligatorio',
                email: 'Por favor, introduce una dirección de correo válida'
            },
            contrasena: {
                required: 'Este campo es obligatorio',
                minlength: 'La contraseña debe tener al menos 5 caracteres'
            },
            confirmarPassword: {
                required: 'Este campo es obligatorio',
                equalTo: 'Las contraseñas no coinciden'
            },
            perfil: {
                required: 'Este campo es obligatorio'
            }
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('span')); // Coloca el mensaje de error después del contenedor Select2
            } else {
                error.insertAfter(element);
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

    // Convertir el texto del input #email a minúsculas mientras se escribe
    $('#email').on('input', function () {
        this.value = this.value.toLowerCase();
    });

    // Aplicar el mismo comportamiento al input de correo electrónico en el formulario de editar usuario
    $(document).on('input', 'input[name="correo_electronico"]', function () {
        this.value = this.value.toLowerCase();
    });
});

function accionesTablaUsuarios(value, row, index, field) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);
    return renderData;
}

function formatoPerfiles(value) {
    const perfiles = {
        1: 'CALL',
        2: 'RECEPTION',
        3: 'PARALEGAL',
        4: 'ADMIN',
        5: 'MARKETING',
        6: 'ATTORNEY',
        7: 'ADMINCALL'
    };
    return perfiles[value] || 'DESCONOCIDO';
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
    return usuarios.find((usuario) => usuario.id === id) || null;
}
