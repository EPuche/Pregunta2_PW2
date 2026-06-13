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

   

    map.addListener("click", function(event) {
        marker.setPosition(event.latLng);
        document.getElementById("latitud").value = event.latLng.lat();
        document.getElementById("longitud").value = event.latLng.lng();
  
    });

    marker.addListener("dragend", () => {
        const pos = marker.getPosition();
        document.getElementById("latitud").value = pos.lat();
        document.getElementById("longitud").value = pos.lng();
      
    });
}


window.initMap = initMap;
