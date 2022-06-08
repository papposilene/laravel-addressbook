require('./bootstrap');

import Alpine from 'alpinejs';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'

/* FontAwesome */
import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

/* ChartJS */
import 'chart.js/dist/chart.js';

/* Leaflet */
import 'leaflet/dist/leaflet-src.js';
import 'leaflet-ajax/dist/leaflet.ajax.js';
import 'leaflet-fa-markers/L.Icon.FontAwesome.js';
import 'leaflet-control-geocoder/dist/Control.Geocoder.js';
import 'leaflet.locatecontrol/src/L.Control.Locate.js';
import 'sidebar-v2/js/leaflet-sidebar.js';

Alpine.plugin(FormsAlpinePlugin)
window.Alpine = Alpine;
window._paq = [];
Alpine.start();


