document.addEventListener('DOMContentLoaded', () => {
    // Default Lat/LNG & Map instanciation
    const
        DefaultLat = 47.865408,
        DefaultLng = 1.897564999999986,
        MapContainer = document.getElementById('home-map'),
        Map = L.map(MapContainer).setView([DefaultLat, DefaultLng], 11);

    // Bind tiles from mapbox
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: MapContainer.getAttribute('data-access-token') || alert('You\'re MAP_ACCESS_TOKEN is missing.') || null
    }).addTo(Map);

    // Our markers
    let points = JSON.parse(Map._container.getAttribute('data-json'));
    for (let point of points) {
        point.marker = L
            .marker([point.lat, point.lng])
            .bindPopup(`<p><b>${point.name}</b><br/>${point.infos}<br/><a href="#">${point.address}</a></p>`)
            .addTo(Map);
    
        // Bind tab to markers
        $(document).on('click', `[href='#${point.id}'][data-toggle="tab"]`, () => {
            point.marker.openPopup();
            Map.panTo(point.marker.getLatLng());
        })
    }
    $('#schedulesTabs li.active a').trigger('click');
})