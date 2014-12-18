module.exports = {
	header: {
		options: {
			"name": "Assets/Js/header.source",
			"out": "Assets/BuildJs/header.js",
			"optimize": "none",
			"paths": {
				"base": "Base/Js/",
				"project": "Assets/Js/",
				"jquery": "Base/Js/Vendor/JQuery"
			}
		}
	},
	footer: {
		options: {
			"name": "Assets/Js/footer.source",
			"out": "Assets/BuildJs/footer.js",
			"optimize": "none",
			"paths": {
				"base": "Base/Js/",
				"project": "Assets/Js/",
				"jquery": "Base/Js/Vendor/JQuery"
			}
		}
	}
};