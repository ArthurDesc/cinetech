import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors')

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
                primary: colors.orange,
                secondary: colors.gray,
                dark: {
                    DEFAULT: '#0a0a0a',
                    light: '#121212',
                    lighter: '#1a1a1a',
                }
            },
            backgroundImage: {
                'gradient-dark': 'linear-gradient(to top, rgb(234 88 12) 0%, rgb(10 10 10) 50%)',
                'gradient-dark-subtle': 'linear-gradient(to top, rgb(234 88 12) 0%, rgb(10 10 10) 75%)',
                'gradient-dark-strong': 'linear-gradient(to top, rgb(234 88 12) 0%, rgb(10 10 10) 25%)',
            }
        },
    },

    plugins: [forms],
};
