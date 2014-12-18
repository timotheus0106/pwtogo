module.exports = {
	production: {
		// options: {
		// 	banner: '/* MINIFIED BY GHOSTS */'
		// },
		files: {
			'<%= pkg.destinationCss %>Style.css': '<%= pkg.destinationCss %>Style.css'
		}
	}
};