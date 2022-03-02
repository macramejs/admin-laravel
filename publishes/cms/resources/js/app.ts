import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Pages } from '@macramejs/admin-vue3';

createInertiaApp({
    resolve: name => Pages.auth[name] || require(`./Pages/${name}.vue`).default,
    setup({ el, app, props, plugin }) {
        createApp({
            setup() {},
            render: () => h(app, props),
        }).mount(el);
    },
});

InertiaProgress.init();
