<?php
/**
 * Functions for the Theme
 *
 * @package The Landscaper
 */

/**
 * Check if WooCommerce is active
 */
if ( ! function_exists( 'thelandscaper_woocommerce_active' ) ) {
	function thelandscaper_woocommerce_active() {
		return class_exists( 'Woocommerce' );
	}
}

/**
 * Essential Grid integration
 * No custom prefix because it is a Essential Grid function
 */
if ( function_exists( 'set_ess_grid_as_theme' ) ) {
	define( 'ESS_GRID_AS_THEME', true );
	set_ess_grid_as_theme();
}

/**
 * Check if Max Mega Menu is active
 */
if ( ! function_exists( 'thelandscaper_max_mega_menu_active' ) ) {
	function thelandscaper_max_mega_menu_active() {

		$description = esc_html__( 'Each layout have specific color options. Please select the header layout, then change the colors of the header and navigation', 'the-landscaper-wp' );

		if ( class_exists( 'Mega_Menu') && function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'primary' ) ) {
			$description .= esc_html__( 'If you use the Max Mega Menu plugin please also set the correct Mega Menu layout for the selected header layout via the Appearance > Menu\'s > Max Mega Menu Settings > Theme', 'the-landscaper-wp' );
		}

		return $description;
	}
}

/**
 * Return the Google Font URL
 */
if ( ! function_exists( 'thelandscaper_fonts_slug' ) ) {
	function thelandscaper_fonts_slug() {

		$fonts_url = '';
		$fonts = array();

		$fonts = apply_filters( 'pre_google_web_fonts', $fonts );

		foreach ( $fonts as $key => $value ) {
			$fonts[$key] = $key . ':' . implode( ',', $value );
		}

		if ( $fonts ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}
		 
		return $fonts_url;
	}
}

/*
 * Return the correct header layout
 */
if ( ! function_exists( 'thelandscaper_get_header_layout' ) ) {
	function thelandscaper_get_header_layout() {

		// Get the page ID
		$get_id = thelandscaper_get_correct_page_id();

		// Get the header options
		$customizer_header_layout = get_theme_mod( 'qt_nav_layout', 'default' );
		$page_header_layout = get_field( 'header_layout', $get_id );
		$page_home_header_layout = get_field( 'home_header_layout', $get_id );

        // If header customizer option isset to default
        if ( 'default' === $customizer_header_layout ) {
			$header = 'default';
		}

		// If header customizer option isset to wide
		if ( 'wide' === $customizer_header_layout ) {
			$header = 'wide';
		}

		// If header customizer option isset to transparent
		if ( 'transparent' === $customizer_header_layout ) {
			$header = 'transparent';
		}

		// If header customizer option isset to sidebar
		if ( 'sidebar' === $customizer_header_layout ) {
			$header = 'sidebar';
		}

		if ( ! empty( $page_header_layout ) ) {
			$header = $page_header_layout;
		}

		if ( ! empty( $page_home_header_layout ) ) {
			$header = $page_home_header_layout;
		}

		return $header;
	}
}

/**
 *  Get the correct page id based on post/page
 */
if ( ! function_exists( 'thelandscaper_get_correct_page_id' ) ) {
    function thelandscaper_get_correct_page_id() {

        $get_id = get_the_ID();

        if ( is_home() || is_singular( 'post' ) ) {
            $page_id = absint( get_option( 'page_for_posts' ) );
            $get_id  = $page_id;
        }

        if ( thelandscaper_woocommerce_active() && is_woocommerce() ) {
            $shop_id = absint( get_option( 'woocommerce_shop_page_id', 0 ) );
            $get_id  = $shop_id;
        }

        return $get_id;
    }
}

/**
 *  Custom excerpt length option for the blog posts page
 */
if ( ! function_exists( 'thelandscaper_blog_grid_display_excerpt' ) ) {
    function thelandscaper_blog_grid_display_excerpt() {

    	$custom_length = get_theme_mod( 'qt_blog_custom_excerpt_length' );

        if ( $custom_length != '' ) {
			
			if ( has_excerpt() ) {
				$excerpt = get_the_excerpt();
			} else {
				$excerpt = get_the_content();
			}

			$excerpt = wp_trim_words( $excerpt, absint( $custom_length ), '...' );
			echo '<p>'. wp_kses_post( $excerpt ) .'</p>';
			echo thelandscaper_read_more_link();

		} else {
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				the_content();
			}
		}
    }
}

/**
 * Slider Image Sizes for Fullwidth Slider Page Template
 */
if ( ! function_exists( 'thelandscaper_srcset_sizes' ) ) {
	function thelandscaper_srcset_sizes( $img_id, $sizes ) {
		$srcset = array();

		foreach ( $sizes as $size ) {
			$img = wp_get_attachment_image_src( $img_id, $size );
			$srcset[] = sprintf( '%s %sw', $img[0], $img[1] ); //
		}

		return implode( ', ' , $srcset );
	}
}

/**
 * Generare a ligter/darker color based on a #hex color input
 */
if ( ! function_exists( 'thelandscaper_adjust_color' ) ) {
	function thelandscaper_adjust_color( $hex, $steps ) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Normalize into a six character long hex string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Split into three parts: R, G and B
	    $color_parts = str_split($hex, 2);
	    $return = '#';

	    foreach ($color_parts as $color) {
	        $color   = hexdec($color); // Convert to decimal
	        $color   = max(0,min(255,$color + $steps)); // Adjust color
	        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	    }

	    return $return;
	}
}

/**
 * Convert hexdec color string to rgb(a) string
 */
if ( ! function_exists( 'thelandscaper_hex_to_rgba' ) ) {
	function thelandscaper_hex_to_rgba( $color, $opacity ) {
	 
        $color = substr( $color, 1 );
 
        //Check if color has 6 or 3 characters and get values
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        }
 
        //Return rgb(a) color string
        return $output;
	}
}