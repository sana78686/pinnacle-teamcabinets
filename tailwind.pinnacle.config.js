import defaultTheme from 'tailwindcss/defaultTheme';

/** Tailwind config scoped to Pinnacle marketing only (tenants use Bootstrap). */
export default {
    content: ['./resources/views/pinnacle/**/*.blade.php'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
