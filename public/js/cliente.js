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

    const renderData = Handlebars.compile(tplFormulario)(datos);

    $('#formulario_admision').html(renderData);

    $('.btnEncuesta').on('click', function () {
        swal.fire('¡Listo!', 'Se ha enviado la encuesta.', 'success');
    });

    $('.btnCerrarCaso').on('click', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const id_caso = $btn.data('id');

        const data = {
            id_caso: id_caso,
            nuevo_estatus: 4
        };

        actualizarEstatus(data).then(function (r) {
            if (!r.success) {
                swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
            } else {
                swal.fire('¡Listo!', 'Se ha actualizado correctamente la información.', 'success');
                $btn.remove();
            }
        });
    });

    $modalComentarios.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_caso = $btn.data('id');

        console.log(id_caso);
        $('#comentariosContainer').html('...cargando');

        $('#inputCasoComentario').val(id_caso);

        cargarComentarios(id_caso);
    });

    $('#frmComentario').on('submit', function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();

        console.log(formData);

        agregarComentario(formData).then(function (r) {
            console.log(r);
            if (r.success) {
                cargarComentarios(formData.id_caso);
                $frm[0].reset();
                showSweetAlert('success', 'Operación realizada con éxito.');
            }
        });
    });

    $('.btnPagarCaso').on('click', function (e) {
        const $btn = $(this);
        const id_caso = $btn.data('id');
        const forma_pago = $btn.data('tipo');

        const data = {
            id_caso,
            forma_pago
        };

        mostrarConfirmacion('¿Seguro que deseas realizar este pago?', pagarCaso, data);
    });

    $('#frmEditarCliente').on('submit', function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();

        console.log(formData);

        actualizarCliente(formData).then(function (r) {
            if (r.success) {
                showSweetAlert('success', 'Información actualizada correctamente.');
            } else {
                showSweetAlert('error', 'No se pudo actualizar la información.');
            }
        });
    });
});

function actualizarEstatus(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/actualizar-estatus`,
        data: data,
        dataType: 'json'
    });
}

function obtenerComentarios(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/comentarios`,
        data: data,
        dataType: 'json'
    });
}

function agregarComentario(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/comentarios-agregar`,
        data: data,
        dataType: 'json'
    });
}

function cargarComentarios(id_caso) {
    obtenerComentarios({ id_caso }).then(function (r) {
        const data = {
            comentarios: r.data
        };

        const renderData = Handlebars.compile(tplComentarios)(data);
        $('#comentariosContainer').html(renderData);

        console.log(r);
        accionesComentarios();
    });
}

function accionesComentarios() {}

function pagarCaso(data) {
    const formData = {
        id_caso: data.id_caso,
        pagado: 1,
        forma_pago: data.forma_pago
    };
    console.log('pagarCaso', formData);

    editarCaso(formData).then(function (r) {
        console.log(r);
        if (r.success) {
            showSweetAlert('success', 'El pago se ha realizado con éxito.');
            $(`.btnVerCaso[data-id=${formData.id_caso}]`).remove();
        } else {
            showSweetAlert('error', 'No se pudo realizar el pago.');
        }
    });
}

function editarCaso(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}casos/editar`,
        data: data,
        dataType: 'json'
    });
}

function actualizarCliente(data) {
    return ajaxCall({
        type: 'post',
        url: `${baseUrl}clientes/actualizarCliente`,
        data: data,
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
