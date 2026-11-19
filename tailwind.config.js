import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f2f9f5',
                    100: '#e1f2e8',
                    200: '#c4e5d2',
                    300: '#97d2b2',
                    400: '#64b68d',
                    500: '#3e9a70',
                    600: '#2e7c57',
                    700: '#266347',
                    800: '#144d37', // Utama Waris.in
                    900: '#0f3a29', // Tombol utama / dark green
                    950: '#061d15',
                },
                mint: {
                    50: '#f6faf7',
                    100: '#ebf5ed',
                    200: '#d7ebd9',
                    300: '#b8dcbe',
                },
                mode: {
                    gratis: '#16a34a',
                    gratisBg: '#f0fdf4',
                    hargaPas: '#d97706',
                    hargaPasBg: '#fffbeb',
                    barter: '#0d9488',
                    barterBg: '#f0fdfa',
                }
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            }
        },
    },

    plugins: [forms],
};
