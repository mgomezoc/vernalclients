$(document).ready(function () {
    // ✅ Validación con jQuery Validate
    $('#frmRestablecer').validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                minlength: 6,
                equalTo: "[name='password']"
            }
        },
        messages: {
            password: {
                required: 'Por favor, ingresa tu nueva contraseña.',
                minlength: 'La contraseña debe tener al menos 6 caracteres.'
            },
            confirm_password: {
                required: 'Por favor, confirma tu nueva contraseña.',
                minlength: 'La contraseña debe tener al menos 6 caracteres.',
                equalTo: 'Las contraseñas no coinciden.'
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.closest('.input-group').length) {
                element.closest('.input-group').append(error);
            } else {
                element.after(error);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });

    // ✅ Toggle mostrar/ocultar contraseña
    $('.toggle-password').click(function () {
        let input = $(this).closest('.input-group').find('input');
        let icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
