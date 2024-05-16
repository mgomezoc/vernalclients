/**
 * INICIO
 *
 */

const CasosRecientes = [
    {
        nombre: "Cesar Gomez",
        sucursal: "DALLAS"
    },
    {
        nombre: "Alondra Gomez",
        sucursal: "DALLAS"
    },
    {
        nombre: "Laura Manzanares",
        sucursal: "FORT WORTH"
    },
    {
        nombre: "Mya Nallely Viera Galarza",
        sucursal: "DALLAS"
    },
    {
        nombre: "Juan Gil Macias",
        sucursal: "AUSTIN"
    },
    {
        nombre: "Jesus Flores",
        sucursal: "AUSTIN"
    },
    {
        nombre: "Maria Madina",
        sucursal: "AUSTIN"
    },
    {
        nombre: "Juan Melchor",
        sucursal: "AUSTIN"
    }
];

const tablaAbogados = [
    {
        nombre: "Claudia Martinez",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    },
    {
        nombre: "Beatriz Paredes",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    },
    {
        nombre: "Ezquiel Gomez",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    },
    {
        nombre: "Juana Martinez",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    },
    {
        nombre: "Alonso Sepulveda",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    },
    {
        nombre: "Jorge Martinez",
        activos: "15",
        calificados: "25",
        cerrados: "8",
    }
]

$(function () {
    setActiveMenu("/");

    const ctx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfica
        data: {
            labels: ['Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre'],
            datasets: [
                {
                    label: 'Intakes totales recibidos',
                    data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                    backgroundColor: 'rgba(30, 74, 115, 0.9)',
                    borderColor: 'rgb(30 74 115)',
                    borderWidth: 1
                },
                {
                    label: 'Casos activos',
                    data: [3, 5, 10, 15, 20, 22, 30, 80, 90, 100, 110, 120],
                    backgroundColor: 'rgb(98 183 50)',
                    borderColor: 'rgb(98 183 50)',
                    borderWidth: 1
                },
                {
                    label: 'Casos no calificados',
                    data: [7, 15, 20, 35, 28, 60, 70, 80, 90, 100, 110, 120],
                    backgroundColor: 'rgba(241, 161, 4, 1)',
                    borderColor: 'rgba(241, 161, 4, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Casos cerrados',
                    data: [0, 2, 4, 6, 8, 10, 12, 14, 16, 100, 110, 120],
                    backgroundColor: 'rgba(159, 168, 53, 1)',
                    borderColor: 'rgba(159, 168, 53, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            maintainAspectRatio: false,
        }
    });

    $("#tablaCasosRecientes").bootstrapTable({
        data: CasosRecientes
    });

    initPieChart();

    $("#tablaAbogados").bootstrapTable({
        data: tablaAbogados
    });

    initCasosAbiertos();
});


function initPieChart() {
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'pie', // Tipo de gráfica
        data: {
            labels: ['Dallas', 'Fort Worth', 'Austin', 'Houston'], // Etiquetas de las ciudades
            datasets: [{
                data: [41, 34, 13, 12], // Datos de los porcentajes de cada ciudad
                backgroundColor: [ // Colores asignados a cada segmento
                    'rgb(30 74 115)',
                    'rgb(98 183 50)',
                    'rgba(241, 161, 4, 1)',
                    'rgba(159, 168, 53, 1)'
                ],
                borderColor: [ // Colores del borde para cada segmento
                    '#fff', // Usando blanco para todos los bordes
                    '#fff',
                    '#fff',
                    '#fff'
                ],
                borderWidth: 1 // Ancho del borde de cada segmento
            }]
        },
        options: {
            maintainAspectRatio: false, // Esto permite que la gráfica ocupe todo el alto del contenedor
            plugins: {
                legend: {
                    display: true, // Esto mostrará la leyenda
                    position: 'bottom' // Puedes cambiar la posición de la leyenda si así lo deseas
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat('en-US', { style: 'percent', minimumFractionDigits: 0 }).format(context.parsed / 100);
                            }
                            return label;
                        }
                    }
                },
                datalabels: {
                    formatter: (value, context) => {
                        return `${value}%`;
                    },
                    color: '#fff', // Color de las etiquetas
                    anchor: 'end', // Posición de las etiquetas
                    align: 'start' // Alineación de las etiquetas
                }
            }
        },
        plugins: [ChartDataLabels] // Asegúrate de haber incluido ChartDataLabels si vas a usar este plugin
    });


}

function initCasosAbiertos() {
    const ctx = document.getElementById('myHorizontalBarChart').getContext('2d');
    const myHorizontalBarChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico
        data: {
            labels: ['Dallas', 'Fort Worth', 'Austin', 'Houston'], // Sucursales en el eje Y
            datasets: [{
                label: 'Casos activos', // Título de la serie de datos
                data: [50, 75, 150, 120], // Número de casos activos por sucursal
                backgroundColor: [ // Colores para cada barra
                    'rgb(30 74 115)',
                    'rgb(98 183 50)',
                    'rgba(241, 161, 4, 1)',
                    'rgba(159, 168, 53, 1)'
                ]
            }]
        },
        options: {
            indexAxis: 'y', // Esto hace que la gráfica sea horizontal
            scales: {
                x: {
                    beginAtZero: true // Iniciar el eje X desde cero
                }
            },
            maintainAspectRatio: false // Esto permite que la gráfica ocupe todo el alto del contenedor
        }
    });
}