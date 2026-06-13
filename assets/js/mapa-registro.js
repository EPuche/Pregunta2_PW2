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

    const geocoder = new google.maps.Geocoder();

    geocoder.geocode(
        {
            location: {
                lat: lat,
                lng: lng
            }
        },
        (results, status) => {

            console.log("STATUS:", status);
            console.log("RESULTS:", results);

            if (status === "OK" && results[0]) {

                let pais = "";
                let ciudad = "";

                results[0].address_components.forEach(componente => {

                    console.log(componente);

                    if (componente.types.includes("country")) {
                        pais = componente.long_name;
                    }

                    if (
                        componente.types.includes("locality") ||
                        componente.types.includes("administrative_area_level_1") ||
                        componente.types.includes("administrative_area_level_2") ||
                        componente.types.includes("administrative_area_level_3")
                    ) {
                        ciudad = componente.long_name;
                    }
                });

                document.getElementById("pais").value = pais;
                document.getElementById("ciudad").value = ciudad;

                console.log("PAIS:", pais);
                console.log("CIUDAD:", ciudad);
                
            }
        }
    );
}
