let map;
let marker;

function initMap() {
    let lat = parseFloat(document.getElementById("latitud").value);
    let lng = parseFloat(document.getElementById("longitud").value);

    if (isNaN(lat) || isNaN(lng)) {
        lat = -34.6037; 
        lng = -58.3816;
    }

    const posicion = { lat, lng };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: posicion
    });

    marker = new google.maps.Marker({
        position: posicion,
        map: map,
        draggable: true
    });

    // inicializa país/ciudad
    actualizarCoordenadas(posicion.lat, posicion.lng);

    map.addListener("click", function(event) {
        marker.setPosition(event.latLng);
        document.getElementById("latitud").value = event.latLng.lat();
        document.getElementById("longitud").value = event.latLng.lng();
        actualizarCoordenadas(event.latLng.lat(), event.latLng.lng());
    });

    marker.addListener("dragend", () => {
        const pos = marker.getPosition();
        document.getElementById("latitud").value = pos.lat();
        document.getElementById("longitud").value = pos.lng();
        actualizarCoordenadas(pos.lat(), pos.lng());
    });
}

function actualizarCoordenadas(lat, lng) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: { lat, lng } }, (results, status) => {
        if (status === "OK" && results[0]) {
            let pais = "";
            let ciudad = "";
            results[0].address_components.forEach(c => {
                if (c.types.includes("country")) pais = c.long_name;
                if (c.types.includes("locality") || c.types.includes("administrative_area_level_1")) ciudad = c.long_name;
            });
            document.getElementById("pais").value = pais;
            document.getElementById("ciudad").value = ciudad;
        } else {
            console.error("Geocoder falló:", status);
        }
    });
}

window.initMap = initMap;
