module.exports = {
	sass: {
		files: ['<%= pkg.sourceScss %>**/*.scss', '<%= pkg.sourceScssBase %>**/*.scss'],
		tasks: ['sass:development', 'autoprefixer']
	},
	requirejs: {
		files: ['<%= pkg.sourceScript %>**/*.js', '<%= pkg.sourceScriptBase %>**/*.js'],
		tasks: ['requirejs']
	}
};