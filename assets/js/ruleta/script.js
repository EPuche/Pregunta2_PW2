const canvas = document.getElementById('ruleta');
const ctx = canvas.getContext('2d');
const botonGirar = document.getElementById('boton-girar-central');

const categorias = ['Arte', 'Ciencia', 'Historia', 'Deporte', 'Entretenimiento'];
const colores = ['#93c5fd', '#86efac', '#fde047', '#f97316', '#fca5a5'];
const anguloArc = (2 * Math.PI) / categorias.length;
let anguloActual = 0;

function dibujarRuleta() {
    const centro = canvas.width / 2;
    const radio = canvas.width / 2;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < categorias.length; i++) {
        const angulo = anguloActual + i * anguloArc;

        // Dibujar el sector
        ctx.beginPath();
        ctx.moveTo(centro, centro);
        ctx.arc(centro, centro, radio, angulo, angulo + anguloArc, false);
        ctx.lineTo(centro, centro);
        ctx.fillStyle = colores[i];
        ctx.fill();

        ctx.strokeStyle = 'rgba(255, 255, 255, 0.5)';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Dibujar el texto
        ctx.save();
        ctx.translate(centro, centro);

        // 1. Nos paramos en el centro del sector
        ctx.rotate(angulo + anguloArc / 2);

        // 2. Nos movemos hacia el borde exterior (dejando un margen, ej: el 65% del radio)
        ctx.translate(radio * 0.65, 0);

        // 3. Rotamos 90 grados para que el texto quede perpendicular (como en tu imagen)
        ctx.rotate(Math.PI / 2);

        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle'; // Centrado vertical perfecto
        ctx.fillStyle = '#000000';
        ctx.font = 'bold 15px Poppins, sans-serif';

        // Pintamos en (0,0) porque ya trasladamos el origen
        ctx.fillText(categorias[i], 0, 0);

        ctx.restore();
    }
}

const textoResultado = document.getElementById('texto-resultado');
const categoriaGanadora = document.getElementById('categoria-ganadora');
const formRuleta = document.getElementById('form-ruleta');
const inputCategoria = document.getElementById('input-categoria');
botonGirar.addEventListener('click', () => {
    botonGirar.disabled = true;
    botonGirar.classList.add('disabled');
    textoResultado.classList.add('d-none');

    const giros = Math.floor(Math.random() * 5) + 5;
    const gradosAleatorios = giros * 360 + Math.floor(Math.random() * 360);


    anguloActual += gradosAleatorios * (Math.PI / 180);
    canvas.style.transform = `rotate(${anguloActual}rad)`;

    // Esperamos a que termine la animación (4.5 segundos)
    setTimeout(() => {
        let anguloNormalizado = anguloActual % (2 * Math.PI);
        if (anguloNormalizado < 0) anguloNormalizado += (2 * Math.PI);


        let anguloFlecha = (1.5 * Math.PI - anguloNormalizado) % (2 * Math.PI);
        if (anguloFlecha < 0) anguloFlecha += (2 * Math.PI);


        const indiceGanador = Math.floor(anguloFlecha / anguloArc);
        const categoriaResultante = categorias[indiceGanador];


        categoriaGanadora.innerText = categoriaResultante;
        textoResultado.classList.remove('d-none');
        inputCategoria.value = categoriaResultante;
        formRuleta.classList.remove('d-none');

    }, 4500);
});


document.fonts.ready.then(() => {
    dibujarRuleta();
});