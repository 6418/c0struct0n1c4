<?php
/**
 * Filters for the Theme
 *
 * @package The Landscaper
 */

/**
 * Add shortcodes in widgets
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Custom tag font size
 */
if ( ! function_exists( 'thelandscaper_tag_cloud_sizes' ) ) {
    function thelandscaper_tag_cloud_sizes( $args ) {
    	$args['number'] = 12;
    	$args['largest'] = 11;
    	$args['smallest'] = 9;
    	return $args;
    }
    add_filter( 'widget_tag_cloud_args', 'thelandscaper_tag_cloud_sizes' );
}

/**
 * Wrap embed videos in a wrapper
 */
if ( ! function_exists( 'thelandscaper_oembed_html' ) ) {
    function thelandscaper_oembed_html( $html, $url, $attr, $post_id ) {
        return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
    }
    add_filter( 'embed_oembed_html', 'thelandscaper_oembed_html', 99, 4 );
}

/**
 * Wrap first word of widget title a <span>
 */
if ( ! function_exists( 'thelandscaper_widget_title' ) ) {
    function thelandscaper_widget_title( $title, $instance = '', $id_base = '' ) {

        if ( 'rss' != $id_base ) {

            // Cut the title to 2 parts
            $title_parts = explode( ' ', $title, 2 );

            // Wrap first word in span tag
            if ( ! empty( $title ) ) {
                $title = '<span class="light">' . $title_parts[0] . '</span>';
            
                // Add the rest of the title if exist
                if ( isset( $title_parts[1] ) ) {
                    $title .= ' ' . $title_parts[1];
                }
            }

            // Return title if isset
            if ( $title_parts[0] ) {
                $title = $title;
            }
        }

        return $title;
    }
    add_filter( 'widget_title', 'thelandscaper_widget_title', 10, 3 );
}

/**
 * Get selected Google fonts from the customizer
 */
if ( ! function_exists( 'thelandscaper_get_customizer_fonts' ) ) {
    function thelandscaper_get_customizer_fonts( $fonts ) {

        // Get the customizer font type settings
        $primary_font = get_theme_mod( 'qt_theme_primary_font', 'Roboto' );
        $secondary_font = get_theme_mod( 'qt_theme_secondary_font', 'Roboto Slab' );

        // Get selected fonts and set default font weight (400 is regular)
        $font_primary = array( $primary_font => array( '400', '700' ) );
        $font_secondary = array( $secondary_font => array( '400', '700' ) );

        // Merge everything and remove duplicated
        $fonts = array_merge( $font_primary, $font_secondary );
        $fonts = array_map( 'array_unique', $fonts );

        return $fonts;
    }
    add_filter( 'pre_google_web_fonts', 'thelandscaper_get_customizer_fonts' );
}

/**
 * Adds custom classes to the array of body classes.
 */
if( ! function_exists( 'thelandscaper_body_class' ) ) {
    function thelandscaper_body_class( $class ) {

        if ( is_multi_author() ) {
            $class[] = 'group-blog';
        }

        // If theme mod isset to boxed add body.boxed
        if ( 'boxed' === get_theme_mod( 'qt_theme_layout', 'wide' ) ) {
            $class[] = 'boxed';
        }

        // If theme mod isset to sticky navigation add body.sticky
        if ( 'sticky' === get_theme_mod( 'qt_nav_position', 'static' ) ) {
            $class[] = 'fixed-navigation';
        }

        // If doubletab is enabled add class to body
        if ( 'yes' === get_theme_mod( 'qt_nav_double_tap', 'yes' ) ) {
            $class[] = 'doubletap';
        }

        // If theme mod and ACF page option isset to hide topbar add body.no-topbar
        if ( 'hide' === get_theme_mod( 'qt_topbar', 'show' ) || 'hide' === get_field( 'topbar' ) ) {
            $class[] = 'no-topbar';
        }

        // If ACF page option isset to hide page header add body.no-page-header
        if ( 'header-hide' === get_field( 'page_title_area' ) ) {
            $class[] = 'no-page-header';
        }

        // If single gallery layout isset to split or fullwidth
        if ( 'split' === get_field( 'gallery_layout' ) ) {
            $class[] = 'gallery-layout-split';
        }

        // Get header layout from theme customizer
        $header = thelandscaper_get_header_layout();
        $class[] = 'header-'. $header;

        return $class;
    }
    add_filter( 'body_class', 'thelandscaper_body_class' );
}

/**
 * the_content read more link
 */
if ( ! function_exists( 'thelandscaper_read_more_link' ) ) {
    function thelandscaper_read_more_link() {

        $read_more = get_theme_mod( 'qt_blog_read_more', 'Read More' );

        if ( ! $read_more ) {
            $read_more = esc_html__( 'READ MORE', 'the-landscaper-wp' );
        }

        return '<a class="read more" href="'. esc_url( get_permalink() ) .'">'. esc_html( $read_more ) .'</a>';
    }
    add_filter( 'the_content_more_link', 'thelandscaper_read_more_link' );
}

/**
 * Add Custom styles to the Formats Dropdown in TinyMCE
 */
if ( ! function_exists( 'thelandscaper_tinymce_shortcodes' ) ) {
    function thelandscaper_tinymce_shortcodes( $settings ) {

        $headings = array(
            array(
                'title'   => esc_html__( 'Heading 1', 'the-landscaper-wp' ),
                'block'   => 'h1',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 2', 'the-landscaper-wp' ),
                'block'   => 'h2',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 3', 'the-landscaper-wp' ),
                'block'   => 'h3',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 4', 'the-landscaper-wp' ),
                'block'   => 'h4',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 5', 'the-landscaper-wp' ),
                'block'   => 'h5',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 6', 'the-landscaper-wp' ),
                'block'   => 'h6',
                'classes' => 'custom-title'
            ),
        );

        $style_formats = array(
            array(
                'title'   => esc_html__( 'QT: Custom Headings', 'the-landscaper-wp' ),
                'items'   => $headings
            )
        );

    $settings['style_formats_merge'] = true;
    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

  }
  add_filter( 'tiny_mce_before_init', 'thelandscaper_tinymce_shortcodes' );
}

/**
 * Enable font size and custom heading buttons in the tiny mce editor
 */
if ( ! function_exists( 'thelandscaper_tinymce_more_buttons' ) ) {
    function thelandscaper_tinymce_more_buttons( $buttons ) {
        $buttons[3] = 'styleselect';
        $buttons[2] = 'fontsizeselect';
        
        return $buttons;
    }
    add_filter( 'mce_buttons_3', 'thelandscaper_tinymce_more_buttons');
}

/**
 * Creates the style from the array for the page headers
 */
if ( ! function_exists( 'thelandscaper_header_array' ) ) {
    function thelandscaper_header_array( $settings ) {
        $array_style = 'style="';
        
        foreach ( $settings as $key => $value ) {
            if( $value ) {
            
                // If background isset add url()
                if( 'background-image' === $key ) {
                    $array_style .= $key . ': url(\'' . esc_url( $value ) . '\'); ';
                } else {
                    $array_style .= $key . ': ' . esc_attr( $value ) . '; ';
                }
            }
        }

        $array_style .= '"';

        return $array_style;
    }
}

/**
 * Define the custom options for the SiteOrigin Page Builder
 */
if ( ! function_exists( 'thelandscaper_define_custom_pagebuilder_options' ) ) {
    function thelandscaper_define_custom_pagebuilder_options( $fields ) {

        $fields['white_widget_title'] = array(
            'name'          => esc_html__( 'White Widget Title', 'the-landscaper-wp' ),
            'label'         => esc_html__( 'Use white colored widget title', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'priority'      => 16,
        );

        $fields['text_center'] = array(
            'name'          => esc_html__( 'Text Center', 'the-landscaper-wp' ),
            'label'         => esc_html__( 'Center all text in widget', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'priority'      => 17,
        );

        $fields['border_box'] = array(
            'name'          => esc_html__( 'Border Widget', 'the-landscaper-wp' ),
            'label'         => esc_html__( 'Set a border around the widget', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'priority'      => 18,
        );

        $fields['content_box'] = array(
            'name'          => esc_html__( 'Border Widget + Title', 'the-landscaper-wp' ),
            'label'         => esc_html__( 'Set a border around the widget and use a slightly smaller title', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'priority'      => 19,
        );

        return $fields;
    }
    add_filter( 'siteorigin_panels_widget_style_fields', 'thelandscaper_define_custom_pagebuilder_options' );
}

/**
 * Add some custom option to the SiteOrigin Page Builder widget styles panel
 */
if ( ! function_exists( 'thelandscaper_add_custom_options_to_pagebuilder' ) ) {
    function thelandscaper_add_custom_options_to_pagebuilder( $attributes, $args ) {

        if ( ! empty( $args['white_widget_title'] ) ) {
            array_push( $attributes['class'], 'white' );
        }

        if ( ! empty( $args['text_center'] ) ) {
            array_push( $attributes['class'], 'text-center' );
        }

        if ( ! empty( $args['border_box'] ) ) {
            array_push( $attributes['class'], 'border-box' );
        }

        if ( ! empty( $args['content_box'] ) ) {
            array_push( $attributes['class'], 'content-box' );
        }

        return $attributes;
    }
    add_filter( 'siteorigin_panels_widget_style_attributes', 'thelandscaper_add_custom_options_to_pagebuilder', 10, 2 );
}

/**
 * Change names & slug to gallery from portfolio CPT
 */
if ( ! function_exists( 'thelandscaper_portfolio_cpt_change' ) ) {
    function thelandscaper_portfolio_cpt_change( array $args ) {
        $labels = array(
            'name'               => esc_html__( 'Galleries', 'the-landscaper-wp' ),
            'singular_name'      => esc_html__( 'Gallery', 'the-landscaper-wp' ),
            'add_new'            => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'add_new_item'       => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'edit_item'          => esc_html__( 'Edit Gallery', 'the-landscaper-wp' ),
            'new_item'           => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'view_item'          => esc_html__( 'View Gallery', 'the-landscaper-wp' ),
            'search_items'       => esc_html__( 'Search Galleries', 'the-landscaper-wp' ),
            'not_found'          => esc_html__( 'No galleries found', 'the-landscaper-wp' ),
            'not_found_in_trash' => esc_html__( 'No galleries found in trash', 'the-landscaper-wp' ),
        );

        $args['labels'] = $labels;
        $args['rewrite'] = array( 'slug' => get_theme_mod( 'qt_gallery_slug', 'gallery' ) );
        $args['has_archive'] = false;

        return $args;
    }
    add_filter( 'portfolioposttype_args', 'thelandscaper_portfolio_cpt_change' );
}

/**
 * Change names & slug to gallery category from portfolio CPT
 */
if ( ! function_exists( 'thelandscaper_portfolio_category_args' ) ) {
    function thelandscaper_portfolio_category_args( array $args ) {
            $labels = array(
                'name'          => esc_html__( 'Gallery Categories', 'the-landscaper-wp' ),
                'singular_name' => get_theme_mod( 'qt_gallery_cat_title', 'Portfolio Category' ),
            );

            $args = array(
                'labels'    => $labels,
                'rewrite'   => array( 'slug' => get_theme_mod( 'qt_gallery_cat_slug', 'portfolio_category' ) ),
            );

            return $args;
    }
    add_filter( 'portfolioposttype_category_args', 'thelandscaper_portfolio_category_args' );
}

/**
 * Change names & slug to gallery tag from portfolio CPT
 */
if ( ! function_exists( 'thelandscaper_portfolio_tag_args' ) ) {
    function thelandscaper_portfolio_tag_args( array $args ) {
            $labels = array(
                'name'          => esc_html__( 'Gallery Tags', 'the-landscaper-wp' ),
                'singular_name' => get_theme_mod( 'qt_gallery_cat_title', 'Portfolio Category' ),
            );

            $args['labels'] = $labels;

            return $args;
    }
    add_filter( 'portfolioposttype_tag_args', 'thelandscaper_portfolio_tag_args' );
}

/**
 * Add Skype protocol, skype:username?call can be used
 */
if ( ! function_exists( 'thelandscaper_skype_protocol' ) ) {
    function thelandscaper_skype_protocol( $protocols ){
        $protocols[] = 'skype';
        return $protocols;
    }
    add_filter( 'kses_allowed_protocols' , 'thelandscaper_skype_protocol' );
}

/**
 * Remove the SiteOrigin page builder premium teaser
 */
add_filter( 'siteorigin_premium_upgrade_teaser', '__return_false' );