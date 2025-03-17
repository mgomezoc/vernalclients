$(document).ready(function () {
    // Almacenar y recuperar correo electrónico usando localForage
    localforage.getItem('lastEmail').then(function (value) {
        if (value) {
            $('#email').val(value);
        }
    });

    // Inicializar validaciones con jQuery Validate
    $('form').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: 'Por favor, ingresa tu correo electrónico.',
                email: 'Por favor, ingresa un correo electrónico válido.'
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger small');
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            // Guardar el correo en localForage
            const email = $('#email').val();
            localforage.setItem('recoveryEmail', email);

            // Deshabilitar el botón de envío mientras se procesa
            $('button[type=submit]').prop('disabled', true).text('Enviando...');

            // Enviar el formulario
            form.submit();
        }
    });
});
