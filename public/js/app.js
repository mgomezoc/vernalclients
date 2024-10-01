/**
 * APP
 *
 */

Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
    switch (operator) {
        case '==':
            return v1 == v2 ? options.fn(this) : options.inverse(this);
        case '===':
            return v1 === v2 ? options.fn(this) : options.inverse(this);
        case '!=':
            return v1 != v2 ? options.fn(this) : options.inverse(this);
        case '!==':
            return v1 !== v2 ? options.fn(this) : options.inverse(this);
        case '<':
            return v1 < v2 ? options.fn(this) : options.inverse(this);
        case '<=':
            return v1 <= v2 ? options.fn(this) : options.inverse(this);
        case '>':
            return v1 > v2 ? options.fn(this) : options.inverse(this);
        case '>=':
            return v1 >= v2 ? options.fn(this) : options.inverse(this);
        case '&&':
            return v1 && v2 ? options.fn(this) : options.inverse(this);
        case '||':
            return v1 || v2 ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});

let tplResultados = '';

$(function () {
    $(document).ajaxComplete(function (event, xhr, settings) {
        // Comprobamos si la respuesta contiene el formulario de inicio de sesión
        if (xhr.status === 200 && xhr.responseText.includes('id="frmLogin"')) {
            window.location.href = baseUrl + 'login';
        }
    });

    tplResultados = $('#tplResultados').html();

    $('#search').on('keyup', function () {
        let searchTerm = $(this).val();
        if (searchTerm.length > 2) {
            $('#results').show();
            $.ajax({
                url: `${baseUrl}buscar`,
                type: 'GET',
                data: { term: searchTerm },
                dataType: 'json',
                success: function (data) {
                    if (data.casos.length > 0 || data.clientes.length > 0) {
                        const renderData = Handlebars.compile(tplResultados)(data);
                        $('#results').html(renderData);
                    } else {
                        $('#results').html('<p>No se encontraron resultados.</p>');
                    }
                }
            });
        } else {
            $('#results').hide();
            $('#results').html('');
        }
    });
});

function setActiveMenu(menu) {
    $(`.menu-link[data-menu="${menu}"]`).addClass('active');
}

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function mostrarConfirmacion(mensaje, confirmCallback, ...params) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: mensaje,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof confirmCallback === 'function') {
                confirmCallback(...params); // Llamamos al callback con los parámetros
            }
        }
    });
}

function showSweetAlert(type, message) {
    Swal.fire({
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        customClass: {
            popup: 'colored-toast'
        }
    });
}

function ajaxCall(options) {
    return $.ajax({
        ...options,
        success: function (response, textStatus, xhr) {
            // Verificar si la respuesta es HTML de la página de inicio de sesión
            if (typeof response === 'string' && response.includes('<title>Log in')) {
                handleSessionExpired();
            } else if (options.success) {
                options.success(response);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            if (isSessionExpired(xhr)) {
                handleSessionExpired();
            } else {
                handleError(xhr.status, xhr, textStatus, errorThrown);
            }
        }
    });
}

function isSessionExpired(xhr) {
    return xhr.status === 200 && typeof xhr.responseText === 'string' && xhr.responseText.includes('<title>Log in');
}

function handleSessionExpired() {
    swal.fire('Sesión Expirada', 'Tu sesión ha expirado. Por favor, vuelve a iniciar sesión.', 'warning').then(() => {
        // Redirigir al usuario a la página de inicio de sesión
        window.location.href = `${baseUrl}/login`;
    });
}

function handleError(status, xhr, textStatus, errorThrown) {
    switch (status) {
        case 400:
            swal.fire('Solicitud Incorrecta', 'La solicitud no pudo ser procesada. Por favor, verifica los datos ingresados.', 'error');
            break;
        case 404:
            swal.fire('No Encontrado', 'El recurso solicitado no se encontró. Por favor, verifica la URL.', 'error');
            break;
        case 500:
            swal.fire('Error del Servidor', 'Ocurrió un error interno en el servidor. Por favor, inténtalo de nuevo más tarde.', 'error');
            break;
        default:
            swal.fire('Error', `Ocurrió un error: ${textStatus}. Por favor, inténtalo de nuevo más tarde.`, 'error');
            break;
    }
    console.error('Error en la llamada Ajax:', textStatus, errorThrown);
}

function columnaEstatus(value, row) {
    const estatusClasses = {
        1: 'text-bg-secondary', // prospecto - neutral
        2: 'text-bg-warning', // intake - esperando acción
        3: 'text-bg-primary', // asignado - en progreso
        4: 'text-bg-success', // elegible - aprobado
        5: 'text-bg-danger', // no elegible - rechazado
        6: 'text-bg-info', // activo - en acción
        7: 'text-bg-secondary', // inactivo - estado neutro, no activo
        8: 'text-bg-dark' // por asignar - esperando asignación
    };

    const defaultClass = 'text-bg-dark';
    const color = estatusClasses[row.estatus] || defaultClass;

    return `<span class="badge ${color} badge-min-width" title="${row.descripcion_estatus}" data-toggle='tooltip' data-placement='left'>${value}</span>`;
}

function formatoAmericano(fecha) {
    // Crea un objeto Date a partir de la fecha
    const fechaObj = new Date(fecha);

    // Extrae las partes de la fecha
    const mes = String(fechaObj.getMonth() + 1).padStart(2, '0'); // Los meses en JavaScript son de 0 a 11
    const dia = String(fechaObj.getDate()).padStart(2, '0');
    const año = fechaObj.getFullYear();

    // Extrae las partes de la hora
    const horas = String(fechaObj.getHours()).padStart(2, '0');
    const minutos = String(fechaObj.getMinutes()).padStart(2, '0');
    const segundos = String(fechaObj.getSeconds()).padStart(2, '0');

    // Devuelve la fecha en formato americano
    return `${mes}/${dia}/${año} ${horas}:${minutos}:${segundos}`;
}

// Ejemplo de uso
const fechaOriginal = '2024-07-23 06:34:28';
const fechaAmericana = formatoAmericano(fechaOriginal);

console.log(fechaAmericana); // Resultado: 07/23/2024 06:34:28
