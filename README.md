WP SZ Easy Testimonials Plugin
=======================

The starting point of a simple to use testimonial widget for WordPress

Currently supports

- [x] Generates custom post type
- [x] Widget support
- [x] Template Tag
- [x] Override template in theme (by copying ```./templates``` to ```themes/yourtheme/```

Version history

- 0.2
	- Both widget and template tags use the same testimoials-template (prev. Widget html was hardcoded)
	- Handles defaults and filters a little better

- 0.01alpha
	- basic functionality

## Usage

As Widget (preferred)
``` Add to widget area and adjust options```

As a Template Tag
```
	if ( class_exists( 'SZ_Easy_Testimonials' ) ) {
		SZ_Easy_Testimonials::do_testimonials();
	}
```

Currently template tags don't support passing options very intuitively.

Roadmap

- [ ] Add more options
- [ ] Rethink visibility / rendering options and implementation
- [ ] Add specific support for media queries
- [ ] Consider a carousel / slider option
- [ ] Add Basic CSS
- [ ] Create a more intuitive method of using ```template tags```