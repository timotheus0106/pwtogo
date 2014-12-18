module.exports = {
	options: {
		src: './Assets/Config/Config.json',
		indent: '\t'
	},
	config: {
		dest: './Assets/Config/Config.json',
		fields: {
			version: function(src){
				return parseInt(src.version)+1;
			},
			build: function(src){

				var date = new Date(),
					current = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + ' ' + date.getHours() + '-' + date.getMinutes();

				return current;

			}
		}
	},
};