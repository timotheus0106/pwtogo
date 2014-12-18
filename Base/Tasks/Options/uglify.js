module.exports = {
	target: {
		files: [{
			expand: true,
			cwd: '<%= pkg.destinationJs %>',
			src: '*.js',
			dest: '<%= pkg.destinationJs %>'
		}]
	}
};