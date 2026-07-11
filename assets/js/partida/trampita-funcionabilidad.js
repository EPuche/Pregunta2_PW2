document.addEventListener("DOMContentLoaded", () => {
    const btnUsar = document.getElementById("btn-usar-trampita");
    const contador = document.getElementById("contador-trampitas");


    if (btnUsar) {
        btnUsar.addEventListener("click", () => {
            let cantidadActual = parseInt(contador.innerText);

            if (cantidadActual <= 0) {
                alert("¡No te quedan trampitas!");
                return;
            }

            fetch("/partida/usarTrampita", {
                method: "POST"
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        contador.innerText = cantidadActual - 1;
                        btnUsar.style.display = "none";

                        const opciones = Array.from(document.querySelectorAll("#contenedor-opciones button"));


                        const opcionesIncorrectas = opciones.filter(boton => boton.getAttribute("data-correcta") === "false");


                        const incorrectasParaEliminar = opcionesIncorrectas
                            .sort(() => 0.5 - Math.random())
                            .slice(0, 2);

                        incorrectasParaEliminar.forEach(boton => {
                             boton.disabled = true;
                             boton.style.opacity = "0.3";
                        });
                    } else {
                        alert(data.error || "No se pudo usar la trampita.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error de red al intentar usar la trampita.");
                });
        });
    }

});