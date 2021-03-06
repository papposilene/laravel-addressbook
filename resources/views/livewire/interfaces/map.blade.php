<div id="cartography" class="flex flex-row {{ $classes }}" style="{{ $styles }}"></div>

<script>
document.addEventListener('livewire:load', function () {
    const leafletMap = L.map('cartography', {
        center: [{{ $address->address_lat }}, {{ $address->address_lon }}],
        zoom: {{ $zoom }},
        zoomControl: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(leafletMap);

    L.marker([{{ $address->address_lat }}, {{ $address->address_lon }}]).addTo(leafletMap);
})
</script>
