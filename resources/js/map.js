var map = L.map('map').setView([-7.9362141, 112.6249031], 15);

// Menggunakan tiles dari OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Menambahkan Marker
L.marker([-7.9362141, 112.6249031]).addTo(map)
    .bindPopup('The Amber Roastery')
    .openPopup();