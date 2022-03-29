@section('title', @ucfirst(__('app.map')))

<div>
    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="icons" class="fas fa-icons fa-fw"></i>
        <i data-fa-symbol="create" class="fas fa-plus fa-fw text-green-500"></i>
        <i data-fa-symbol="delete" class="fas fa-trash fa-fw text-red-500"></i>
        <i data-fa-symbol="edit" class="fas fa-pencil fa-fw text-blue-500"></i>
        <i data-fa-symbol="favorite" class="fas fa-star fa-fw text-yellow-500"></i>
        <i data-fa-symbol="show" class="fas fa-ellipsis fa-fw text-green-500"></i>

        <div class="flex flex-col w-full">
            <div id="leaflet-addresses-map" class="bg-red-200 w-full h-screen" wire:ignore></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {

        const leafletMap = L.map('leaflet-addresses-map', {
            center: [0, 0],
            zoom: 4,
            zoomControl: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);

        L.control.locate({
            'enableHighAccuracy': true,
            'flyTo': true,
            strings: {
                title: "Show me where I am, yo!"
            }
        }).addTo(leafletMap);
        L.marker([0, 0]).addTo(leafletMap);
    })
</script>
