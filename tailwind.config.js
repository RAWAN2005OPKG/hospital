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
                sans: ['Cairo', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mediflow: {
                    50: '#f0f9ff',
                    100: '#e0f4ff',
                    200: '#b8e8f5',
                    300: '#7dd3ea',
                    400: '#38bdf8',
                    500: '#00B4D8',
                    600: '#0096c7',
                    700: '#0077B6',
                    800: '#023e8a',
                    900: '#03045e',
                    accent: '#08A09C',
                },
            },
            borderRadius: {
                '4xl': '2rem',
            },
            boxShadow: {
                'medical': '0 12px 40px -8px rgba(0, 119, 182, 0.18)',
                'medical-lg': '0 24px 60px -12px rgba(0, 119, 182, 0.22)',
            },
        },
    },

    plugins: [forms],
};
