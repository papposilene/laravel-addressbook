require('./bootstrap');

import Alpine from 'alpinejs';

/* FontAwesome */
require('@fortawesome/fontawesome-free/js/all.js');
//import '@fortawesome/fontawesome-free/js/fontawesome';
//import '@fortawesome/fontawesome-free/js/solid';
//import '@fortawesome/fontawesome-free/js/regular';
//import '@fortawesome/fontawesome-free/js/brands';

/* ChartJS */
//import Chart from 'chart.js/auto';

/* Apache ECharts */
import * as echarts from 'echarts/dist/echarts.js';
import {
    BarChart,
    LineChart,
    PieChart,
} from 'echarts/charts.js';
import {
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent
} from 'echarts/components.js';
import { LabelLayout, UniversalTransition } from 'echarts/features.js';
import { SVGRenderer } from 'echarts/renderers.js';

echarts.use([
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent,
    BarChart,
    LineChart,
    PieChart,
    LabelLayout,
    UniversalTransition,
    SVGRenderer
]);

/* Leaflet */
import 'leaflet/dist/leaflet-src.js';
import 'leaflet.awesome-markers/dist/leaflet.awesome-markers.js';
import 'leaflet.locatecontrol/src/L.Control.Locate.js';
import 'leaflet-ajax/dist/leaflet.ajax.js';

window.Alpine = Alpine;
Alpine.start();
