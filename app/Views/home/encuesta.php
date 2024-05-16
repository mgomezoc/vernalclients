<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción de Clientes</title>

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("css/intake.css") ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/901438e2f4.js" crossorigin="anonymous"></script>
</head>

<body>
    <header class="container header mt-3">
        <div class="row align-items-center mb-3">
            <div class="col-md-5">
                <div class="p-4">
                    <img src="<?= base_url("img/logo.svg") ?>" alt="" class="img-fluid" width="100%">
                </div>
            </div>
            <div class="col-md-7"></div>
        </div>
    </header>

    <div class="container">
        <div class="card mb-5">
            <div class="card-body p-5">
                <h3 class="mb-4">Encuesta de Satisfacción de Clientes</h3>

                <form id="frmEncuesta" method="post" autocomplete="off">
                    <input type="hidden" name="slug_cliente" value="<?= $cliente["slug"] ?>">
                    <div class="mb-3">
                        <label for="pregunta1" class="form-label">1. ¿Cuán probable es que recomiende nuestros servicios?</label>
                        <select name="probabilidad_recomendacion" id="" class="form-select select2">
                            <option value="1">Nada probable</option>
                            <option value="3">Improbable</option>
                            <option value="5" selected>Neutral</option>
                            <option value="8">Probable</option>
                            <option value="10">Muy probable</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta2" class="form-label">2. ¿Cómo calificaría la calidad del servicio proporcionado?</label>
                        <select name="calificacion_servicio" class="form-select" id="pregunta2">
                            <option value="1">Muy insatisfactorio</option>
                            <option value="2">Insatisfactorio</option>
                            <option value="3">Neutral</option>
                            <option value="4">Satisfactorio</option>
                            <option value="5">Muy satisfactorio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta3" class="form-label">3. ¿Considera que el tiempo de respuesta fue adecuado?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tiempo_respuesta_adeuado" id="si" value="si" required>
                            <label class="form-check-label" for="si">Sí</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tiempo_respuesta_adeuado" id="no" value="no">
                            <label class="form-check-label" for="no">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta4" class="form-label">4. ¿Cómo evalúa el profesionalismo y la actitud de nuestro personal?</label>
                        <select name="profesionalismo_actitud" class="form-select" id="pregunta4">
                            <option value="1">Muy insatisfactorio</option>
                            <option value="2">Insatisfactorio</option>
                            <option value="3">Neutral</option>
                            <option value="4">Satisfactorio</option>
                            <option value="5">Muy satisfactorio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta5" class="form-label">5. ¿Cómo cree que el precio del servicio corresponde con el valor recibido?</label>
                        <select name="precio_valor_correspondencia" class="form-select" id="pregunta5">
                            <option value="1">Valor mucho menor que el precio</option>
                            <option value="2">Valor ligeramente menor que el precio</option>
                            <option value="3">Valor correspondiente al precio</option>
                            <option value="4">Valor ligeramente mayor que el precio</option>
                            <option value="5">Valor mucho mayor que el precio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta6" class="form-label">6. ¿Comentarios o sugerencias para mejorar nuestro servicio?</label>
                        <textarea name="comentarios_sugerencias" class="form-control" id="pregunta6" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-duotone fa-paper-plane me-2"></i>
                        <span>Enviar Encuesta</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const baseUrl = "<?= base_url() ?>";
        const Cliente = <?= json_encode($cliente) ?>;
    </script>
    <script src="<?= base_url("js/encuesta.js") ?>" defer></script>

</body>

</html>