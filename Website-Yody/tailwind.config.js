/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        'old-standard': ['Old Standard TT', 'serif'],
        'plus-jakara':['Plus Jakarta Sans','san-serif'],
      },
    },
  },
  plugins: [],
}