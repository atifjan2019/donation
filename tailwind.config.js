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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#fef3f2',
                    100: '#fde6e3',
                    200: '#fbd0cc',
                    300: '#f7ada6',
                    400: '#f07c72',
                    500: '#e65a4f',
                    600: '#d23d31',
                    700: '#b02f24',
                    800: '#922a22',
                    900: '#792823',
                    950: '#41110e',
                },
                accent: {
                    50:  '#effefb',
                    100: '#c8fff4',
                    200: '#91feea',
                    300: '#53f5dd',
                    400: '#20e0ca',
                    500: '#08c4b1',
                    600: '#039e91',
                    700: '#087e75',
                    800: '#0c645e',
                    900: '#0f534e',
                    950: '#013331',
                },
            },
        },
    },

    plugins: [forms],
};
