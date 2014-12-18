module.exports = function(grunt) {
	grunt.registerTask('build', [
		'update_json', 'sass:production', 'autoprefixer', 'cmq', 'cssmin',
		'file-creator', 'requirejs', 'uglify'
	]);
};