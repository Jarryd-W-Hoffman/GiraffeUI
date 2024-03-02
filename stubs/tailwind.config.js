/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
