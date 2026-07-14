function initQrShare() {
  const boton = document.getElementById("compartirQR");
  if (!boton) return;

  const baseUrl = boton.dataset.baseUrl;
  const userId = boton.dataset.userId;
  const urlPerfil = `${baseUrl}/index.php?controller=usuario&method=verPerfil&id=${encodeURIComponent(userId)}`;

  boton.addEventListener("click", async () => {
    if (navigator.share) {
      try {
        await navigator.share({
          title: "Mi perfil",
          text: "Accedé a mi perfil escaneando este QR o entrando al link:",
          url: urlPerfil
        });
      } catch (err) {
        console.error("Error al compartir:", err);
      }
    } else {
      alert("Tu navegador no soporta compartir directamente. Copiá este link: " + urlPerfil);
    }
  });
}