import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    // Aktifkan dark mode menggunakan class (sesuai kode landing page Anda)
    darkMode: 'class', 

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Set Instrument Sans sebagai font utama, fallback ke font default
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Definisi warna 'primary' (Saya gunakan Indigo/Blue-ish)
                primary: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5', // Warna utama tombol/teks
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                // Definisi warna 'secondary' (Saya gunakan Purple/Fuchsia)
                secondary: {
                    50: '#fdf4ff',
                    100: '#fae8ff',
                    200: '#f5d0fe',
                    300: '#f0abfc',
                    400: '#e879f9',
                    500: '#d946ef',
                    600: '#c026d3',
                    700: '#a21caf',
                    800: '#86198f',
                    900: '#701a75',
                    950: '#4a044e',
                },
                // Pastikan warna 'neutral' menggunakan palet gray atau slate bawaan
                neutral: colors.gray, 
            },
        },
    },

    plugins: [forms],
};