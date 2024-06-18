/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{js,jsx,ts,tsx}'],
  theme: {
    container: {
      screens: {
        sm: '600px',
        md: '728px',
        lg: '984px',
        xl: '1240px',
        '2xl': '1240px'
      }
    },
    colors: {
      transparent: 'transparent',
      primary: '#3c765f',
      yellow: '#fadd00',
      red: '#ce2b37',
      current: 'currentColor',
      black: '#000000',
      white: '#ffffff',
      purple: '#3f3cbb',
      midnight: '#121063',
      metal: '#565584',
      tahiti: '#3ab7bf',
      silver: '#ecebff',
      'bubble-gum': '#ff77e9',
      bermuda: '#78dcca'
    },
    extend: {}
  },
  plugins: []
}
