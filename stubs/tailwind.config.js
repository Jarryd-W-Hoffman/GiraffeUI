/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
	darkMode: "class",
	safelist: [
		{
			pattern: /bg-(blue|gray|green|red|teal|yellow|indigo|pink|orange|rose)-(100|200|300|400|500|600|700|800|900)/,
			variants: ['hover'],
		},
		{
			pattern: /(px|py)-(1|2|3|4|5|6|7|8|9|10)/,
		},
		{
			pattern: /text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl|8xl|9xl)/,
		},
		{
			pattern: /text-(gray|red|yellow|green|blue|indigo|purple|pink|white|black)-(100|200|300|400|500|600|700|800|900)/,
		},
		{
			pattern: /text-(white|black)/,
		},
		{
			pattern: /border-(gray|red|yellow|green|blue|indigo|purple|pink|white|black)-(100|200|300|400|500|600|700|800|900)/,
		},
	],
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
		"./vendor/jayaitch/giraffeui/src/Components/*.php",
		"./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php",
	],
	theme: {
		extend: {},
	},
	plugins: [],
}