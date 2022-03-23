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
import 'leaflet.locatecontrol/dist/L.Control.Locate.min.js';

// Orejime
import 'orejime/dist/orejime.js';

window.Alpine = Alpine;

Alpine.start();

var orejimeConfig = {
    elementID: "addressbook-orejime",
    appElement: "#addressbook",
    cookieName: "addressbook-orejime",
    cookieDomain: 'map.psln.nl',
    privacyPolicy: "./privacy-policy",
    lang: "fr",
    logo: false,
    debug: false,
    translations: {
        en: {
            purposes: {
                analytics: "Analytics",
                security: "Security"
            },
            categories: {
                analytics: {
                    description: "The analysis, measurements and statistics web tools, which constitute the web analytics, make it possible to understand and optimize usages of this website."
                }
            }
        },
        fr: {
            purposes: {
                analytics: "Analyses, mesures et statistiques web",
                security: "Sécurité"
            },
            categories: {
                analytics: {
                    description: "Les outils d'analyses, de mesures et de statistiques web, qui constituent les métriques du web, permettent de comprendre et d’optimiser les usages de ce site internet."
                }
            }
        },
    },
    apps: [
        {
            name: "matomo",
            title: "Matomo Analytics",
            cookies: [
                "_pk_ref",
                "_pk_cvar",
                "_pk_id",
                "_pk_ses",
                "mtm_consent",
                "mtm_consent_removed",
                "mtm_cookie_consent",
                "matomo_ignore",
                "matomo_sessid",
                "_pk_hsr",
            ],
            purposes: ["analytics"],
        }
    ],
    categories: [
        {
            name: "analytics",
            title: "Analytics",
            apps: [
                "matomo",
            ]
        }
    ]
}

var Orejime = require('orejime');
Orejime.init(orejimeConfig);
