let fieldValue = [];

$(function () {
    const $modalCrearCaso = $('#modalCrearCaso');
    const $formCrearCaso = $('#formCrearCaso');

    // Mostrar el modal al hacer clic en el botón
    $('.btnCrearCaso').on('click', function () {
        $modalCrearCaso.modal('show');
    });

    // Configurar las validaciones del formulario
    $formCrearCaso.validate({
        rules: {
            id_tipo_caso: {
                required: true
            },
            comentarios: {
                required: true,
                minlength: 10
            },
            costo: {
                required: true,
                number: true,
                min: 0
            },
            fecha_corte: {
                required: true,
                date: true
            },
            estatus: {
                required: true
            }
        },
        messages: {
            id_tipo_caso: {
                required: 'Seleccione un proceso principal.'
            },
            comentarios: {
                required: 'Este campo es obligatorio.',
                minlength: 'El antecedente debe contener al menos 10 caracteres.'
            },
            costo: {
                required: 'Ingrese el costo del caso.',
                number: 'El costo debe ser un número válido.',
                min: 'El costo debe ser mayor que 0.'
            },
            fecha_corte: {
                required: 'Seleccione la fecha de corte.',
                date: 'Ingrese una fecha válida.'
            },
            estatus: {
                required: 'Seleccione un estatus para el caso.'
            }
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent()); // Para campos con iconos
            } else {
                error.insertAfter(element); // Para otros campos
            }
        },
        submitHandler: function () {
            const formData = $formCrearCaso.serializeObject();

            formData.proceso = $(`#cbProcesosEInmigration option:selected`).text();

            let procesos_adicionales = [];
            $(`#cbProcesosAdicionalesEInmigration option:selected`).each(function (i, option) {
                const $option = $(option);
                procesos_adicionales.push({
                    id: $option.val(),
                    label: $option.text()
                });

                fieldValue.push($option.text());
            });

            formData.procesos_adicionales = JSON.stringify(procesos_adicionales);

            console.log(formData);

            Swal.fire({
                title: 'Creando caso...',
                text: 'Por favor, espere mientras procesamos su solicitud.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            nuevoCaso(formData).then(function (r) {
                Swal.close();

                if (!r.success) {
                    swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Caso creado',
                        text: `Se creo el caso correctamente`
                    }).then(() => {
                        window.location.reload();
                        //const id_caso = r.crearCaso;
                        //eateCase(formData.clientID, formData.sucursal, formData.id_tipo_caso, id_caso);
                    });
                }
            });
            return false;

            Swal.fire({
                title: 'Creando caso...',
                text: 'Por favor, espere mientras procesamos su solicitud.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `${baseUrl}casos/crear`,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.close();

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Caso creado',
                            text: response.message
                        }).then(() => {
                            // Actualizar la tabla de casos
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo crear el caso.'
                        });
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'Ocurrió un problema al intentar crear el caso. Intente nuevamente más tarde.'
                    });
                }
            });
        }
    });

    // Cargar procesos en los selects
    cargarProcesosEInmigration();
});

async function cargarProcesosEInmigration() {
    try {
        const res = await getCaseProcesses();
        if (res && res.data && Array.isArray(res.data)) {
            const selectElement = $('#cbProcesosEInmigration, #cbProcesosAdicionalesEInmigration');
            selectElement.empty();
            res.data.forEach(({ processID, name }) => {
                selectElement.append(new Option(name, processID));
            });
            selectElement.select2({
                placeholder: 'Seleccione un proceso',
                theme: 'bootstrap-5',
                allowClear: true,
                width: '100%'
            }); // Inicia Select2
        } else {
            console.error('Formato de datos inesperado:', res);
        }
    } catch (error) {
        console.error('Error al cargar los procesos:', error);
    }
}

function nuevoCaso(data) {
    return $.ajax({
        type: 'post',
        url: baseUrl + 'clientes/nuevo-caso',
        data: data,
        dataType: 'json'
    });
}
