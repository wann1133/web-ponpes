import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                pondok: {
                    primary: '#2E7D32',
                    secondary: '#4CAF50',
                    accent: '#F8F9FA',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 15px 40px -15px rgba(46, 125, 50, 0.25)',
            },
        },
    },
    plugins: [forms, typography],
};
