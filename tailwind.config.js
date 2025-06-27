
module.exports = {
  prefix: 'tw-',  // Prefix for Tailwind CSS classes
  content: [
    './app/**/*.php',  // Laravel application files
    './resources/**/*.php', // Laravel view
    './views/**/*.php',  // CodeIgniter 4 view
    './public/**/*.js', // JavaScript files in public directory
    './app/Views/**/*.php'
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
