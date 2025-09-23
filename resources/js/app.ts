import '../css/app.css';

import { createInertiaApp,Link } from '@inertiajs/vue3';
import NProgress from './plugins/nprogress'; // notre fichier
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

import { initializeTheme } from './composables/useAppearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            // .component('Link', Link) // très important ⚡
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


initializeTheme();
import { Inertia } from '@inertiajs/inertia';

Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());
