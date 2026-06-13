let map;
let marker;

async function initMap() {
    const ubicacionDefault = { lat: -34.6037, lng: -58.3816 };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: ubicacionDefault,
    });
    marker = new google.maps.Marker({
        position: ubicacionDefault,
        map: map,
        draggable: true
    });
    actualizarCoordenadas(ubicacionDefault.lat, ubicacionDefault.lng);

    map.addListener("click", (event) => {
        const nuevaPosicion = event.latLng;
        marker.setPosition(nuevaPosicion);
        actualizarCoordenadas(nuevaPosicion.lat(), nuevaPosicion.lng());
    });
    marker.addListener("dragend", () => {
        const posicionMarcador = marker.getPosition();
        actualizarCoordenadas(posicionMarcador.lat(), posicionMarcador.lng());
    });
}
function actualizarCoordenadas(lat, lng) {

    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;
}
window.initMap = initMap;
