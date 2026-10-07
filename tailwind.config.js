/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './templates/**/*.php',
    './parts/**/*.php',
    './src/**/*.{ts,js}',
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#1a1a1a',
        'dark': '#0d0d0d',
        'light': '#f5f5f5',
        'gold': '#c9a66b',
        'brown': '#8b5a2b',
        'gray': {
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
        },
      },
      fontFamily: {
        'sans': ['Inter', 'system-ui', 'sans-serif'],
        'serif': ['Playfair Display', 'Georgia', 'serif'],
      },
    },
  },
  plugins: [],
};
