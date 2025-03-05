const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: "#2C3E50", // Azul oscuro elegante
                    light: "#34495E",
                    dark: "#1A252F",
                },
                secondary: {
                    DEFAULT: "#3498DB", // Azul vibrante
                    light: "#5DADE2",
                    dark: "#2980B9",
                },
                accent: {
                    DEFAULT: "#E74C3C", // Rojo vibrante
                    light: "#EC7063",
                    dark: "#C0392B",
                },
                success: {
                    DEFAULT: "#27AE60", // Verde esmeralda
                    light: "#2ECC71",
                    dark: "#219A52",
                },
                warning: {
                    DEFAULT: "#F1C40F", // Amarillo
                    light: "#F4D03F",
                    dark: "#D4AC0D",
                },
                info: {
                    DEFAULT: "#3498DB", // Azul claro
                    light: "#5DADE2",
                    dark: "#2980B9",
                },
                error: {
                    DEFAULT: "#E74C3C", // Rojo
                    light: "#EC7063",
                    dark: "#C0392B",
                },
            },
            boxShadow: {
                soft: "0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)",
                fancy: "0 0 50px 0 rgb(0 0 0 / 10%)",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
