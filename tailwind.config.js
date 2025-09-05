import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    plugins: [require("@tailwindcss/forms")],
};
