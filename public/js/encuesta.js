/* ==========================================================================
   ENCUESTA
   ========================================================================== */

$(function () {
    $('#frmEncuesta').on('submit', function (e) {
        e.preventDefault();

        const $frm = $(this);
        const formData = $frm.serializeObject();

        console.log(formData);

        guardarRespuestaEncuesta(formData).then(function (r) {
            if (!r.success) {
                swal.fire('¡Advertencia!', 'Ocurrió algún error, vuelve a intentarlo.', 'warning');
            } else {
                swal.fire('¡Listo!', 'Gracias por enviar tus comentarios.', 'success');
                $frm[0].reset();
            }
        });
    });

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
});

// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtiene los elementos HTML que se utilizarán
    const rangeInput = document.getElementById('pregunta1');
    const outputSpan = document.getElementById('valorPregunta1');

    // Mapeo de valores numéricos a textos
    const valorTexto = {
        0: 'Nada probable',
        1: 'Muy improbable',
        2: 'Improbable',
        3: 'Neutral',
        4: 'Probable',
        5: 'Muy probable',
        6: 'Extremadamente probable',
        7: 'Muy, muy probable',
        8: 'Muy, muy, muy probable',
        9: 'Casi seguro',
        10: 'Muy seguro'
    };

    // Maneja el evento de cambio en el rango
    rangeInput.addEventListener('input', function () {
        // Obtiene el valor numérico del rango
        const valorNumerico = parseInt(rangeInput.value);

        // Obtiene el texto correspondiente del mapeo
        const textoCorrespondiente = valorTexto[valorNumerico];

        // Actualiza el valor mostrado
        outputSpan.textContent = textoCorrespondiente;
    });

    // Puedes agregar más lógica aquí para manejar otros elementos de la encuesta si es necesario
});

function guardarRespuestaEncuesta(data) {
    return $.ajax({
        type: 'post',
        url: `${baseUrl}encuesta/guardarRespuestaEncuesta`,
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}
