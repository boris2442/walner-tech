import '../css/app.css';

import { Inertia } from '@inertiajs/inertia';
import { createInertiaApp } from '@inertiajs/vue3';
//import { Link } from '@inertiajs/inertia-vue3'; // <-- important !
import { library } from '@fortawesome/fontawesome-svg-core';
import { faFacebook, faLinkedin, faTelegram, faTwitter, faWhatsapp } from '@fortawesome/free-brands-svg-icons';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
import { faCartShopping, faEnvelope, faMagnifyingGlass, faShareAlt } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Eye, ShoppingCartIcon } from 'lucide-vue-next';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

library.add(faWhatsapp, faFacebook, faTelegram, faTwitter, faLinkedin, faEnvelope);
// Ajout des icônes à la librairie
library.add(faCartShopping, faHeart, faMagnifyingGlass, faWhatsapp, faShareAlt);

import { initializeTheme } from './composables/useAppearance';
import NProgress from './plugins/nprogress'; // notre fichier
// Importez le plugin head que nous venons de créer
import { head } from './plugins/head';
const appName = import.meta.env.VITE_APP_NAME || 'Walner Tech';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('../js/pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('Eye', Eye)
            .component('ShoppingCartIcon', ShoppingCartIcon)
            //  .component('Link', Link)

            // ✅ On ajoute simplement notre plugin head
            .use(head)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

initializeTheme();

Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());
