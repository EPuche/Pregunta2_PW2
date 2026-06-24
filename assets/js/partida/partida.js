document.addEventListener("DOMContentLoaded", function () {
    let tiempoRestante = parseInt(document.getElementById("contador").textContent) || 0;
    const contador = document.getElementById("contador");
    const form = document.getElementById("form-tiempo-expirado");

    if (tiempoRestante > 0) {
        const interval = setInterval(function () {
            tiempoRestante--;
            contador.textContent = tiempoRestante;

            if (tiempoRestante <= 0) {
                clearInterval(interval);
                form.submit();
            }
        }, 1000); // Se ejecuta cada 1 segundo
    }
});