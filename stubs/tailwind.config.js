/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
    darkMode: "class",
    safelist: [
        {
            pattern: /bg-(blue|gray|green|red|teal|yellow|indigo|pink|orange|rose)-(100|200|300|400|500|600|700|800|900)/,
            variants: ['hover'],
        }
    ],
    content: [
        "./resources/**/*.blade.php",
        "./vendor/jayaitch/giraffeui/src/Components/*.php",
        "./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
