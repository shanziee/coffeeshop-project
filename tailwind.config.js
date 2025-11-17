/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Poppins"', 'sans-serif'],
                display: ['"Playfair Display"', 'serif'],
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in-down': {
                    '0%': { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'scale-in': {
                    '0%': { opacity: '0', transform: 'scale(0.9)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'slide-in-left': {
                    '0%': { opacity: '0', transform: 'translateX(-20px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                'bounce-custom': {
                    '0%, 100%': { transform: 'translateY(-5%)' },
                    '50%': { transform: 'translateY(0)' },
                }
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.8s ease-out forwards',
                'fade-in-down': 'fade-in-down 0.8s ease-out forwards',
                'scale-in': 'scale-in 0.7s ease-out forwards',
                'slide-in-left': 'slide-in-left 0.7s ease-out forwards',
                'bounce-custom': 'bounce-custom 1.5s infinite ease-in-out',
            },
        },
    },
    plugins: [],
}
