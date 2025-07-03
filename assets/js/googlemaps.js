// assets/js/googleMaps.js


let mapLoaded = false;
let mapInstance = null;


function initMap() {
    const container = document.getElementById("map-container");


    mapInstance = new google.maps.Map(container, {
        zoom: 9,
        center: { lat: 47.237829, lng: 6.024053 }
    });


    const markersData = [
        { lat: 47.237017, lng: 6.025148, title: "Hellfest, Besançon", info: "Hellfest, Besançon" },
        { lat: 47.640483, lng: 6.150057, title: "Geek Legends, Vesoul", info: "Geek Legends, Vesoul" },
        { lat: 47.636606, lng: 6.143299, title: "Geek Mania, Vesoul", info: "Geek Mania, Vesoul" },
        { lat: 47.479360, lng: 6.837784, title: "Rencontres et Racines, Audincourt", info: "Rencontres et Racines, Audincourt" },
        { lat: 47.222271, lng: 5.979674, title: "Besançon Tattoo Show, Besançon", info: "Besançon Tattoo Show, Besançon" },
    ];


    const infoWindow = new google.maps.InfoWindow();


    markersData.forEach((point) => {
        const marker = new google.maps.Marker({
            position: { lat: point.lat, lng: point.lng },
            map: mapInstance,
            title: point.title
        });


        marker.addListener("click", () => {
            infoWindow.setContent(`
                <div style="min-width:200px;">
                    <h4>${point.title}</h4>
                    <p>${point.info}</p>
                </div>
            `);
            infoWindow.open(mapInstance, marker);
        });
    });
}


document.addEventListener("DOMContentLoaded", function () {
    const mapLink = document.querySelector(".apimap");
    const container = document.getElementById("map-container");


    container.style.display = "none";


    mapLink.addEventListener("click", function (e) {
        e.preventDefault();


        if (container.style.display === "none") {
            container.style.display = "block";
            container.style.width = "95vw";


            if (!mapLoaded) {
                if (typeof google === 'object' && typeof google.maps === 'object') {
                    initMap();
                    mapLoaded = true;
                } else {
                    console.error("Google Maps n'est pas encore chargé.");
                }
            }
        } else {
            container.style.display = "none";
        }
    });


    // Charge le script Google Maps dynamiquement
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCYUZc3-xtvehj3Vk6_qvZe5SFnCR1G7QQ&callback=initMap';
    script.async = true;
    script.defer = true;
    window.initMap = initMap; // Rendre initMap globale pour le callback
    document.head.appendChild(script);
});





