<div id="cartography" class="flex flex-row pt-3 bg-red-500 {{ $classes }}" style="{{ $styles }}"></div>

<script>
document.addEventListener('livewire:load', function () {
    var leafletMap = L.map('cartography', {
        center: [{{ $address->address_lat }}, {{ $address->address_lon }}],
        zoom: 10,
        zoomControl: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(leafletMap);

    L.marker([{{ $address->address_lat }}, {{ $address->address_lon }}]).addTo(leafletMap);
})
</script>
