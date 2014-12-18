# WpTemplate

## Local Setup

1. ```git clone <https://github.com/moodley/WpTemplate>```
2. ```cd WpTemplate```
3. ```git submodule update --init --recursive```
4. ```npm install``` (to install all grunt tasks)
5. ```(sudo) gem install sass``` (latest sass version, may alread be up to date)
6. ```(sudo) gem install sass-json-vars``` (to use shared media queries within sass, may already be up to date)

## Info

- use TABS for all files (tab size: 4, no spaces)

### File Structure & Naming

```js
/* project assets (js, css, images, static html templates, etc.) – also used by Wordpress theme */
./Assets/
	BuildJs/ /* built JS, do not change, only grunt build */
	Config/ /* Config.json */
	Css/ /* built CSS, only change if not using SASS */
	Favicons/ /* self explanatory */
	Images/ /* non-vector */
	Svg/ /* vector */
	Js/ /* source JS, edit here */
		Vendor/ /* third party plugins */
	Scss/ /* source SCSS, used to grunt build Css/ */
	Tasks/ /* if project needs different build options for grunt place them here (gets prefered if same name than in base) */

/* wordpress content (theme, plugins, uploads, etc.) */
./Content/
	themes/Default/ /* our theme, ex mbi-theme */
		Templates/ /* partials, also used by acf flex layout renderer */

/* base functions/assets, do not alter, only use/reference */
./Base/
	Js/ /* source JS to use within ./Assets/Js */
	Php/ /* classes + setup for wordpress */
	Scss/ /* base sass modules (mbiCSS) + styles for base plugins */
	Tasks/ /* grunt tasks */
	Templates/ /* template presets, if nothing isset in ./Content/themes/Default/ */

/* wordpress core, do not alter */
./Wordpress/
```

```js
/* NO */
file_name_hello.php
file_nameHello.js
file-name-hello.scss
file_name-hello.json
…

/* YES -> UpperCamelCase */
FileNameHello.php
FileNameHello.js
FileNameHello.scss
FileNameHello.json
…

/* EXCEPTIONS */
index.php
function.php

image.jpg // assets used within browser can/should be lowercase
vector.svg // assets used within browser can/should be lowercase
header.js // assets used within browser can/should be lowercase
footer.js // assets used within browser can/should be lowercase

```

### JS

#### Basics

```js
/* NO */
var some_variable_name = false,
	someVariable_name = false;

/* YES */
var someVariableName = true;
```

#### RequireJS

- common modules are prefixed with mbi e.g. ```MbiConfig```.
- project modules have no/different prefixes.

**Note: If a module is useful enough to be used in other projects, it will be considered to become part of MbiModule…**

```js
require([
	'jquery', // jquery needs this alias to work (isset within requirejs config)
	'project/MbiConfig', // this is the only MbiModule outside the Base because it gets generated on grunt build based on Config.json
	'base/MbiHelper', // base module
	'base/MbiMediaQuery', // base module
	'project/SomeProjectModule', // some project module which is accesible from outside (returns module)
	'project/AnotherProjectModule', // some project module without access from outside (no return)
], function(
	$,
	mbiConfig,
	_ // if underscore is an option, user mbiHelper instead of _
	mbiMq,
	someProjectModule // needed if accessible from outside
) {
	'use strict';

	var module = { // closure within module always called module

		someValue: true,
		someFunction: function() {

			return module.someValue; // within closure access value with module.someValue

		},
		init: function() {

			module.someFunction();

		}

	};

	module.init(); // often there is a function to call on init before making available to "public" by return module;

	return module; // make public

});
```

### PHP

```php
/* NO */
$some_variable_name = false;
function some_function() {}

/* YES */
$someVariableName = true;
function someFunction() {}
```

### (S)CSS

#### BEM Example

```css
.module {}
.module--variation {}
	.module__head {}
	.module__body {}
		.module__overlay {}

.title {}
.menu {}
.text {}
```

```html
<div class="module module--variation">
	<div class="module__head">

		<div class="title"></div>

	</div>
	<div class="module__body">

		<div class="text">XYZ</div>
		<ul class="menu">
			<li>A</li>
			<li>B</li>
			<li>C</li>
		</ul>

		<div class="module__overlay">
			<div class="text">123</div>
		</div>

	</div>
</div>
```

#### How (Not) To BEM

```css
/* NO */
.class--with--more--words {}

/* YES */
.classWithMoreWords {}
```

```css
/* NO */
.some--element--name__child__kid {}

/* YES 1 */
.someElementName {} /* parent/module */
	.someElementName__kid {}/* child gets omitted because we don't nest more than one level down */

/* YES 2 */
.someElementName {} /* module A */
.child {} /* module B */
	.child__kid {} /* child is another module and kid is one of its child */
```

```css
/* NO */
.class_name {}

/* YES */
.className {}
```

```html
<!-- NO -->
<div class="module--modifier">
	<div class="module--modifier--something"></div>
</div>

<!-- YES 1 -->
<div class="module module--modifier">
	<div class="something"></div>
</div>
<!-- YES 2 -->
<div class="module module--modifier">
	<div class="module__something"></div>
</div>
```

```html
<!-- NO -->
<div class="element">
	<div class="element__thing">
		<div class="element__thing__foo">
			<div class="element__thing__foo__bla"></div>
		</div>
	</div>
</div>

<!-- YES 1 -->
<div class="element">
	<div class="element__thing">
		<div class="element__foo">
			<div class="element__bla"></div>
		</div>
	</div>
</div>
<!-- YES 2 -->
<div class="element">
	<div class="element__thing">
		<div class="element__foo">
			<div class="bla"></div><!-- maybe .bla is not ONLY a part of .element but also used in other modules (therefore its own "module") -->
		</div>
	</div>
</div>
```

#### A Good Example…

- List ```@extend(s)``` first
- List regular styles next
- List ```@include(s)``` next
- Combined selectors afterwards
- Nested selectors last
- Maximum nesting: 2-3 levels max.
- Visualize nesting by indenting
- Variablize all colors

```css
.module {

	/* extend first */
	@extend %someClass;
	@extend %anotherClass;

	/* regular styles, group them if possible */
	display: block;

	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);

	/* includes last */
	@include mq("desk+") {
		font-size: 1.1em;
	}

	/* combined selectors */
	&.is_active {
		color: red;
	}

	/* nested elements, indented to show nesting level without polluting selector */
	.module__element {
		width: 100%;
	}
		.module__something {
			color: yellow;
			@include mq("desk+") {
				color: red; /* do not nest styles within mediaqueries but place them within classes, if possible */
			}
		}

}
```

### HTML

#### Basic Structure (Proposal)

```html
<html>
	<head></head>
	<body>

		<div class="navigation">
			<!-- if sticky nav etc. -->
		</div>
		<div class="site">
			<!-- content goes here -->
		</div>

	</body>
</html>
```

#### JS HANDLER

- hook actions only to classes with ```js_``` prefix!
- use data-attributes according to camelCase scheme

```html
<div class="button js_doSomething" data-somethingValue="hello">click</div>
```

```js
/* YES */
$(document).on('click', '.js_doSomething', function() {

	var somethingValue = $(this).attr('data-somethingValue');
	console.log(somethingValue);

});

/* NO */
$('.button').click(function() {
	// bad…
});
```
