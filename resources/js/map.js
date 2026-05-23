// Tunggu sampai DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById('map');

    if (mapElement) {
        // 1. Ambil data dari atribut HTML
        const lat = mapElement.getAttribute('data-lat');
        const lng = mapElement.getAttribute('data-lng');
        const name = mapElement.getAttribute('data-name');
        const address = mapElement.getAttribute('data-address');

        // 2. Validasi apakah koordinat tersedia
        if (lat && lng) {
            // Inisialisasi peta menggunakan data dari database
            var map = L.map('map').setView([lat, lng], 16);

            // Gunakan tiles dari OpenStreetMap
            L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps'
            }).addTo(map);

            // Tambahkan Marker dan Popup
            L.marker([lat, lng]).addTo(map)
                .bindPopup(`
                    <div style="min-width: 150px;">
                        <strong style="font-size: 14px; color: #1e293b; display: block;">${name}</strong>
                        <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">${address}</span>
                    </div>
                `)
                .openPopup();
        } else {
            // Tampilan jika data koordinat kosong
            mapElement.innerHTML = `
                <div class="flex items-center justify-center h-full bg-slate-50 text-slate-400 text-sm">
                    Koordinat peta belum ditentukan untuk cafe ini.
                </div>
            `;
        }
    }
});
