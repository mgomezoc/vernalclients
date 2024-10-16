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

    cargarPaisesDireccion(formulario.direccion_pais, 'cbDireccionPais');
    cargarTiposVisa(formulario.tipo_visa, 'cbTipoVisa');
    cargarEstatusMigratorio(formulario.estatus_migratorio_actual, 'cbEstatusMigratorio');
    cargarParentescos(formulario.familiar_servicio_parentesco, 'cbFamiliarServicioParentesco');
    cargarSucursales(formulario.sucursal);
    cargarPaises(formulario.nationality, `cbCiudadania`);
    cargarNacionalidades(formulario.segunda_nacionalidad, `cbSegundaNacionalidad`);

    $('#btnEditar').on('click', function () {
        $('#formularioAdmision').find('input, textarea').prop('readonly', false);
        $('.select2, .flatpickr').prop('disabled', false);
        $('#formularioAdmision').find('input, textarea, select').prop('disabled', false);

        $('#btnGuardar').removeClass('d-none');
        $(this).addClass('d-none');
    });

    $('#comoEntroEeuu').on('change', function () {
        const comoEntro = $(this).val();

        if (comoEntro == 'Con Visa') {
            $('#container-visa').show();
        } else {
            $('#container-visa').hide();
        }
    });

    $('#solicitudMigratoria').on('change', function () {
        if ($(this).val() === 'Si') {
            $('#container-peticionado').show();
            $('#container-peticionado textarea').prop('disabled', false);
        } else {
            $('#container-peticionado').hide();
            $('#container-peticionado textarea').prop('disabled', true).val(''); // Limpiar el campo si se oculta
        }
    });

    $('#procesoMigracion').on('change', function () {
        if ($(this).val() === 'Si') {
            $('#container-procesoMigracion').show();
            $('#container-procesoMigracion textarea').prop('disabled', false);
        } else {
            $('#container-procesoMigracion').hide();
            $('#container-procesoMigracion textarea').prop('disabled', true).val(''); // Limpiar el campo si se oculta
        }
    });

    $('#familiarServicio').on('change', function () {
        if ($(this).val() === 'Si') {
            $('#container-servicioMilitar').show();
            $('#familiarServicioParentesco').prop('disabled', false);
        } else {
            $('#container-servicioMilitar').hide();
            $('#familiarServicioParentesco').prop('disabled', true).val(''); // Limpiar el campo si se oculta
        }
    });

    $('#victimaCrimen').on('change', function () {
        if ($(this).val() === 'Si') {
            $('#container-victimaCrimen').show();
            $('#container-victimaCrimen textarea').prop('disabled', false);
        } else {
            $('#container-victimaCrimen').hide();
            $('#container-victimaCrimen textarea').prop('disabled', true).val(''); // Limpiar el campo si se oculta
        }
    });

    $('#arrestado').on('change', function () {
        if ($(this).val() === 'Si') {
            $('#container-arresto').show();
            $('#container-arresto textarea').prop('disabled', false);
            $('#container-explicacion').show();
            $('#container-explicacion textarea').prop('disabled', false);
        } else {
            $('#container-arresto').hide();
            $('#container-arresto textarea').prop('disabled', true).val('');
            $('#container-explicacion').hide();
            $('#container-explicacion textarea').prop('disabled', true).val('');
        }
    });

    $('#formularioAdmision').on('submit', async function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();
        const sucursal_nombre = $('#cbSucursales option:selected').text();

        if (!Array.isArray(formData.parientes)) {
            formData.parientes = [formData.parientes];
        }

        formData.parientes = formData.parientes.join(',');

        formData.sucursal_nombre = sucursal_nombre;

        if (formData.fuente_informacion) {
            if ($.isArray(formData.fuente_informacion)) {
                formData.fuente_informacion = formData.fuente_informacion.join('|');
            }
        } else {
            formData.fuente_informacion = '';
        }

        if (formData.cometido_crimen) {
            if ($.isArray(formData.cometido_crimen)) {
                formData.cometido_crimen = formData.cometido_crimen.join(',');
            }
        } else {
            formData.cometido_crimen = '';
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

function cargarTiposVisa(visaSeleccionada = '', selectVisaID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectVisaID) {
        console.error('ID del select es requerido');
        return;
    }

    // Array de tipos de visa predefinido
    const tiposVisa = [
        { Propósito: 'Atletas, artistas, animadores', 'Tipo de Visa': 'P' },
        { Propósito: 'Trabajador australiano – especialidad profesional', 'Tipo de Visa': 'E-3' },
        { Propósito: 'Tarjeta de Cruce de Frontera: México', 'Tipo de Visa': 'BCC' },
        { Propósito: 'Visitantes de negocios', 'Tipo de Visa': 'B-1' },
        { Propósito: 'Tripulación (en servicio a bordo de un barco o un avión en los Estados Unidos)', 'Tipo de Visa': 'D' },
        { Propósito: 'Diplomáticos y funcionarios de un gobierno extranjero', 'Tipo de Visa': 'A' },
        { Propósito: 'Empleados domésticos o niñeras (deben ir acompañando a un empleador extranjero)', 'Tipo de Visa': 'B-1' },
        { Propósito: 'Empleados de una organización internacional designada y OTAN', 'Tipo de Visa': 'G1-G5, NATO' },
        { Propósito: 'Visitantes de intercambio', 'Tipo de Visa': 'J' },
        { Propósito: 'Visitantes de intercambio - au pairs', 'Tipo de Visa': 'J-1' },
        { Propósito: 'Visitantes de intercambio – hijos (menores de 21 años) o cónyuge del titular de una visa J-1', 'Tipo de Visa': 'J-2' },
        { Propósito: 'Visitantes de intercambio – profesores, investigadores, maestros', 'Tipo de Visa': 'J-1' },
        { Propósito: 'Visitantes de intercambio – intercambio cultural', 'Tipo de Visa': 'J, Q' },
        { Propósito: 'Prometido(a)', 'Tipo de Visa': 'K-1' },
        { Propósito: 'Personal militar y extranjero emplazados en los Estados Unidos', 'Tipo de Visa': 'A-2, NATO1-6' },
        { Propósito: 'Ciudadanos extranjeros con habilidad extraordinaria en las ciencias, las artes, educación, negocios o atletismo', 'Tipo de Visa': 'O-1' },
        { Propósito: 'Profesionales del Tratado de Libre Comercio (TLC): Chile', 'Tipo de Visa': 'H-1B1' },
        { Propósito: 'Profesionales del Tratado de Libre Comercio (TLC): Singapur', 'Tipo de Visa': 'H-1B1' },
        { Propósito: 'Representante de información de medios de comunicación (medios de comunicación, periodistas)', 'Tipo de Visa': 'I' },
        { Propósito: 'Transferencia de empleados de una compañía', 'Tipo de Visa': 'L' },
        { Propósito: 'Tratamiento médico', 'Tipo de Visa': 'B-2' },
        { Propósito: 'Trabajadores profesionales TLCAN (NAFTA): México, Canadá', 'Tipo de Visa': 'TN/TD' },
        { Propósito: 'Enfermeras que viajan a áreas con escasez de profesionales de la salud', 'Tipo de Visa': 'H-1C' },
        { Propósito: 'Médicos', 'Tipo de Visa': 'J-1, H-1B' },
        { Propósito: 'Trabajadores religiosos', 'Tipo de Visa': 'R' },
        { Propósito: 'Ocupaciones especializadas en campos que requieren un alto conocimiento especializado', 'Tipo de Visa': 'H-1B' },
        { Propósito: 'Estudiantes – estudiantes académicos y de idioma', 'Tipo de Visa': 'F-1' },
        { Propósito: 'Dependientes de estudiantes – dependiente del titular de una visa F-1', 'Tipo de Visa': 'F-2' },
        { Propósito: 'Estudiantes - vocacional', 'Tipo de Visa': 'M-1' },
        { Propósito: 'Dependientes de estudiantes – dependiente del titular de una visa M-1', 'Tipo de Visa': 'M-2' },
        { Propósito: 'Trabajadores agrícolas temporales – estacionales', 'Tipo de Visa': 'H-2A' },
        { Propósito: 'Trabajadores temporales – no agrícolas', 'Tipo de Visa': 'H-2B' },
        { Propósito: 'Visitantes por turismo, vacaciones, placer', 'Tipo de Visa': 'B-2' },
        { Propósito: 'Entrenamiento en un programa sin fines de empleo', 'Tipo de Visa': 'H-3' },
        { Propósito: 'Inversionistas', 'Tipo de Visa': 'E-2' },
        { Propósito: 'Comerciantes', 'Tipo de Visa': 'E-1' },
        { Propósito: 'En tránsito en los Estados Unidos', 'Tipo de Visa': 'C' },
        { Propósito: 'Víctimas del tráfico de personas', 'Tipo de Visa': 'T-1' },
        { Propósito: 'Renovaciones de visa en los Estados Unidos - A, G, y OTAN', 'Tipo de Visa': 'A1-2, G1-4, NATO1-6' }
    ];

    // Construir el fragmento HTML para las opciones
    let options = '<option value="" disabled>Seleccione un tipo de visa</option>'; // Opción por defecto

    tiposVisa.forEach(function (option) {
        const selected = visaSeleccionada === option['Tipo de Visa'] ? 'selected' : '';
        options += `<option value="${option['Tipo de Visa']}" ${selected}>${option['Tipo de Visa']} - ${option.Propósito}</option>`;
    });

    // Seleccionamos el select específico por su ID
    var $select = $(`#${selectVisaID}`);

    // Validamos que el select exista en el DOM
    if ($select.length === 0) {
        console.error(`El select con ID ${selectVisaID} no fue encontrado`);
        return;
    }

    // Añadimos todas las opciones de una sola vez
    $select.html(options);

    // Inicializamos select2 si es necesario
    $select.select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5',
        width: '100%'
    });
}

function cargarPaisesDireccion(paisSeleccionado = '', selectPaisID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectPaisID) {
        console.error('ID del select es requerido');
        return;
    }

    // Array de países predefinido
    const paises = [{ label: 'EEUU' }, { label: 'Mexico' }, { label: 'Otro' }];

    // Construir el fragmento HTML para las opciones
    let options = '<option value="" disabled>Seleccione un país</option>'; // Opción por defecto

    paises.forEach(function (option) {
        const selected = paisSeleccionado === option.label ? 'selected' : '';
        options += `<option value="${option.label}" ${selected}>${option.label}</option>`;
    });

    // Seleccionamos el select específico por su ID
    var $select = $(`#${selectPaisID}`);

    // Validamos que el select exista en el DOM
    if ($select.length === 0) {
        console.error(`El select con ID ${selectPaisID} no fue encontrado`);
        return;
    }

    // Añadimos todas las opciones de una sola vez
    $select.html(options);

    // Inicializamos select2 si es necesario
    $select.select2({
        placeholder: 'Seleccione un país',
        theme: 'bootstrap-5',
        width: '100%'
    });
}

function cargarParentescos(parentescoSeleccionado = '', selectParentescoID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectParentescoID) {
        console.error('ID del select es requerido');
        return;
    }

    // Array Parentescos predefinido
    const Parentescos = [
        { label: 'Hijo/a' },
        { label: 'Esposo/a' },
        { label: 'Padre/Madre' },
        { label: 'Hermano/a' },
        { label: 'Abuelo/a' },
        { label: 'Nieto/a' },
        { label: 'Tío/a' },
        { label: 'Sobrino/a' },
        { label: 'Primo/a' },
        { label: 'Yerno/Nuera' },
        { label: 'Suegro/a' },
        { label: 'Padrastro/Madrastra' },
        { label: 'Hermanastro/a' },
        { label: 'Amigo/a' },
        { label: 'Colega' },
        { label: 'Vecino/a' },
        { label: 'Pareja (no casados)' },
        { label: 'Novio/a' },
        { label: 'Compañero/a de cuarto' },
        { label: 'Otro' }
    ];

    // Construir el fragmento HTML para las opciones
    let options = '<option value="" disabled>Seleccione un parentesco</option>'; // Opción por defecto

    Parentescos.forEach(function (option) {
        const selected = parentescoSeleccionado === option.label ? 'selected' : '';
        options += `<option value="${option.label}" ${selected}>${option.label}</option>`;
    });

    // Seleccionamos el select específico por su ID
    var $select = $(`#${selectParentescoID}`);

    // Validamos que el select exista en el DOM
    if ($select.length === 0) {
        console.error(`El select con ID ${selectParentescoID} no fue encontrado`);
        return;
    }

    // Añadimos todas las opciones de una sola vez
    $select.html(options);

    // Inicializamos select2 si es necesario
    $select.select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5',
        width: '100%'
    });
}

function cargarEstatusMigratorio(estatusSeleccionado = '', selectEstatusID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectEstatusID) {
        console.error('ID del select es requerido');
        return;
    }

    // Array EstatusMigratorio predefinido
    const EstatusMigratorio = [
        { label: 'Ciudadano/a' },
        { label: 'Residente Permanente' },
        { label: 'Visa de Trabajo' },
        { label: 'Visa de Estudiante' },
        { label: 'Refugiado/a o Asilado/a' },
        { label: 'Sin Documentos' },
        { label: 'En Proceso de Naturalización' },
        { label: 'Otro Estatus Migratorio' },
        { label: 'Desconocido' }
    ];

    // Construir el fragmento HTML para las opciones
    let options = '<option value="" disabled>Seleccione un estatus migratorio</option>'; // Opción por defecto

    EstatusMigratorio.forEach(function (option) {
        const selected = estatusSeleccionado === option.label ? 'selected' : '';
        options += `<option value="${option.label}" ${selected}>${option.label}</option>`;
    });

    // Seleccionamos el select específico por su ID
    var $select = $(`#${selectEstatusID}`);

    // Validamos que el select exista en el DOM
    if ($select.length === 0) {
        console.error(`El select con ID ${selectEstatusID} no fue encontrado`);
        return;
    }

    // Añadimos todas las opciones de una sola vez
    $select.html(options);

    // Inicializamos select2 si es necesario
    $select.select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5',
        width: '100%'
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

function cargarPaises(paisSeleccionado = '', selectPaisID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectPaisID) {
        console.error('ID del select es requerido');
        return;
    }

    // Hacemos la llamada AJAX para obtener los países
    $.ajax({
        url: `${baseUrl}api/worldCountries`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Obtenemos el select específico por su ID
            var $select = $(`#${selectPaisID}`);

            // Validamos que el select exista en el DOM
            if ($select.length === 0) {
                console.error(`El select con ID ${selectPaisID} no fue encontrado`);
                return;
            }

            // Limpiamos el select y agregamos la opción por defecto
            $select.empty();
            $select.append($('<option>', { value: '', text: 'Seleccione un país' }));

            // Llenamos el select con los países
            $.each(response, function (i, country) {
                $select.append($('<option>', { value: country.name, text: country.name }));
            });

            // Inicializamos select2 para el select actual
            $select.select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Seleccionamos el país si hay un valor preseleccionado
            if (paisSeleccionado) {
                $select.val(paisSeleccionado).trigger('change');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar los países: ' + error);
        }
    });
}

function cargarNacionalidades(paisSeleccionado = '', selectNacionalidadID = '') {
    // Validamos que se haya pasado un ID válido
    if (!selectNacionalidadID) {
        console.error('ID del select es requerido');
        return;
    }

    // Hacemos la llamada AJAX para obtener las nacionalidades
    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Obtenemos el select específico por su ID
            var $select = $(`#${selectNacionalidadID}`);

            // Validamos que el select exista en el DOM
            if ($select.length === 0) {
                console.error(`El select con ID ${selectNacionalidadID} no fue encontrado`);
                return;
            }

            // Limpiamos el select y agregamos la opción por defecto
            $select.empty();
            $select.append($('<option>', { value: '', text: 'Seleccione una nacionalidad' }));

            // Llenamos el select con las nacionalidades (usando traducción en español)
            data.forEach(function (country) {
                if (country.translations && country.translations.spa && country.translations.spa.common) {
                    $select.append($('<option>', { value: country.translations.spa.common, text: country.translations.spa.common }));
                }
            });

            // Inicializamos select2 para el select actual
            $select.select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Seleccionamos el país si hay un valor preseleccionado
            if (paisSeleccionado) {
                $select.val(paisSeleccionado).trigger('change');
            }
        },
        error: function (error) {
            console.error('Error al obtener las nacionalidades: ', error);
        }
    });
}
