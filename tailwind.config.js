/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./resources/**/*.ts",
      "./resources/**/*.tsx",
      "./Modules/**/Resources/views/**/*.blade.php",
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
  ],
  };
  