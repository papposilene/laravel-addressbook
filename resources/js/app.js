require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all.js');

import Alpine from 'alpinejs';

/* FontAwesome */
//import '@fortawesome/fontawesome-free/js/fontawesome';
//import '@fortawesome/fontawesome-free/js/solid';
//import '@fortawesome/fontawesome-free/js/regular';
//import '@fortawesome/fontawesome-free/js/brands';

/* ChartJS */
import 'chart.js/dist/chart.js';

/* Leaflet */
import 'leaflet/dist/leaflet-src.js';
import 'leaflet-ajax/dist/leaflet.ajax.js';
import 'leaflet.awesome-markers/dist/leaflet.awesome-markers.js';

window.Alpine = Alpine;

Alpine.start();
