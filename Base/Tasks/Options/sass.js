module.exports = {
	development: {
		options: {
			style: 'expanded',
			cacheLocation: '<%= pkg.sourceScss %>.sass-cache/',
			require: 'sass-json-vars'
		},
		files: {
			'<%= pkg.destinationCss %>Style.css': '<%= pkg.sourceScss %>Style.scss'
		}
	},
	production: {
		options: {
			style: 'compressed',
			cacheLocation: '<%= pkg.sourceScss %>.sass-cache/',
			require: 'sass-json-vars'
		},
		files: {
			'<%= pkg.destinationCss %>Style.css': '<%= pkg.sourceScss %>Style.scss'
		}
	}
};