import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import { i18n } from './i18n';

const appName = import.meta.env.VITE_APP_NAME || 'THE CHRONICLE';

createInertiaApp({
  title: (title) => (title ? `${title} — ${appName}` : appName),
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const pinia = createPinia();

    const vueApp = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(i18n);

    // Synchronize initial locale with Inertia shared prop
    if (props.initialPage?.props?.locale) {
      i18n.global.locale.value = props.initialPage.props.locale;
    }

    vueApp.mount(el);
  },
  progress: {
    color: '#C8102E',
    showSpinner: false,
  },
});
