$(document).ready(function () {
    // Mostrar / Ocultar Contraseña
    $('#togglePassword').click(function () {
        const passwordField = $('#password');
        const passwordFieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', passwordFieldType);

        const icon = $(this).find('#icon-eye');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    // Almacenar y recuperar correo electrónico usando localForage
    if (typeof localforage !== 'undefined') {
        // Recuperar el último correo electrónico ingresado
        localforage.getItem('lastEmail').then(function (value) {
            if (value) {
                $('#email').val(value);
            }
        });

        // Guardar el correo electrónico al enviar el formulario
        $('#frmLogin').submit(function () {
            const email = $('#email').val();
            localforage.setItem('lastEmail', email);
        });
    }

    // Validación del formulario con jQuery Validate
    $('#frmLogin').validate({
        errorElement: 'div', // Usar un <div> para los mensajes de error
        errorClass: 'invalid-feedback', // Clase Bootstrap para mensajes de error
        highlight: function (element) {
            $(element).addClass('is-invalid'); // Agregar borde rojo en campos inválidos
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid'); // Remover borde rojo en campos válidos
        },
        rules: {
            correo_electronico: {
                required: true,
                email: true
            },
            contrasena: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            correo_electronico: {
                required: 'El correo electrónico es obligatorio.',
                email: 'Debe ingresar un correo electrónico válido.'
            },
            contrasena: {
                required: 'La contraseña es obligatoria.',
                minlength: 'La contraseña debe tener al menos 6 caracteres.'
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr('name') == 'contrasena') {
                error.insertAfter(element.closest('.input-group')); // Mostrar error debajo del input-group
            } else {
                error.insertAfter(element); // Para otros campos, mostrar debajo del input
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
