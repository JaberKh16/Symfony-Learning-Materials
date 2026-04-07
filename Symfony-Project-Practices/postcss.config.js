// module.exports = {
//     plugins: [
//         require('@tailwindcss/postcss')({ //  or require('tailwindcss') if you don't have @tailwindcss/postcss
//             // optional Tailwind config path
//             config: './tailwind.config.js'
//         }),
//         require('autoprefixer'),
//     ],
// };

module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
};