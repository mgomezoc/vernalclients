/**
 * 
 * LOGIN
 * 
 */

// Inicializa reCAPTCHA con tu clave de sitio
grecaptcha.ready(function () {
    grecaptcha.execute('6Lec0ccnAAAAAKFUlFpz2MPD2ZjV2YKC14-0l0KV', { action: 'login' })
        .then(function (token) {
            // Agrega el token a un campo oculto en el formulario
            document.getElementById('recaptchaToken').value = token;
        });
});


$(function () {
    $("#frmLogin").validate();
});