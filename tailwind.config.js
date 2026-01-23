import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                maroon: {
                    50: '#fdf2f2',
                    100: '#fce8e8',
                    200: '#f9d5d5',
                    300: '#f2b2b2',
                    400: '#e88080',
                    500: '#dc2626',
                    600: '#c53030', // Standard maroon
                    700: '#991b1b', // Dark maroon
                    800: '#7f1d1d', // Very dark maroon
                    900: '#63171b',
                },
            },
        },
    },

    plugins: [forms],
};
