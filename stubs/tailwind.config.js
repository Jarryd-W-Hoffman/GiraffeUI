import defaultTheme, { colors } from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
	darkMode: "class",
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
		"./vendor/jayaitch/giraffeui/src/Components/*.php",
		"./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php",
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
			},
			colors: {
				transparent: 'transparent',
				current: 'currentColor',
				black: colors.black,
				white: colors.white,
				primary: '#1D4ED8',
				secondary: '#9333EA',
				success: '#10B981',
				danger: '#EF4444',
				warning: '#F59E0B',
				info: '#3B82F6',
				light: '#F3F4F6',
				dark: '#111827'
			},
			padding: {
				small: '0.125rem',
				default: '0.25rem',
				large: '0.5rem',
			},
		},
	},
	plugins: [
		require('@tailwindcss/forms'),
		require('@tailwindcss/typography'),
		require('@tailwindcss/aspect-ratio'),
	],
}
