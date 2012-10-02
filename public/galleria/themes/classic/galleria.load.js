// Load the classic theme
Galleria.loadTheme(ROOT + 'galleria/themes/classic/galleria.classic.min.js');

// Initialize Galleria
//Galleria.run('#galleria'); // normal initialization

Galleria.run('#galleria', {

    extend: function(options) {

		Galleria.configure({ // activating lightbox for each image
			lightbox: true
		});
		
		this.play(); //default:5000 - ref: http://galleria.io/docs/api/methods/#slideshow
    }
});