/**
 * CLIENTES ASIGNADOS (ABOGADO)
 *
 */

$(function () {
    $('#tablaClientes').bootstrapTable({
        url: baseUrl + 'clientes/asignados-obtener',
        search: true,
        showRefresh: true,
        pagination: true,
        pageSize: 50,
        iconsPrefix: 'fa-duotone',
        icons: {
            paginationSwitchDown: 'fa-caret-square-down',
            paginationSwitchUp: 'fa-caret-square-up',
            refresh: 'fa-sync',
            toggleOff: 'fa-toggle-off',
            toggleOn: 'fa-toggle-on',
            columns: 'fa-th-list',
            detailOpen: 'fa-circle-plus',
            detailClose: 'fa-circle-minus'
        }
    });
});

function columnaEstatus(value, row) {
    let color = '';

    switch (row.estatus) {
        case '1':
            color = 'text-bg-secondary';
            break;
        case '2':
            color = 'text-bg-light';
            break;
        case '3':
            color = 'text-bg-primary';
            break;
        case '4':
            color = 'text-bg-success';
            break;
        case '5':
            color = 'text-bg-danger';
            break;
        case '6':
            color = 'text-bg-info';
            break;
        default:
            color = 'text-bg-dark';
            break;
    }

    return `<span class="badge ${color}">${value}</span>`;
}

function formatoNombre(value, row, index, field) {
    return `<a href="${baseUrl}/clientes/${row.id_cliente}" target="_blank">${value}</a>`;
}
