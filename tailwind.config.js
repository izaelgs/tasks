import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            transitionProperty: {
                'height': 'height',
            },
            animation: {
                'time-progress': 'widthAnimation 5s linear infinite',
            },
            keyframes: {
                widthAnimation: {
                    '0%': { width: '100%' },
                    '100%': { width: '0%' },
                }
            }
        },
    },

    plugins: [forms, typography],
};
