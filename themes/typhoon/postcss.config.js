module.exports = {
  plugins: [
    require('postcss-import'),
    require('precss'),
    require('tailwindcss/nesting'),
    require('tailwindcss'),
    require('autoprefixer'),
  ],
}
