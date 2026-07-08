document.addEventListener("DOMContentLoaded", () => {

    function limitarTamaño(canvas, ancho = 250, alto= 250) {
        if (canvas) {
            canvas.style.maxWidth = ancho + "px";
            canvas.style.maxHeight = alto + "px";
            canvas.style.margin = "0 auto";
        }
    }

    const sexoCanvas = document.getElementById("sexoChart");
    if (sexoCanvas) {
        limitarTamaño(sexoCanvas);
        const labels = JSON.parse(sexoCanvas.dataset.labels || "[]");
        const datos = JSON.parse(sexoCanvas.dataset.datos || "[]");
        new Chart(sexoCanvas, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [{
                    data: datos,
                    backgroundColor: ["#36A2EB", "#FF6384", "#FFCE56"]
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        color: "#070606",
                        formatter: function (value, context) {
                            const label = context.chart.data.labels[context.dataIndex];
                            return label + ": " + value;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }


    const edadCanvas = document.getElementById("edadChart");
    if (edadCanvas) {
        limitarTamaño(edadCanvas);
        const labels = JSON.parse(edadCanvas.dataset.labels || "[]");
        const datos = JSON.parse(edadCanvas.dataset.datos || "[]");
        new Chart(edadCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Usuarios",
                    data: datos,
                    backgroundColor: "#4BC0C0"
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        color: "#111010",
                        formatter: function (value) {
                            return value;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }


    const corrCanvas = document.getElementById("correctasChart");
    if (corrCanvas) {
        limitarTamaño(corrCanvas);
        const labels = JSON.parse(corrCanvas.dataset.labels || "[]");
        const datos = JSON.parse(corrCanvas.dataset.datos || "[]");
        new Chart(corrCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "% Respuestas Correctas  por usuario",
                    data: datos,
                    borderColor: "#36A2EB",
                    backgroundColor: "#dc36eb",
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        color: "#070707",
                        formatter: function (value) {
                            return value + "%";
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    const paisCanvas = document.getElementById("paisChart");
    if (paisCanvas) {
        limitarTamaño(paisCanvas, 800);

        const labels = JSON.parse(paisCanvas.dataset.labels || "[]");
        const datos = JSON.parse(paisCanvas.dataset.datos || "[]");


        new Chart(paisCanvas, {

            type: "bar",

            data: {
                labels: labels,
                datasets: [{
                    label: "Usuarios",
                    data: datos,
                    backgroundColor: "#FF9232"
                }]
            },


            options: {

                indexAxis: "y",

                maintainAspectRatio: false,

                responsive: true,


                plugins: {

                    datalabels: {

                        anchor: "center",
                        align: "center",
                        color: "#111010",

                        formatter: function (value) {
                            return value;
                        }

                    }

                }

            },

            plugins: [ChartDataLabels]

        });

    }

});
