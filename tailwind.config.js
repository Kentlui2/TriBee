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
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                bee: {
                    orange: '#F97316',
                    dark:   '#1C1C1C',
                    muted:  '#6B7280',
                    light:  '#FFF7ED',
                    border: '#E5E7EB',
                }
            },
        },
    },

    plugins: [forms],
};