module.exports = {
	options: {
		browsers: ['> 0.01%'],
		map: {
			prev: '<%= pkg.destinationCss %>Style.map.css'
		}
	},
	prefix: {
		src: '<%= pkg.destinationCss %>Style.css',
		dest: '<%= pkg.destinationCss %>Style.css'
	}
};