<div class="card card-body">
    <div class="section-header">
        <h1 class="section-title">Sucursales</h1>
        <div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaSucursal">Añadir
                nueva</button>
        </div>
    </div>
    <div class="section-table">
        <div class="table-responsive">
            <table id="tablaSucursales" class="table table-striped table-sm table-linklaw">
                <thead>
                    <tr>
                        <th data-field="nombre">Sucursal</th>
                        <th data-field="direccion">Dirección</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="url_google_maps" data-formatter="formatoUbicacion" data-align="center">Ubicación</th>
                        <th data-field="id" data-formatter="accionesTabla" data-align="center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<template id="tplAccionesTabla">
    <button class="btnEliminarSucursal btn btn-sm btn-danger" data-id="{{id}}" title="Eliminar {{nombre}}">
        <i class="fa-duotone fa-trash"></i>
    </button>
</template>

<!-- Modal -->
<div class="modal fade" id="modalNuevaSucursal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nueva sucursal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmAgregarSucursal" action="#" method="post" class="row g-5">
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre de la sucursal" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección completa" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" pattern="[0-9]{10}">
                        </div>
                        <div class="col-md-4">
                            <label for="url_google_maps" class="form-label">URL Google Maps <span class="text-danger">*</span></label>
                            <input type="url" id="url_google_maps" name="url_google_maps" class="form-control" placeholder="URL de la ubicación en Google Maps" required>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btnAgregarNuevaSucursal" type="button" class="btn btn-primary">Añadir nueva sucursal</button>
            </div>
        </div>
    </div>
</div>

<template id="tplEditarSucursal">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-body p-5">
                    <form action="#" method="post" class="frmEditarSucursal row g-3">
                        <input type="hidden" name="id" value="{{id}}">

                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{nombre}}" class="form-control" placeholder="Nombre de la sucursal" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" id="direccion" name="direccion" value="{{direccion}}" class="form-control" placeholder="Dirección completa" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" value="{{telefono}}" class="form-control" placeholder="Teléfono" pattern="[0-9]{10}">
                        </div>
                        <div class="col-md-4">
                            <label for="url_google_maps" class="form-label">URL Google Maps <span class="text-danger">*</span></label>
                            <input type="url" id="url_google_maps" name="url_google_maps" value="{{url_google_maps}}" class="form-control" placeholder="URL de la ubicación en Google Maps" required>
                        </div>
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary">Actualizar información</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const Sucursales = <?= json_encode($sucursales) ?>;
</script>