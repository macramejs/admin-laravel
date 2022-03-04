module.exports = {
    presets: [require('@macramejs/admin-config')],
    content: [
        './resources/{{ name }}/**/*.vue',
        './node_modules/@macramejs/**/*.vue',
        './node_modules/@macramejs/**/*.js',
    ],
};
