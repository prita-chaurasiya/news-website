import { defineStore } from 'pinia';

export const useNewsStore = defineStore('news', {
  state: () => ({
    theme: typeof window !== 'undefined'
      ? (localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
      : 'light',
    locale: typeof window !== 'undefined'
      ? (localStorage.getItem('locale') || 'en')
      : 'en',
    // Article body font scale: starts at 100% (1.00), validated and capped between 90% (0.90) and 130% (1.30)
    fontSizeScale: typeof window !== 'undefined'
      ? (() => {
          const saved = parseFloat(localStorage.getItem('chronicle_font_scale'));
          return (!isNaN(saved) && saved >= 0.90 && saved <= 1.30) ? saved : 1.0;
        })()
      : 1.0,
    bookmarkedIds: typeof window !== 'undefined'
      ? JSON.parse(localStorage.getItem('chronicle_bookmarks') || '[]')
      : [],
    readArticlesCount: typeof window !== 'undefined'
      ? parseInt(localStorage.getItem('chronicle_read_count') || '0', 10)
      : 0,
    searchQuery: '',
    searchModalOpen: false,
    selectedWeatherCity: 'delhi',
  }),

  actions: {
    toggleTheme() {
      this.theme = this.theme === 'dark' ? 'light' : 'dark';
      if (typeof window !== 'undefined') {
        localStorage.setItem('theme', this.theme);
        if (this.theme === 'dark') {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      }
    },

    setLocale(newLocale) {
      this.locale = newLocale;
      if (typeof window !== 'undefined') {
        localStorage.setItem('locale', newLocale);
      }
    },

    setFontScale(scale) {
      const clamped = Math.min(1.30, Math.max(0.90, Math.round(scale * 100) / 100));
      this.fontSizeScale = clamped;
      if (typeof window !== 'undefined') {
        localStorage.setItem('chronicle_font_scale', clamped.toString());
      }
    },

    increaseFontSize() {
      const steps = [0.90, 1.00, 1.15, 1.30];
      const next = steps.find((s) => s > this.fontSizeScale + 0.01) ?? 1.30;
      this.setFontScale(next);
    },

    decreaseFontSize() {
      const steps = [0.90, 1.00, 1.15, 1.30];
      const prev = [...steps].reverse().find((s) => s < this.fontSizeScale - 0.01) ?? 0.90;
      this.setFontScale(prev);
    },

    resetFontSize() {
      this.setFontScale(1.00);
    },

    toggleBookmark(articleId) {
      const idx = this.bookmarkedIds.indexOf(articleId);
      if (idx > -1) {
        this.bookmarkedIds.splice(idx, 1);
      } else {
        this.bookmarkedIds.push(articleId);
      }
      if (typeof window !== 'undefined') {
        localStorage.setItem('chronicle_bookmarks', JSON.stringify(this.bookmarkedIds));
      }
    },

    isBookmarked(articleId) {
      return this.bookmarkedIds.includes(articleId);
    },

    recordArticleRead(articleId) {
      this.readArticlesCount++;
      if (typeof window !== 'undefined') {
        localStorage.setItem('chronicle_read_count', this.readArticlesCount.toString());
      }
    },

    resetReadingMeter() {
      this.readArticlesCount = 0;
      if (typeof window !== 'undefined') {
        localStorage.removeItem('chronicle_read_count');
      }
    },
  },
});
