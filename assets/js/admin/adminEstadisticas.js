document.addEventListener("DOMContentLoaded", () => {

  function limitarTamaño(canvas) {
    if (canvas) {
      canvas.style.maxWidth = "250px";
      canvas.style.maxHeight = "250px";
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
        responsive: true
      }
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
        responsive: true
      }
    });
  }


  const corrCanvas = document.getElementById("correctasChart");
  if (corrCanvas) {
    limitarTamaño(corrCanvas);
    const labels = JSON.parse(corrCanvas.dataset.labels || "[]");
    const datos = JSON.parse(corrCanvas.dataset.datos || "[]");
    new Chart(corrCanvas, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "% Correctas (promedio por usuario)",
          data: datos,
          borderColor: "#36A2EB",
          backgroundColor:"#dc36eb",
          fill: false,
          tension: 0.3
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true
      }
    });
  }
});
