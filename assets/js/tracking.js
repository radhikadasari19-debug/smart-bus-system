function initMap(){

    const busLocation = {
        lat: 19.0760,
        lng: 72.8777
    };

    const map = new google.maps.Map(
        document.getElementById("map"),
        {
            zoom: 14,
            center: busLocation,
        }
    );

    const marker = new google.maps.Marker({
        position: busLocation,
        map: map,
        title: "College Bus"
    });

}

window.onload = initMap;