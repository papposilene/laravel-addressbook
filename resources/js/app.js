require('./bootstrap');

import Alpine from 'alpinejs';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'

/* TailwindCSS */
//import resolveConfig from 'tailwindcss/resolveConfig';
//import tailwindConfig from '../../tailwind.config.js';
//const tailwind = resolveConfig(tailwindConfig);

/* FontAwesome */
//require('@fortawesome/fontawesome-free/js/all.js');
import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

/* ChartJS */
import 'chart.js/dist/chart.js';

/* Leaflet */
import 'leaflet/dist/leaflet-src.js';
import 'leaflet.awesome-markers/dist/leaflet.awesome-markers.js';
import 'leaflet.locatecontrol/src/L.Control.Locate.js';
import 'leaflet-ajax/dist/leaflet.ajax.js';
import 'leaflet-geosearch/dist/bundle.min.js';
import 'sidebar-v2/js/leaflet-sidebar.js';

Alpine.plugin(FormsAlpinePlugin)
window.Alpine = Alpine;
Alpine.start();
