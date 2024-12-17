import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// @ts-ignore
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import type {DefineComponent} from "vue";
import Vue3Toastify, {type ToastContainerOptions} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
         import.meta.glob<DefineComponent>("./Pages/**/*.vue")
    ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, (window as any).Ziggy)
             .use(
                Vue3Toastify,
                {
                    autoClose: 3000,
                    // ...
                } as ToastContainerOptions,
            )
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
