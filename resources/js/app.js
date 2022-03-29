require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all.js');

import Alpine from 'alpinejs';

/* FontAwesome */
//import '@fortawesome/fontawesome-free/js/fontawesome';
//import '@fortawesome/fontawesome-free/js/solid';
//import '@fortawesome/fontawesome-free/js/regular';
//import '@fortawesome/fontawesome-free/js/brands';

/* Apache ECharts */
import * as echarts from 'echarts/core';
import { BarChart, PieChart } from 'echarts/charts';
import {
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent
} from 'echarts/components';
import { LabelLayout, UniversalTransition } from 'echarts/features';
import { CanvasRenderer } from 'echarts/renderers';

echarts.use([
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent,
    BarChart,
    PieChart,
    LabelLayout,
    UniversalTransition,
    CanvasRenderer
]);

/* Leaflet */
import 'leaflet/dist/leaflet-src.js';
import 'leaflet.awesome-markers/dist/leaflet.awesome-markers.js';
import 'leaflet.locatecontrol/src/L.Control.Locate.js';
import 'leaflet-ajax/dist/leaflet.ajax.js';

window.Alpine = Alpine;
Alpine.start();

