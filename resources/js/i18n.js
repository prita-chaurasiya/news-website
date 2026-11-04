import { createI18n } from 'vue-i18n';
import en from './locales/en.json';
import hi from './locales/hi.json';

const initialLocale = typeof window !== 'undefined'
  ? (localStorage.getItem('locale') || (document.documentElement.lang === 'hi' ? 'hi' : 'en'))
  : 'en';

export const i18n = createI18n({
  legacy: false,
  locale: initialLocale,
  fallbackLocale: 'en',
  messages: {
    en,
    hi,
  },
});
