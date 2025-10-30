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
            // **الألوان الآن معرفة بشكل صحيح في extend**
            colors: {
                'primary-blue': '#1e40af',     
                'light-blue': '#3b82f6',       
                'background-white': '#ffffff', 
                'sidebar-dark': '#0f172a',     
            },
        },
    },


    // **تضمين forms و tailwindcss-rtl في plugins**
    plugins: [
        forms,
        require('tailwindcss-rtl'), // **تم إضافة هذا السطر لحل مشكلة RTL وخطأ Vite**
    ], 
};