let map;
let marker;
let geocoder;


function initMap() {

    let lat = parseFloat(document.getElementById("latitud").value);
    let lng = parseFloat(document.getElementById("longitud").value);


    if (isNaN(lat) || isNaN(lng)) {

        lat = -34.6037;
        lng = -58.3816;

    }

    const posicion = {
        lat: lat,
        lng: lng
    };


    map = new google.maps.Map(
        document.getElementById("map"),
        {
            zoom: 15,
            center: posicion
        }
    );

    geocoder = new google.maps.Geocoder();


    marker = new google.maps.Marker({

        position: posicion,
        map: map,
        draggable: true

    });

    obtenerPais(posicion);

    map.addListener("click", function (event) {


        marker.setPosition(event.latLng);


        actualizarCoordenadas(
            event.latLng.lat(),
            event.latLng.lng()
        );


        obtenerPais(event.latLng);


    });


    marker.addListener("dragend", () => {


        const pos = marker.getPosition();


        actualizarCoordenadas(
            pos.lat(),
            pos.lng()
        );


        obtenerPais(pos);


    });

}


function actualizarCoordenadas(lat, lng) {

    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;

}


function obtenerPais(posicion) {


    geocoder.geocode(
        {
            location: posicion
        },

        (results, status) => {


            if (status === "OK") {


                for (const resultado of results) {


                    for (const componente of resultado.address_components) {


                        if (componente.types.includes("country")) {


                            document.getElementById("pais").value =
                                componente.long_name;


                            console.log(
                                "País actualizado:",
                                componente.long_name
                            );


                            return;

                        }

                    }

                }

            }


        }
    );

}


window.initMap = initMap;