let map;
let marker;
let geocoder;

async function initMap() {
    const ubicacionDefault = {lat: -34.6037, lng: -58.3816};

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12, center: ubicacionDefault,
    });
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({
        position: ubicacionDefault, map: map, draggable: true
    });
    actualizarCoordenadas(ubicacionDefault.lat, ubicacionDefault.lng);
    obtenerPais(ubicacionDefault); 

    map.addListener("click", (event) => {
        const nuevaPosicion = event.latLng;
        marker.setPosition(nuevaPosicion);
        actualizarCoordenadas(nuevaPosicion.lat(), nuevaPosicion.lng());
        obtenerPais(nuevaPosicion);

    });
    marker.addListener("dragend", () => {
        const posicionMarcador = marker.getPosition();
        actualizarCoordenadas(posicionMarcador.lat(), posicionMarcador.lng());
        obtenerPais(posicionMarcador); 

    });
}

function actualizarCoordenadas(lat, lng) {

    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;
}

function obtenerPais(posicion) {


    geocoder.geocode({
            location: posicion
        },

        (results, status) => {


            if (status === "OK") {


                for (let resultado of results) {


                    for (let componente of resultado.address_components) {


                        if (componente.types.includes("country")) {


                            document.getElementById("pais").value = componente.long_name;


                            console.log("Pais:", componente.long_name);


                            return;

                        }

                    }

                }

            } else {
                console.error("Geocoder fallo con status:", status);
            }

        });

}

window.initMap = initMap;