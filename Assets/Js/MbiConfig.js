/**
 * this file gets created automatically from config.json on grunt build!
 * if you need to change values, edit ./Assets/Config/Config.json
 *
 * DO NOT EDIT THIS FILE!
 */

define([], function() {

var config = {
	"mediaQueries": {
		"palm": [
			"0px",
			"419px"
		],
		"lap": [
			"420px",
			"767px"
		],
		"portrait": [
			"768px",
			"1023px"
		],
		"landscape": [
			"1024px",
			"1199px"
		],
		"desk": [
			"1200px",
			"1439px"
		],
		"wide": [
			"1440px",
			"1919px"
		],
		"cinema": [
			"1920px",
			"9999px"
		]
	},
	"debug": true,
	"build": "2015-1-8 16-30",
	"version": 6
}
;
config.modules = { MbiConfig : true };
return config;

});

/* DO NOT EDIT THIS FILE */