module.exports = {
    plugins: [
        require('@tailwindcss/postcss')({
            // optional Tailwind config path
            config: './tailwind.config.js'
        }),
        require('autoprefixer'),
    ],
};