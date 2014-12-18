module.exports = function(grunt) {
	grunt.registerTask('default', [
		'sass:development', 'autoprefixer', 'file-creator', 'requirejs', 'watch'
	]);
};