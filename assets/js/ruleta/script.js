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


        ctx.beginPath();
        ctx.moveTo(centro, centro);
        ctx.arc(centro, centro, radio, angulo, angulo + anguloArc, false);
        ctx.lineTo(centro, centro);
        ctx.fillStyle = colores[i];
        ctx.fill();


        ctx.strokeStyle = 'rgba(255, 255, 255, 0.5)';
        ctx.lineWidth = 2;
        ctx.stroke();


        ctx.save();
        ctx.translate(centro, centro);
        ctx.rotate(angulo + anguloArc / 2);
        ctx.textAlign = 'right';
        ctx.fillStyle = '#000000'; // Gris oscuro para mejor contraste que el negro puro


        ctx.font = 'bold 15px Poppins, sans-serif';
        ctx.fillText(categorias[i], radio - 25, 6);
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