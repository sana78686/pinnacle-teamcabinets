import defaultTheme from 'tailwindcss/defaultTheme';

/** Tailwind build for Modern storefront theme only */
export default {
    content: [
        './resources/views/themes/modern/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                md: {
                    ink: '#1a1a1a',
                    slate: '#2d3e50',
                    gold: '#b8956b',
                    cream: '#f4f4f4',
                    line: '#e5e7eb',
                },
            },
            fontFamily: {
                sans: ['"Helvetica Neue"', 'Helvetica', 'Arial', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                'md-page': '1280px',
            },
        },
    },
    plugins: [],
};
