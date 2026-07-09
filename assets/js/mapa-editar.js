let map;
let marker;
let geocoder;

function initMap() {
    let lat = parseFloat(document.getElementById("latitud").value);
    let lng = parseFloat(document.getElementById("longitud").value);
        console.log("Latitud:", lat);
    console.log("Longitud:", lng);

    if (isNaN(lat) || isNaN(lng)) {
        lat = -34.6037;
        lng = -58.3816;
    }

    const posicion = { lat: lat, lng: lng };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: posicion
    });
   console.log("Centro del mapa:", map.getCenter().toJSON());
    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        position: posicion,
        map: map,
        draggable: true
    });

    // Inicializar país al cargar
    obtenerPais(posicion);

    // Click en el mapa
    map.addListener("click", function (event) {
        marker.setPosition(event.latLng);
        actualizarCoordenadas(event.latLng.lat(), event.latLng.lng());
        obtenerPais({ lat: event.latLng.lat(), lng: event.latLng.lng() });
    });

    // Drag del marcador
    marker.addListener("dragend", () => {
        const pos = marker.getPosition();
        actualizarCoordenadas(pos.lat(), pos.lng());
        obtenerPais({ lat: pos.lat(), lng: pos.lng() });
    });
}

function actualizarCoordenadas(lat, lng) {
    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;
}

function obtenerPais(posicion) {
    const boton = document.querySelector('button[type="submit"]');
    if (boton) boton.disabled = true;

    geocoder.geocode({ location: posicion }, (results, status) => {
        if (boton) boton.disabled = false;

        if (status === "OK" && results[0]) {
            for (const resultado of results) {
                for (const componente of resultado.address_components) {
                    if (componente.types.includes("country")) {
                        document.getElementById("pais").value = componente.long_name;
                        console.log("País actualizado:", componente.long_name);
                        return;
                    }
                }
            }
        }
    });
}

window.initMap = initMap;