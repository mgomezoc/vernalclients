/**
 * APP
 *
 */


$(function () {

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
    title: "¿Estás seguro?",
    text: mensaje,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      if (typeof confirmCallback === "function") {
        confirmCallback(...params); // Llamamos al callback con los parámetros
      }
    }
  });
}


