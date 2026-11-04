/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        ink: 'var(--color-ink)',
        paper: 'var(--color-paper)',
        surface: 'var(--color-surface)',
        border: 'var(--color-border)',
        accent: {
          DEFAULT: 'var(--color-accent)',
          hover: 'var(--color-accent-hover)',
        },
        muted: 'var(--color-muted)',
        // Backward-compatible named colors
        brand: {
          red: '#C8102E',
          ink: '#0B0F19',
          surface: '#FAF8F5',
          border: '#E7E2DA',
          muted: '#5B6475',
          dark: '#0B0F19',
          cardDark: '#121826',
          borderDark: '#232B3B',
          gold: '#D4AF37',
        },
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'Cambria', '"Times New Roman"', 'serif'],
        headline: ['"Playfair Display"', 'Georgia', 'serif'],
        editorial: ['"Source Serif 4"', 'Georgia', 'Cambria', 'serif'],
        body: ['"Source Serif 4"', 'Georgia', 'serif'],
        sans: ['"Inter"', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'sans-serif'],
        ui: ['"Inter"', 'sans-serif'],
        hindi: ['"Noto Sans Devanagari"', '"Inter"', 'sans-serif'],
        'hindi-serif': ['"Noto Serif Devanagari"', '"Noto Sans Devanagari"', 'Georgia', 'serif'],
      },
      spacing: {
        '1': '4px',
        '2': '8px',
        '3': '12px',
        '4': '16px',
        '6': '24px',
        '8': '32px',
        '12': '48px',
        '16': '64px',
        '24': '96px',
      },
      maxWidth: {
        '8xl': '88rem',
      },
      boxShadow: {
        'editorial': '0 2px 10px rgba(11, 15, 25, 0.04), 0 1px 3px rgba(11, 15, 25, 0.02)',
        'editorial-hover': '0 12px 24px -6px rgba(11, 15, 25, 0.08), 0 4px 8px -2px rgba(11, 15, 25, 0.03)',
      },
    },
  },
  plugins: [],
};
