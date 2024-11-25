import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import 'vuetify/styles';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
// Vuetify
import Aura from '@primevue/themes/aura';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: (name) =>
		resolvePageComponent(
			`./Pages/${name}.vue`,
			import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
		),
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.use(PrimeVue, {
				theme: {
					preset: Aura,
					options: {
						darkModeSelector: '.my-app-dark',
					},
				},
			})
			.use(ToastService)
			.mount(el);
	},
	progress: {
		color: '#4B5563',
	},
});