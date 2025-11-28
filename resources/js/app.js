import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// for toast listeners
import { router } from '@inertiajs/vue3';
import { useToast } from './Composables/Toast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // return createApp({ render: () => h(App, props) })
        //     .use(plugin)
        //     .use(ZiggyVue)
        //     .mount(el);
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // Set up toast listeners after app is created
        const { success, error, warning, info } = useToast();

        // Listen to Inertia events globally
        router.on('success', (event) => {
            const { props } = event.detail.page;

            // Check for flash messages from Laravel
            if (props.flash?.status) {
                success('Success', props.flash.status);
            }
            if (props.flash?.success) {
                success('Success', props.flash.success);
            }
            if (props.flash?.error) {
                error('Error', props.flash.error);
            }
            if (props.flash?.warning) {
                warning('Warning', props.flash.warning);
            }
        });

        router.on('error', (errors) => {
            error('Request Failed', 'Something went wrong. Please try again.');
        });

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
