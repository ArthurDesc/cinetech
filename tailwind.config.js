import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    'bg': '#121212',
                    'surface': '#1E1E1E',
                    'primary': '#121212',
                    'secondary': '#1E1E1E'
                },
                'background': '#121212',
                'surface': '#1E1E1E',
                'text': '#FFFFFF'
            }
        },
    },

    plugins: [forms],
};
