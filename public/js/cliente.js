/**
 *
 * CLIENTE
 *
 */

let tplFormulario = '';
let tplComentarios = '';
let $modalComentarios;

$(function () {
    tplFormulario = $('#tplFormulario').html();
    tplComentarios = $('#tplComentarios').html();
    $modalComentarios = $('#modalComentarios');

    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5'
    });

    Fancybox.bind('[data-fancybox]', {});

    //INTAKE
    $('.flatpickr').flatpickr({
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'm-d-Y',
        allowInput: true
    });

    cargarSucursales(formulario.sucursal);

    $('#btnEditar').on('click', function () {
        $('#formularioAdmision').find('input, textarea').prop('readonly', false);
        $('.select2, .flatpickr').prop('disabled', false);
        $('#formularioAdmision').find('input, textarea, select').prop('disabled', false);

        $('#btnGuardar').removeClass('d-none');
        $(this).addClass('d-none');
    });

    $('#formularioAdmision').on('submit', async function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();
        const sucursal_nombre = $('#cbSucursales option:selected').text();
        formData.sucursal_nombre = sucursal_nombre;

        if (formData.fuente_informacion) {
            if ($.isArray(formData.fuente_informacion)) {
                formData.fuente_informacion = formData.fuente_informacion.join('|');
            }
        } else {
            formData.fuente_informacion = '';
        }

        $frm.find('input, textarea, button').attr('disabled', true);

        Swal.fire({
            title: 'Actualizando formulario',
            text: 'Por favor, espere mientras procesamos su solicitud...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const resultado = await actualizarIntake(formData);

            Swal.close();

            if (!resultado.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: resultado.message,
                    confirmButtonText: 'Entendido'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualización exitosa',
                    text: resultado.message,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            }
        } catch (error) {
            Swal.close();

            Swal.fire({
                icon: 'error',
                title: 'Error inesperado',
                text: 'Ocurrió un problema al procesar su solicitud. Intente nuevamente más tarde.',
                confirmButtonText: 'Entendido'
            });
        } finally {
            $frm.find('input, textarea, button').attr('disabled', false);
        }
    });

    // Evento para enviar encuesta
    $('.btnEncuesta').on('click', function () {
        showSweetAlert('success', 'Se ha enviado la encuesta.');
    });

    // Evento para cerrar caso
    $('.btnCerrarCaso').on('click', async function (e) {
        e.preventDefault();
        const $btn = $(this);
        const idCaso = $btn.data('id');

        // Mostrar confirmación al usuario antes de cerrar el caso
        mostrarConfirmacion('¿Estás seguro de que deseas cerrar este caso? Esta acción no se puede deshacer.', async function () {
            try {
                // Preparar los datos para la actualización del estatus
                const data = { id_caso: idCaso, nuevo_estatus: 4 };

                // Intentar actualizar el estatus del caso
                const response = await actualizarEstatus(data);

                if (!response.success) {
                    // Mostrar error si la actualización falló
                    showSweetAlert('error', response.message || 'No se pudo actualizar el estatus del caso.');
                } else {
                    // Mostrar éxito si la actualización fue correcta
                    showSweetAlert('success', 'El caso se ha cerrado correctamente.');
                    $btn.remove(); // Eliminar el botón de cerrar caso después de la acción
                }
            } catch (error) {
                // Manejo de errores inesperados
                console.error('Error al cerrar el caso:', error);
                showSweetAlert('error', 'Ocurrió un error inesperado al cerrar el caso. Por favor, intenta nuevamente.');
            }
        });
    });

    // Evento para mostrar comentarios
    $modalComentarios.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_caso = $btn.data('id');
        $('#comentariosContainer').html('...cargando');
        $('#inputCasoComentario').val(id_caso);
        cargarComentarios(id_caso);
    });

    // Envío del formulario de comentarios
    $('#frmComentario').on('submit', async function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();

        try {
            const r = await agregarComentario(formData);
            if (r.success) {
                await cargarComentarios(formData.id_caso);
                $frm[0].reset();
                showSweetAlert('success', 'Comentario agregado con éxito.');
            }
        } catch (error) {
            showSweetAlert('error', 'Ocurrió un error al agregar el comentario.');
        }
    });

    // Evento para pagar un caso
    $('.btnPagarCaso').on('click', function (e) {
        const $btn = $(this);
        const id_caso = $btn.data('id');
        const forma_pago = $btn.data('tipo');

        const data = { id_caso, forma_pago };
        mostrarConfirmacion('¿Seguro que deseas realizar este pago?', pagarCaso, data);
    });

    // Validación del formulario de edición de cliente
    $('#frmEditarCliente').validate({
        rules: {
            nombre: {
                required: true,
                minlength: 2
            },
            telefono: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            sucursal: {
                required: true
            },
            meet_url: {
                url: true
            }
        },
        messages: {
            nombre: {
                required: 'El nombre es obligatorio.',
                minlength: 'El nombre debe tener al menos 2 caracteres.'
            },
            telefono: {
                required: 'El teléfono es obligatorio.',
                digits: 'El teléfono debe contener solo números.',
                minlength: 'El teléfono debe tener 10 dígitos.',
                maxlength: 'El teléfono debe tener 10 dígitos.'
            },
            sucursal: {
                required: 'Seleccione una sucursal.'
            },
            meet_url: {
                url: 'Ingrese una URL válida.'
            }
        },
        submitHandler: async function (form, e) {
            e.preventDefault();

            const $frm = $(form);
            const formData = $frm.serializeObject();

            try {
                const r = await actualizarCliente(formData);
                if (r.success) {
                    showSweetAlert('success', 'Información actualizada correctamente.');
                } else {
                    showSweetAlert('error', 'No se pudo actualizar la información.');
                }
            } catch (error) {
                showSweetAlert('error', 'Ocurrió un error al actualizar el cliente.');
            }
        }
    });

    //EXPEDIENTE
    $('#tableExpediente').bootstrapTable();
    // Evento para manejar la subida de archivos
    $('#formSubirArchivo').on('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await subirArchivo(formData);
            if (response.success) {
                showSweetAlert('success', 'Archivo subido exitosamente.');
                // Actualizar la tabla de expediente
                actualizarTablaExpediente(response.expedientes);
                $('#formSubirArchivo')[0].reset(); // Limpiar el formulario
            } else {
                showSweetAlert('error', response.message || 'Error al subir el archivo.');
            }
        } catch (error) {
            showSweetAlert('error', 'Ocurrió un error inesperado al subir el archivo.');
        }
    });

    // Función para enviar los datos del archivo vía AJAX
    async function subirArchivo(formData) {
        return await ajaxCall({
            type: 'POST',
            url: `${baseUrl}clientes/subir-archivos-expediente/${cliente.id_cliente}`,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        });
    }

    // Función para actualizar la tabla de expedientes
    function actualizarTablaExpediente(expedientes) {
        const $tablaExpediente = $('#tablaExpediente');
        $tablaExpediente.empty(); // Limpiar la tabla

        if (expedientes.length > 0) {
            expedientes.forEach((expediente) => {
                const fila = `
                <tr>
                    <td>${expediente.nombre_documento}</td>
                    <td>${expediente.tipo_documento}</td>
                    <td>${(expediente.tamano_documento / 1024).toFixed(2)} KB</td>
                    <td>${new Date(expediente.fecha_subida).toLocaleString()}</td>
                    <td>
                        <a href="${baseUrl}${expediente.path_documento}" class="btn btn-sm btn-primary" target="_blank">
                            <i class="fa-solid fa-download me-1"></i> Descargar
                        </a>
                        <button class="btn btn-sm btn-danger btnEliminarArchivo" data-id="${expediente.id}">
                            <i class="fa-solid fa-trash me-1"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
                $tablaExpediente.append(fila);
            });
        } else {
            $tablaExpediente.html('<tr><td colspan="5" class="text-center">No hay documentos en el expediente.</td></tr>');
        }
    }

    // Evento para eliminar un archivo
    $(document).on('click', '.btnEliminarArchivo', function () {
        const idExpediente = $(this).data('id');

        // Mostrar confirmación
        mostrarConfirmacion(
            '¿Estás seguro de que deseas eliminar este archivo?',
            async function (idExpediente) {
                try {
                    const response = await eliminarArchivo(idExpediente);
                    if (response.success) {
                        showSweetAlert('success', response.message);
                        // Actualizar la tabla de expedientes
                        actualizarTablaExpediente(response.expedientes);
                    } else {
                        showSweetAlert('error', response.message || 'Error al eliminar el archivo.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showSweetAlert('error', 'Ocurrió un error inesperado al eliminar el archivo.');
                }
            },
            idExpediente
        ); // Pasar idExpediente como parámetro a mostrarConfirmacion
    });

    // Función para eliminar el archivo vía AJAX
    async function eliminarArchivo(idExpediente) {
        return await ajaxCall({
            type: 'POST',
            url: `${baseUrl}clientes/eliminar-archivo-expediente/${idExpediente}`,
            dataType: 'json'
        });
    }
});

async function actualizarEstatus(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/actualizar-estatus`,
        data: data,
        dataType: 'json'
    });
}

async function obtenerComentarios(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/comentarios`,
        data: data,
        dataType: 'json'
    });
}

async function agregarComentario(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/comentarios-agregar`,
        data: data,
        dataType: 'json'
    });
}

async function cargarComentarios(id_caso) {
    try {
        const r = await obtenerComentarios({ id_caso });
        const data = { comentarios: r.data };
        const renderData = Handlebars.compile(tplComentarios)(data);
        $('#comentariosContainer').html(renderData);
        accionesComentarios();
    } catch (error) {
        showSweetAlert('error', 'Ocurrió un error al cargar los comentarios.');
    }
}

function accionesComentarios() {
    // Implementar acciones adicionales para los comentarios si es necesario.
}

async function pagarCaso(data) {
    const formData = {
        id_caso: data.id_caso,
        pagado: 1,
        forma_pago: data.forma_pago
    };

    try {
        const r = await editarCaso(formData);
        if (r.success) {
            showSweetAlert('success', 'El pago se ha realizado con éxito.');
            $(`.btnVerCaso[data-id=${formData.id_caso}]`).remove();
        } else {
            showSweetAlert('error', 'No se pudo realizar el pago.');
        }
    } catch (error) {
        showSweetAlert('error', 'Ocurrió un error al procesar el pago.');
    }
}

async function editarCaso(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/editar`,
        data: data,
        dataType: 'json'
    });
}

async function actualizarCliente(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}clientes/actualizarCliente`,
        data: data,
        dataType: 'json'
    });
}

async function actualizarIntake(formData) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}intake/actualizar`,
        data: formData,
        dataType: 'json'
    });
}

function showSweetAlert(type, message) {
    swal.fire({
        icon: type,
        title: message,
        showConfirmButton: true,
        timer: 2000
    });
}

function cargarSucursales(sucursalSeleccionada = '') {
    $.ajax({
        url: `${baseUrl}api/lawFirmLocations`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var $select = $('#cbSucursales');
            $select.empty();

            // Agregamos la opción por defecto
            $select.append($('<option>', { value: '', text: 'Seleccione una sucursal' }));

            // Obtenemos los datos y llenamos el select
            const data = response.totalCount > 0 ? response.data : [];
            $.each(data, function (i, option) {
                $select.append(
                    $('<option>', {
                        value: option.lawFirmLocationID,
                        text: option.name
                    })
                );
            });

            // Inicializamos select2
            $select.select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Seleccionamos la sucursal si hay un ID válido
            if (sucursalSeleccionada) {
                $select.val(sucursalSeleccionada).trigger('change');
            }

            $select.prop('disabled', true);
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar las sucursales: ' + error);
        }
    });
}
