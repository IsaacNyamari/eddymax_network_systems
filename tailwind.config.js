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
                    50: 'var(--maroon-50)',
                    100: 'var(--maroon-100)',
                    200: 'var(--maroon-200)',
                    300: 'var(--maroon-300)',
                    400: 'var(--maroon-400)',
                    500: 'var(--maroon-500)',
                    600: 'var(--maroon-600)',
                    700: 'var(--maroon-700)',
                    800: 'var(--maroon-800)',
                    900: 'var(--maroon-900)',
                    950: 'var(--maroon-950)',
                },
            },
        },
    },

    plugins: [forms],
};
