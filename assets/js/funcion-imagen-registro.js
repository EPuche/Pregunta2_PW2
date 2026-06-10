document.addEventListener("DOMContentLoaded", function () {
    const inputFoto = document.getElementById("foto_perfil");
    const previewFoto = document.querySelector(".user-avatar");

    inputFoto.addEventListener("change", function () {
    const archivo = this.files[0];

    if (archivo) {
    const lector = new FileReader();

    lector.onload = function (e) {
    previewFoto.innerHTML = "";
    previewFoto.style.backgroundImage = `url('${e.target.result}')`;
    previewFoto.style.backgroundSize = "cover";
    previewFoto.style.backgroundPosition = "center";
};
    lector.readAsDataURL(archivo);
}
});
});