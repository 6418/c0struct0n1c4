<?php
/**
*
* Contains methods for customizing the theme customization screen.
* 
* @package The Landscaper
* @link http://codex.wordpress.org/Theme_Customization_API
*/
class TheLandscaper_Customizer {

	/**
	 * Holds the instance of this class.
	 *
	 * @access private
	 * @var    object
	 */
	private static $instance;

	public function __construct() {
		// Enqueue live preview javascript in Theme Customizer admin screen
		add_action( 'customize_preview_init', array( $this, 'thelandscaper_live_preview' ) );

		// Add options to the theme customizer.
		add_action( 'customize_register', array( $this, 'thelandscaper_customize_register' ) );

		// Output Customizer CSS & Custom CSS to the header
		add_action( 'wp_head', array( $this, 'thelandscaper_head_callback' ) );

		// Output Customizer JS to the header
		add_action( 'wp_head', array( $this, 'thelandscaper_head_js' ) );

		// Output Customizer JS to the footer
		add_action( 'wp_footer', array( $this, 'thelandscaper_foot_js' ) );

		// Delete the cached data for this feature.
		add_action( 'customize_save_after' . get_stylesheet(), array( $this, 'thelandscaper_cache_delete' ) );

		// Flush the rewrite rules after saving the customizer
		add_action( 'customize_save_after', 'flush_rewrite_rules' );
	}

	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	* 
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*  
	* @see add_action('customize_register',$func)
	*/
	public function thelandscaper_customize_register( $wp_customize ) {


		// Add Custom Panel to Live Customizer for Theme Options
		$wp_customize->add_panel( 'qt_theme_panel', array(
			'title'       	=> esc_html__( 'Theme Options', 'the-landscaper-wp' ),
			'priority'    	=> 10,
		) );

		// Add Custom Sections to the Theme Panel
		$wp_customize->add_section( 'qt_section_logo', array(
			'title'       	=> esc_html__( 'Logo', 'the-landscaper-wp' ),
			'priority'    	=> 10,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_header', array(
			'title' 	  	=> esc_html__( 'Header', 'the-landscaper-wp' ),
			'priority'    	=> 15,
			'panel'       	=> 'qt_theme_panel',
		) );
	    $wp_customize->add_section( 'qt_section_navigation', array(
			'title' 	  	=> esc_html__( 'Navigation', 'the-landscaper-wp' ),
			'priority' 	  	=> 20,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_slider', array(
			'title' 	  	=> esc_html__( 'Slider', 'the-landscaper-wp' ),
			'description' 	=> esc_html__( 'Color settings for the homepage slider', 'the-landscaper-wp' ),
			'priority' 	  	=> 25,
			'panel'       	=> 'qt_theme_panel',
		) );
	    $wp_customize->add_section( 'qt_section_main_title', array(
			'title' 	  	=> esc_html__( 'Page Header', 'the-landscaper-wp' ),
			'priority' 	  	=> 30,
			'panel'       	=> 'qt_theme_panel',
		) );
	    $wp_customize->add_section( 'qt_section_breadcrumbs', array(
			'title'		  	=> esc_html__( 'Breadcrumbs', 'the-landscaper-wp' ),
			'priority' 	  	=> 35,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_theme_colors', array(
			'title'		  	=> esc_html__( 'Layout &amp; Colors', 'the-landscaper-wp' ),
			'priority' 	  	=> 40,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_blog', array(
			'title'		  	=> esc_html__( 'Blog', 'the-landscaper-wp' ),
			'priority' 	  	=> 45,
			'panel'       	=> 'qt_theme_panel',
		) );
	    $wp_customize->add_section( 'qt_section_gallery', array(
			'title'		  	=> esc_html__( 'Single Gallery', 'the-landscaper-wp' ),
			'description' 	=> esc_html__( 'Gallery settings for the single gallery posts', 'the-landscaper-wp' ),
			'priority' 	  	=> 50,
			'panel'       	=> 'qt_theme_panel',
		) );
	    if( thelandscaper_woocommerce_active() ) {
	        $wp_customize->add_section( 'qt_section_shop', array(
	            'title'		  	=> esc_html__( 'Shop', 'the-landscaper-wp' ),
	            'priority' 	  	=> 55,
	            'panel'       	=> 'qt_theme_panel',
	        ) );
		}
	    $wp_customize->add_section( 'qt_section_footer', array(
			'title'		  	=> esc_html__( 'Footer', 'the-landscaper-wp' ),
			'priority' 	  	=> 60,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_typography', array(
			'title'		  	=> esc_html__( 'Typography', 'the-landscaper-wp' ),
			'description' 	=> sprintf( esc_html__( 'If you\'re looking for more advanced font controls please install the %s plugin or use the child theme to enqueue custom fonts', 'the-landscaper-wp'  ), '<a href="'. esc_url( '//wordpress.org/plugins/easy-google-fonts/' ) .'" target="_blank">Easy Google Fonts</a>' ),
			'priority' 	  	=> 65,
			'panel'       	=> 'qt_theme_panel',
		) );
		$wp_customize->add_section( 'qt_section_other', array(
			'title'		  	=> esc_html__( '404 Page', 'the-landscaper-wp' ),
			'priority' 	  	=> 70,
			'panel'       	=> 'qt_theme_panel',
		) );
	    $wp_customize->add_section( 'qt_section_custom', array(
            'title'		  	=> esc_html__( 'Custom', 'the-landscaper-wp' ),
            'description'	=> esc_html__( 'It is recommended to type custom CSS in a text editor and then paste it into the field below', 'the-landscaper-wp' ),
            'priority' 	  	=> 75,
            'panel'       	=> 'qt_theme_panel',
	    ) );


		// Section Settings: Logo
		$wp_customize->add_setting( 'qt_logo', array( 
			'default' 			=> get_template_directory_uri().'/assets/images/logo.png',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_logo', array(
	            'label' 	 	=> esc_html__('Theme logo', 'the-landscaper-wp'),
	            'description' 	=> esc_html__( 'Recommended logo height is 90 pixels', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_logo',
	            'settings' 	 	=> 'qt_logo',
				'priority'   	=> 5,
			)
		) );

		$wp_customize->add_setting( 'qt_logo_retina', array( 
			'default' 			=> get_template_directory_uri().'/assets/images/logo_2x.png',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize, 'qt_logo_retina', array(
            	'label' 	 	=> esc_html__( 'Theme logo retina (2x)', 'the-landscaper-wp' ),
	            'description' 	=> esc_html__( 'Please do not upload the regular logo here. Only add a logo that is exact 2x the size of the regular logo', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_logo',
	            'settings' 	 	=> 'qt_logo_retina',
				'priority'   	=> 10,
			)
		) );

		$wp_customize->add_setting( 'qt_logo_transparent', array( 
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_logo_transparent', array(
	            'label' 	 	=> esc_html__('Theme logo transparent', 'the-landscaper-wp'),
	            'description' 	=> esc_html__( 'Transparent logo for the sidebar and transparent header layout', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_logo',
	            'settings' 	 	=> 'qt_logo_transparent',
				'priority'   	=> 15,
			)
		) );

		$wp_customize->add_setting( 'qt_logo_retina_transparent', array( 
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize, 'qt_logo_retina_transparent', array(
            	'label' 	 	=> esc_html__( 'Theme logo retina transparent (2x)', 'the-landscaper-wp' ),
            	'description' 	=> esc_html__( 'Please do not upload the regular transparent logo here. Only add a logo that is exact 2x the size of the regular logo', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_logo',
	            'settings' 	 	=> 'qt_logo_retina_transparent',
				'priority'   	=> 20,
			)
		) );

		$wp_customize->add_setting( 'qt_logo_margin_top', array(
	    	'default' 			=> '0',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_logo_margin_top', array(
		    'label' 			=> esc_html__( 'Logo top margin', 'the-landscaper-wp'),
		    'description' 		=> esc_html__( 'Change the logo top margin. Please don\'t include px', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_logo',
		    'settings' 			=> 'qt_logo_margin_top',
		    'priority' 			=> 25,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 5,
			),
		) );

		$wp_customize->add_setting( 'qt_logo_width', array(
	    	'transport' 			=> 'refresh',
	    	'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_logo_width', array(
		    'label' 				=> esc_html__( 'Logo width', 'the-landscaper-wp'),
		    'description' 			=> esc_html__( 'Change the logo width. Please don\'t include px', 'the-landscaper-wp' ),
	    	'type' 					=> 'number',
		    'section' 				=> 'qt_section_logo',
		    'settings' 				=> 'qt_logo_width',
		    'priority' 				=> 30,
		    'input_attrs'			=> array(
				'min'  					=> 0,
				'max'  					=> 500,
				'step' 					=> 10,
			),
		) );

		// Header
		$wp_customize->add_setting( 'qt_topbar', array(
	    	'default'  				=> 'show',
	    	'transport'				=> 'refresh',
	    	'type'					=> 'theme_mod',
	    	'capability'			=> 'edit_theme_options',
	    	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
		) );
		$wp_customize->add_control( 'qt_topbar', array(
			'label'    				=> esc_html__( 'Topbar', 'the-landscaper-wp' ),
			'description'    		=> esc_html__( 'Show or hide the topbar', 'the-landscaper-wp' ),
			'section'  				=> 'qt_section_header',
			'settings' 				=> 'qt_topbar',
			'type'     				=> 'select',
			'choices'  				=> array(
				'show'  			=> esc_html__( 'Show', 'the-landscaper-wp' ),
				'hide' 				=> esc_html__( 'Hide', 'the-landscaper-wp' ),
				'hide_mobile' 		=> esc_html__( 'Hide mobile only', 'the-landscaper-wp' ),
			),
			'priority' 				=> 1,
		) );

		$wp_customize->add_setting( 'qt_nav_layout', array(
	    	'default'  			=> 'default',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_select',
		) );
		$wp_customize->add_control( 'qt_nav_layout', array(
			'label'    			=> esc_html__( 'Header layout', 'the-landscaper-wp' ),
			'description' 		=> thelandscaper_max_mega_menu_active(),
			'section'  			=> 'qt_section_header',
			'settings' 			=> 'qt_nav_layout',
			'type'     			=> 'select',
			'choices'  			=> array(
				'default'  		=> esc_html__( 'Default', 'the-landscaper-wp' ),
				'wide' 			=> esc_html__( 'Wide', 'the-landscaper-wp'),
				'transparent' 	=> esc_html__( 'Transparent', 'the-landscaper-wp'),
				'sidebar' 		=> esc_html__( 'Sidebar', 'the-landscaper-wp' ),
			),
			'priority' 			=> 50,
		) );

		/* Settings for the default & wide header */
		require get_template_directory() . '/inc/customizer-settings/header-default-settings.php';

		/* Settings for the transparent header */
		require get_template_directory() . '/inc/customizer-settings/header-transparent-settings.php';

		/* Settings for the sidebar header */
		require get_template_directory() . '/inc/customizer-settings/header-sidebar-settings.php';

		$wp_customize->add_setting( 'qt_nav_double_tap', array(
        	'default'  				=> 'yes',
        	'transport'				=> 'refresh',
        	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_nav_double_tap', array(
			'label'       			=> esc_html__( 'Enable doubletap touch laptop', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'When using a touch laptop the main navigation parent links will open the submenu on the first tab, the second tab will go to the actual page', 'the-landscaper-wp' ),
			'section'  				=> 'qt_section_navigation',
			'settings' 				=> 'qt_nav_double_tap',
			'type'     				=> 'select',
			'choices'  				=> array(
				'yes'					=> esc_html__( 'Yes', 'the-landscaper-wp' ),
				'no' 					=> esc_html__( 'No', 'the-landscaper-wp' ),
			),
		) );


		// Section Settings: Navigation
		$wp_customize->add_setting( 'qt_nav_mobile_bg', array(
			'default' 			=> '#a2c046',
			'transport'			=> 'refresh',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_mobile_bg', array(
			'label'         	=> esc_html__( 'Mobile background color', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Change the background color of the parent links', 'the-landscaper-wp' ),
			'section'     		=> 'qt_section_navigation',
			'settings'    		=> 'qt_nav_mobile_bg',
			'priority'    		=> 10,
		) ) );

		$wp_customize->add_setting( 'qt_nav_mobile_textcolor', array(
		    'default'    		=> '#ffffff',
		    'transport'			=> 'refresh',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_mobile_textcolor', array(
			'label'      		=> esc_html__( 'Mobile link color', 'the-landscaper-wp' ),
			'description'		=> esc_html__( 'Change the color of the parent links', 'the-landscaper-wp' ),
			'section'     		=> 'qt_section_navigation',
			'settings'    		=> 'qt_nav_mobile_textcolor',
			'priority'    		=> 15,
		) ) );

		$wp_customize->add_setting( 'qt_nav_mobile_submenu_bg', array(
		    'default'    		=> '#9ab643',
		    'transport'			=> 'refresh',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_mobile_submenu_bg', array(
			'label'      		=> esc_html__( 'Mobile submenu background color', 'the-landscaper-wp' ),
			'description'		=> esc_html__( 'Change the background color of the submenu links', 'the-landscaper-wp' ),
			'section'     		=> 'qt_section_navigation',
			'settings'    		=> 'qt_nav_mobile_submenu_bg',
			'priority'    		=> 20,
		) ) );

		$wp_customize->add_setting( 'qt_nav_mobile_submenu_textcolor', array(
		    'default'    		=> '#ffffff',
		    'transport'			=> 'refresh',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_mobile_submenu_textcolor', array(
			'label'      		=> esc_html__( 'Mobile submenu link color', 'the-landscaper-wp' ),
			'description'		=> esc_html__( 'Change the text color of the submenu links', 'the-landscaper-wp' ),
			'section'     		=> 'qt_section_navigation',
			'settings'    		=> 'qt_nav_mobile_submenu_textcolor',
			'priority'    		=> 25,
		) ) );


		// Section Settings: Slider
		$wp_customize->add_setting( 'qt_slider_small_heading_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_small_heading_color', array(
			'label'      			=> esc_html__( 'Top heading color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the color of the small top heading', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_small_heading_color',
			'priority'    			=> 10,
		) ) );

		$wp_customize->add_setting( 'qt_slider_heading_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_heading_color', array(
			'label'      			=> esc_html__( 'Heading color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the color of the heading', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_heading_color',
			'priority'    			=> 15,
		) ) );

		$wp_customize->add_setting( 'qt_slider_content_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_content_color', array(
			'label'      			=> esc_html__( 'Content color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the color of the content texts', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_content_color',
			'priority'    			=> 20,
		) ) );

		$wp_customize->add_setting( 'qt_slider_primary_button_background_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_primary_button_background_color', array(
			'label'      			=> esc_html__( 'Primary button background color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the background color of the primary button', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_primary_button_background_color',
			'priority'    			=> 25,
		) ) );

		$wp_customize->add_setting( 'qt_slider_primary_button_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_primary_button_color', array(
			'label'      			=> esc_html__( 'Primary button text color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the text color of the primary button', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_primary_button_color',
			'priority'    			=> 30,
		) ) );

		$wp_customize->add_setting( 'qt_slider_control_background_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_control_background_color', array(
			'label'      			=> esc_html__( 'Controls background color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the background color of the slider controls', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_control_background_color',
			'priority'    			=> 35,
		) ) );

		$wp_customize->add_setting( 'qt_slider_control_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_control_color', array(
			'label'      			=> esc_html__( 'Control arrow color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the color of the slider controls icon', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_control_color',
			'priority'    			=> 40,
		) ) );

		$wp_customize->add_setting( 'qt_slider_mobile_background_color', array(
		    'transport'				=> 'postMessage',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_slider_mobile_background_color', array(
			'label'      			=> esc_html__( '(Mobile) Caption background color', 'the-landscaper-wp' ),
			'description' 			=> esc_html__( 'Change the background color of the slider captions on mobile', 'the-landscaper-wp' ),
			'section'     			=> 'qt_section_slider',
			'settings'    			=> 'qt_slider_mobile_background_color',
			'priority'    			=> 45,
		) ) );


		// Section Settings: Main Title Area
		$wp_customize->add_setting( 'qt_maintitle_layout', array(
        	'default'  			=> 'small',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_maintitle_layout', array(
			'label'    			=> esc_html__( 'Page header', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Show or hide the page header on all pages', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_main_title',
			'settings' 			=> 'qt_maintitle_layout',
			'type'    			=> 'select',
			'choices'  			=> array(
				'small'  		=> esc_html__( 'Small', 'the-landscaper-wp'),
				'large' 		=> esc_html__( 'Large', 'the-landscaper-wp'),
				'hide' 			=> esc_html__( 'Hide page header', 'the-landscaper-wp'),
			),
		) );

		$wp_customize->add_setting( 'qt_maintitle_align', array(
        	'default'  			=> 'left',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_maintitle_align', array(
			'label'    			=> esc_html__( 'Alignment', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Change the alignment of the page header titles', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_main_title',
			'settings' 			=> 'qt_maintitle_align',
			'type'    			=> 'select',
			'choices'  			=> array(
				'left'  		=> esc_html__( 'Left', 'the-landscaper-wp'),
				'center' 		=> esc_html__( 'Center', 'the-landscaper-wp'),
				'right' 	    => esc_html__( 'Right', 'the-landscaper-wp'),
			),
		) );

		$wp_customize->add_setting( 'qt_maintitle_color', array(
	    	'default'     		=> '#333333',
	    	'transport'			=> 'postMessage',
	    	'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_maintitle_color', array(
				'label'      	=> esc_html__( 'Page title color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the color of the page title', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_main_title',
				'settings'   	=> 'qt_maintitle_color',
			)
		) );

		$wp_customize->add_setting( 'qt_subtitle_color', array(
	    	'default'     		=> '#999999',
	    	'transport'			=> 'postMessage',
	    	'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_subtitle_color', array(
				'label'      	=> esc_html__( 'Subtitle color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the color of the subtitle', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_main_title',
				'settings'   	=> 'qt_subtitle_color',
			)
		) );

		$wp_customize->add_setting( 'qt_maintitle_bgcolor', array(
	    	'default'     		=> '#f2f2f2',
	    	'transport'			=> 'postMessage',
	    	'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_maintitle_bgcolor', array(
				'label'      	=> esc_html__( 'Background color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the background color of the page header', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_main_title',
				'settings'   	=> 'qt_maintitle_bgcolor',
			)
		) );

		$wp_customize->add_setting( 'qt_maintitle_bgimage', array(
			'default' 	 		=> get_template_directory_uri().'/assets/images/leafs.png',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_maintitle_bgimage', array(
	            'label' 	 	=> esc_html__( 'Background pattern', 'the-landscaper-wp' ),
	            'description' 	=> esc_html__( 'Add a background image to the page header', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_main_title',
	            'settings' 	 	=> 'qt_maintitle_bgimage',
			)
		) );


		// Section Settings: Breadcrumbs
		$wp_customize->add_setting( 'qt_breadcrumbs', array(
        	'default'  			=> 'show',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_breadcrumbs', array(
			'label'    			=> esc_html__( 'Breadcrumbs', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Show or hide the breadcrumbs on all pages', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_breadcrumbs',
			'settings' 			=> 'qt_breadcrumbs',
			'type'    			=> 'select',
			'choices'  			=> array(
				'show'  		=> esc_html__( 'Show', 'the-landscaper-wp' ),
				'hide' 			=> esc_html__( 'Hide', 'the-landscaper-wp' ),
			),
		) );

		$wp_customize->add_setting( 'qt_breadcrumbs_align', array(
        	'default'  			=> 'left',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_breadcrumbs_align', array(
			'label'    			=> esc_html__( 'Alignment', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Change the alignment of the breadcrumbs', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_breadcrumbs',
			'settings' 			=> 'qt_breadcrumbs_align',
			'type'    			=> 'select',
			'choices'  			=> array(
				'left'  		=> esc_html__( 'Left', 'the-landscaper-wp' ),
				'center' 		=> esc_html__( 'Center', 'the-landscaper-wp' ),
				'right' 	    => esc_html__( 'Right', 'the-landscaper-wp' ),
			),
		) );

		$wp_customize->add_setting( 'qt_breadcrumbs_textcolor', array(
		    'default'    		=> '#999999',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_breadcrumbs_textcolor', array(
				'label'      	=> esc_html__( 'Text color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the color of the breadcrumb links', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_breadcrumbs',
				'settings'   	=> 'qt_breadcrumbs_textcolor',
			)
		) );

		$wp_customize->add_setting( 'qt_breadcrumbs_activecolor', array(
		    'default'    		=> '#a2c046',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_breadcrumbs_activecolor', array(
				'label'      	=> esc_html__( 'Active color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the color of the active breadcrumb link', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_breadcrumbs',
				'settings'   	=> 'qt_breadcrumbs_activecolor',
			)
		) );

		$wp_customize->add_setting( 'qt_breadcrumbs_bg_color', array(
			'default' 			=> '#ffffff',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_breadcrumbs_bg_color', array(
				'label'      	=> esc_html__( 'Background color', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Change the background color of the breadcrumbs', 'the-landscaper-wp' ),
				'section'    	=> 'qt_section_breadcrumbs',
				'settings'   	=> 'qt_breadcrumbs_bg_color',
			)
		) );


		// Section Settings: Theme Layout & Colors
		$wp_customize->add_setting( 'qt_boxed_bg', array(
			'default' 			=> '#ffffff',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_boxed_bg', array(
				'label'       	=> esc_html__( 'Content background color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the background color of the content area', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'	  	=> 'qt_boxed_bg',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_textcolor', array(
		    'default'     		=> '#a5a5a5',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_textcolor', array(
				'label'       	=> esc_html__( 'Text color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the color of the content texts', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_textcolor',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_primary_color', array(
	    	'default'     		=> '#a2c046',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_color', array(
				'label'       	=> esc_html__( 'Primary color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the primary color scheme', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_primary_color',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_primary_btncolor', array(
	     	'default'     		=> '#a2c046',
	     	'transport'			=> 'refresh',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_btncolor', array(
				'label'       	=> esc_html__( 'Button background color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the background color of the button', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_primary_btncolor',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_primary_btntext', array(
	     	'default'     		=> '#ffffff',
	     	'transport'			=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_btntext', array(
				'label'       	=> esc_html__( 'Button text color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the text color of the button', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_primary_btntext',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_widgettitle', array(
	     	'default'     		=> '#9fc612',
	     	'transport'			=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_widgettitle', array(
				'label'       	=> esc_html__( 'Widget title color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the color of the widget titles', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_widgettitle',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_widgettitle_span', array(
	     	'default'     		=> '#464646',
	     	'transport'			=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_widgettitle_span', array(
				'label'       	=> esc_html__( 'First word in widget title', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the color of the first word in widget titles', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_theme_colors',
				'settings'    	=> 'qt_theme_widgettitle_span',
			)
		) );

		$wp_customize->add_setting( 'qt_theme_layout', array(
        	'default'  			=> 'wide',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_theme_layout', array(
			'label'    			=> esc_html__( 'Boxed layout', 'the-landscaper-wp' ),
			'description'		=> esc_html__( 'Enable the boxed layout', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_theme_colors',
			'settings' 			=> 'qt_theme_layout',
			'type'    			=> 'select',
			'choices'  			=> array(
				'wide'  		=> esc_html__( 'Disable', 'the-landscaper-wp' ),
				'boxed' 		=> esc_html__( 'Enable', 'the-landscaper-wp' ),
			)
		) );

		$wp_customize->add_setting( 'qt_theme_widgettitle_border', array(
        	'default'  			=> 'dashed',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_theme_widgettitle_border', array(
			'label'    			=> esc_html__( 'Theme border style', 'the-landscaper-wp' ),
			'description'		=> esc_html__( 'Change the border style of the widget titles', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_theme_colors',
			'settings' 			=> 'qt_theme_widgettitle_border',
			'type'    			=> 'select',
			'choices' 			=> array(
				'solid' 		=> esc_html__( 'Solid', 'the-landscaper-wp' ),
				'dashed' 	 	=> esc_html__( 'Dashed', 'the-landscaper-wp' ),
				'dotted'		=> esc_html__( 'Dotted', 'the-landscaper-wp' ),
			)
		) );

		$wp_customize->add_setting( 'qt_scroll_to_top_button', array(
	    	'default'  				=> 'show',
	    	'transport'				=> 'refresh',
	    	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
		) );
		$wp_customize->add_control( 'qt_scroll_to_top_button', array(
			'label'    				=> esc_html__( 'Scroll to top button', 'the-landscaper-wp' ),
			'description'			=> esc_html__( 'Enable the scroll to top button', 'the-landscaper-wp' ),
			'section'  				=> 'qt_section_theme_colors',
			'settings' 				=> 'qt_scroll_to_top_button',
			'type'     				=> 'select',
			'choices'  				=> array(
				'show'  			=> esc_html__( 'Show', 'the-landscaper-wp' ),
				'hide' 				=> esc_html__( 'Hide', 'the-landscaper-wp' ),
			),
		) );

		if( class_exists( 'Essential_Grid' ) ) {
			$wp_customize->add_setting( 'qt_default_esg_style', array(
		    	'default'  				=> 'enable',
		    	'transport'				=> 'refresh',
		    	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
			) );
			$wp_customize->add_control( 'qt_default_esg_style', array(
				'label'    				=> esc_html__( 'Essential Grid color', 'the-landscaper-wp' ),
				'description'			=> esc_html__( 'The primary color will be applied to the \'The Landscaper\' essential grid skins', 'the-landscaper-wp' ),
				'section'  				=> 'qt_section_theme_colors',
				'settings' 				=> 'qt_default_esg_style',
				'type'     				=> 'select',
				'choices'  				=> array(
					'enable' 			=> esc_html__( 'Enable', 'the-landscaper-wp' ),
					'disable'  			=> esc_html__( 'Disable', 'the-landscaper-wp' ),
				),
			) );
		}


		// Section Settings: Blog
		$wp_customize->add_setting( 'qt_blog_metadata', array(
        	'default'  			=> 'show',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_blog_metadata', array(
			'label'    			=> esc_html__( 'Display metadata', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Show or hide the post metadata', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_blog',
			'settings' 			=> 'qt_blog_metadata',
			'type'    			=> 'select',
			'choices' 			=> array(
				'show' 			=> esc_html__( 'Show', 'the-landscaper-wp'),
				'hide'  		=> esc_html__( 'Hide', 'the-landscaper-wp'),
			),
			'priority' 			=> 5,
		) );
		
		$wp_customize->add_setting( 'qt_blog_bigdate', array(
        	'default'  			=> 'show',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_blog_bigdate', array(
			'label'    			=> esc_html__( 'Display large date', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'For blog posts in the list layout', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_blog',
			'settings' 			=> 'qt_blog_bigdate',
			'type'    			=> 'select',
			'choices' 			=> array(
				'show' 			=> esc_html__( 'Show', 'the-landscaper-wp'),
				'hide'  		=> esc_html__( 'Hide', 'the-landscaper-wp'),
			),
			'priority' 			=> 10,
		) );

		$wp_customize->add_setting( 'qt_blog_commments', array(
        	'default'  			=> 'show',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_blog_commments', array(
			'label'    			=> esc_html__( 'Display comment section', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Show or hide the comment section for all blog posts', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_blog',
			'settings' 			=> 'qt_blog_commments',
			'type'    			=> 'select',
			'choices' 			=> array(
				'show' 			=> esc_html__( 'Show', 'the-landscaper-wp'),
				'hide'  		=> esc_html__( 'Hide', 'the-landscaper-wp'),
			),
			'priority' 			=> 15,
		) );

		$wp_customize->add_setting( 'qt_blog_read_more', array(
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_read_more', array(
	    	'label' 			=> esc_html__( 'Read more text', 'the-landscaper-wp' ),
	    	'description' 		=> esc_html__( 'Change the read more link text of the blog posts', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_blog',
	    	'settings' 			=> 'qt_blog_read_more',
	    	'type' 				=> 'text',
	    	'priority' 			=> 20,
		) );

		$wp_customize->add_setting( 'qt_blog_custom_excerpt_length', array(
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_custom_excerpt_length', array(
	    	'label' 			=> esc_html__( 'Custom excerpt length', 'the-landscaper-wp' ),
	    	'description' 		=> esc_html__( 'Set a custom length for all blog excerpt text. This will overrule the default read more tag', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_blog',
	    	'settings' 			=> 'qt_blog_custom_excerpt_length',
	    	'type' 				=> 'text',
	    	'priority' 			=> 25,
		) );

		$wp_customize->add_setting( 'qt_blog_share', array(
        	'default'  			=> 'blog',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_blog_share', array(
			'label'    			=> esc_html__( 'Display the share buttons', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Add social share buttons at the bottom of the post/page', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_blog',
			'settings' 			=> 'qt_blog_share',
			'type'    			=> 'select',
			'choices' 			=> array(
				'show' 			=> esc_html__( 'All pages &amp; posts', 'the-landscaper-wp'),
				'blog' 			=> esc_html__( 'Only on blog posts', 'the-landscaper-wp'),
				'pages' 		=> esc_html__( 'Only on pages', 'the-landscaper-wp'),
				'galleries' 	=> esc_html__( 'Only on single gallery pages', 'the-landscaper-wp'),
				'hide'  		=> esc_html__( 'Hide', 'the-landscaper-wp'),
			),
			'priority' 			=> 30,
		) );

		$wp_customize->add_setting( 'qt_blog_tooltip', array(
			'default'			=> 'Share',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_tooltip', array(
		    'label' 			=> esc_html__( 'Share tooltip text', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_blog',
		    'settings' 			=> 'qt_blog_tooltip',
		    'type' 				=> 'text',
		    'active_callback'   => array( $this, 'thelandscaper_hide_social_input_fields' ),
		    'priority' 			=> 35,
		) );

		$wp_customize->add_setting( 'qt_blog_twitter', array(
			'default'			=> 'Twitter',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_twitter', array(
		    'label' 			=> esc_html__( 'Twitter button text', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_blog',
		    'settings' 			=> 'qt_blog_twitter',
		    'type' 				=> 'text',
		    'active_callback'   => array( $this, 'thelandscaper_hide_social_input_fields' ),
		    'priority' 			=> 40,
		) );

		$wp_customize->add_setting( 'qt_blog_facebook', array(
			'default'			=> 'Facebook',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_facebook', array(
		    'label' 			=> esc_html__( 'Facebook button text', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_blog',
		    'settings' 			=> 'qt_blog_facebook',
		    'type' 				=> 'text',
		    'active_callback'   => array( $this, 'thelandscaper_hide_social_input_fields' ),
		    'priority' 			=> 45,
		) );

		$wp_customize->add_setting( 'qt_blog_googleplus', array(
			'default'			=> 'Google+',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_googleplus', array(
		    'label' 			=> esc_html__( 'Google+ button text', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_blog',
		    'settings' 			=> 'qt_blog_googleplus',
		    'type' 				=> 'text',
		    'active_callback'   => array( $this, 'thelandscaper_hide_social_input_fields' ),
		    'priority' 			=> 50,
		) );

		$wp_customize->add_setting( 'qt_blog_linkedin', array(
			'default'			=> 'LinkedIn',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_blog_linkedin', array(
		    'label' 			=> esc_html__( 'LinkedIn button text', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_blog',
		    'settings' 			=> 'qt_blog_linkedin',
		    'type' 				=> 'text',
		    'active_callback'   => array( $this, 'thelandscaper_hide_social_input_fields' ),
		    'priority' 			=> 55,
		) );


		// Section Settings: Gallery
		$wp_customize->add_setting( 'qt_gallery_title', array(
        	'default'  			=> 'actual_title',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_gallery_title', array(
			'label'    			=> esc_html__( 'Position of the page title', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_gallery',
			'settings' 			=> 'qt_gallery_title',
			'type'    			=> 'select',
			'choices' 			=> array(
				'actual_title' 	=> esc_html__( 'Show Actual Item Title', 'the-landscaper-wp' ),
				'custom_title'  => esc_html__( 'Show Custom Title', 'the-landscaper-wp' ),
			),
			'priority' 			=> 1,
		) );

		$wp_customize->add_setting( 'qt_gallery_maintitle', array(
	    	'default' 			=> 'Gallery',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_maintitle', array(
		    'label' 			=> esc_html__( 'Gallery page title', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Display if above option isset to custom title', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_maintitle',
		    'priority' 			=> 5,
		) );

		$wp_customize->add_setting( 'qt_gallery_subtitle', array(
	    	'default' 			=> 'A selection of our best work',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_subtitle', array(
		    'label' 			=> esc_html__( 'Gallery subtitle', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Display if subtitle field on specific post is empty', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_subtitle',
		    'priority' 			=> 10,
		) );

		$wp_customize->add_setting( 'qt_gallery_nav', array(
        	'default'  			=> 'show',
        	'transport'			=> 'refresh',
        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    ) );
		$wp_customize->add_control( 'qt_gallery_nav', array(
			'label'    			=> esc_html__( 'Display gallery navigation', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_gallery',
			'settings' 			=> 'qt_gallery_nav',
			'type'    			=> 'select',
			'choices' 			=> array(
				'show' 	=> esc_html__( 'Show', 'the-landscaper-wp'),
				'hide'  => esc_html__( 'Hide', 'the-landscaper-wp'),
			),
			'priority' 			=> 15,
		) );

		$wp_customize->add_setting( 'qt_gallery_prevtext', array(
	    	'default' 			=> 'Previous',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_prevtext', array(
		    'label' 			=> esc_html__( 'Previous button text', 'the-landscaper-wp'),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_prevtext',
		    'active_callback'	=> array( $this, 'thelandscaper_show_setting_gallery_nav' ),
		    'priority' 			=> 20,
		) );

		$wp_customize->add_setting( 'qt_gallery_nexttext', array(
	    	'default' 			=> 'Next',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_nexttext', array(
		    'label' 			=> esc_html__( 'Next button text', 'the-landscaper-wp'),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_nexttext',
		    'active_callback'	=> array( $this, 'thelandscaper_show_setting_gallery_nav' ),
		    'priority' 			=> 25,
		) );

		$wp_customize->add_setting( 'qt_gallery_summarylink', array(
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'qt_gallery_summarylink', array(
		    'label'				=> esc_html__( 'Gallery summary link', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_summarylink',
		    'active_callback'	=> array( $this, 'thelandscaper_show_setting_gallery_nav' ),
		    'priority' 			=> 30,
		) );

		$wp_customize->add_setting( 'qt_gallery_summarytext', array(
			'default'			=> 'View Summary',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_summarytext', array(
			'label'				=> esc_html__( 'Gallery summary text', 'the-landscaper-wp' ),
			'section'			=> 'qt_section_gallery',
			'settings'			=> 'qt_gallery_summarytext',
			'active_callback'	=> array( $this, 'thelandscaper_show_setting_gallery_nav' ),
			'priority'			=> 35,
		) );

		$wp_customize->add_setting( 'qt_gallery_slug', array(
	    	'default' 			=> 'gallery',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_gallery_slug',
		) );
		$wp_customize->add_control( 'qt_gallery_slug', array(
		    'label' 			=> esc_html__( 'Gallery URL slug', 'the-landscaper-wp' ),
		    'description'		=> esc_html__( 'After changing this setting please go to Settings > Permalinks and save the page', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_slug',
		    'priority' 			=> 40,
		) );

		$wp_customize->add_setting( 'qt_gallery_cat_slug', array(
	    	'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_gallery_slug',
		) );
		$wp_customize->add_control( 'qt_gallery_cat_slug', array(
		    'label' 			=> esc_html__( 'Gallery category URL slug', 'the-landscaper-wp' ),
		    'description'		=> esc_html__( 'After changing this setting please go to Settings > Permalinks and save the page', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_cat_slug',
		    'priority' 			=> 45,
		) );

		$wp_customize->add_setting( 'qt_gallery_cat_title', array(
	    	'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_gallery_cat_title', array(
		    'label' 			=> esc_html__( 'Gallery category title', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Prefix for the gallery category page title', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_gallery',
		    'settings' 			=> 'qt_gallery_cat_title',
		    'priority' 			=> 50,
		) );


		// Section Settings: Shop
		if( thelandscaper_woocommerce_active() ) {
			$wp_customize->add_setting( 'qt_shop_products_per_page', array(
		    	'default' 			=> '8',
		    	'transport'			=> 'refresh',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			) );
			$wp_customize->add_control( 'qt_shop_products_per_page', array(
			    'label' 			=> esc_html__( 'Products per page', 'the-landscaper-wp'),
			    'section' 			=> 'qt_section_shop',
			    'settings' 			=> 'qt_shop_products_per_page',
			    'priority' 			=> 5,
			) );

			$wp_customize->add_setting( 'qt_single_product_sidebar', array(
				'default'			=> 'Right',
	        	'transport'			=> 'refresh',
	        	'sanitize_callback' => 'thelandscaper_sanitize_text',
		    ) );
			$wp_customize->add_control( 'qt_single_product_sidebar', array(
				'label'    			=> esc_html__( 'Single product page sidebar', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_shop',
				'settings' 			=> 'qt_single_product_sidebar',
				'type'    			=> 'select',
				'choices' 			=> array(
					'Hide'  		=> esc_html__( 'No sidebar', 'the-landscaper-wp'),
					'Left'  		=> esc_html__( 'Left', 'the-landscaper-wp'),
					'Right' 		=> esc_html__( 'Right', 'the-landscaper-wp'),
				),
				'priority' 			=> 10,
			) );
			$wp_customize->add_setting( 'qt_shop_product_zoom', array(
				'default'  				=> 'enable',
				'transport'				=> 'refresh',
				'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
			) );

			$wp_customize->add_control( 'qt_shop_product_zoom', array(
				'label'       			=> esc_html__( 'Single product image zoom', 'the-landscaper-wp' ),
				'description' 			=> esc_html__( 'Use the WooCommerce product image zoom. Changes are visible on the front-end', 'the-landscaper-wp' ),
				'section'				=> 'qt_section_shop',
				'settings'				=> 'qt_shop_product_zoom',
				'type'					=> 'select',
				'choices'	  			=> array(
					'enable'					=> esc_html__( 'Enable', 'the-landscaper-wp' ),
					'disable'					=> esc_html__( 'Disable', 'the-landscaper-wp' ),
				),
			) );
			$wp_customize->add_setting( 'qt_shop_product_lightbox', array(
				'default'  				=> 'enable',
				'transport'				=> 'refresh',
				'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
			) );

			$wp_customize->add_control( 'qt_shop_product_lightbox', array(
				'label'       			=> esc_html__( 'Single product image lightbox', 'the-landscaper-wp' ),
				'description' 			=> esc_html__( 'Use the WooCommerce product image lightbox. Changes are visible on the front-end', 'the-landscaper-wp' ),
				'section'				=> 'qt_section_shop',
				'settings'				=> 'qt_shop_product_lightbox',
				'type'					=> 'select',
				'choices'	  			=> array(
					'enable'					=> esc_html__( 'Enable', 'the-landscaper-wp' ),
					'disable'					=> esc_html__( 'Disable', 'the-landscaper-wp' ),
				),
			) );
			$wp_customize->add_setting( 'qt_shop_product_slider', array(
				'default'  				=> 'enable',
				'transport'				=> 'refresh',
				'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
			) );

			$wp_customize->add_control( 'qt_shop_product_slider', array(
				'label'       			=> esc_html__( 'Single product image gallery slider', 'the-landscaper-wp' ),
				'description' 			=> esc_html__( 'Use the WooCommerce product image gallery slider. Changes are visible on the front-end', 'the-landscaper-wp' ),
				'section'				=> 'qt_section_shop',
				'settings'				=> 'qt_shop_product_slider',
				'type'					=> 'select',
				'choices'	  			=> array(
					'enable'					=> esc_html__( 'Enable', 'the-landscaper-wp' ),
					'disable'					=> esc_html__( 'Disable', 'the-landscaper-wp' ),
				),
			) );
		}


		// Section Settings: Footer
		$wp_customize->add_setting( 'qt_footer_columns', array( 
			'default' 			=> 4,
			'transport'			=> 'refresh',
			'sanitize_callback' => 'thelandscaper_sanitize_select',
		) );
		$wp_customize->add_control( 'qt_footer_columns', array(
			'type'        		=> 'select',
			'priority'    		=> 0,
			'label'       		=> esc_html__( 'Footer columns', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Select how many columns you want to use in the footer. Select 0 to hide the footer', 'the-landscaper-wp' ),
			'section'     		=> 'qt_section_footer',
			'settings'    		=> 'qt_footer_columns',
			'choices'     		=> range( 0, 4 ),
		) );

		$wp_customize->add_setting( 'qt_footer_textcolor', array(
	    	'default'     		=> '#757575',
	    	'transport'	  		=> 'postMessage',
	    	'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_textcolor', array(
				'label'       	=> esc_html__( 'Text color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the text color of the footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footer_textcolor',
				'priority'    	=> 5,
			)
		) );

		$wp_customize->add_setting( 'qt_footer_widgettitle', array(
		    'default'     		=> '#ffffff',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_widgettitle', array(
				'label'       	=> esc_html__( 'Widget title color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the widget title color of the footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footer_widgettitle',
				'priority'    	=> 10,
			)
		) );

		$wp_customize->add_setting( 'qt_footer_bgcolor', array(
			'default'			=> '#333333',
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_bgcolor', array(
				'label'       	=> esc_html__( 'Footer background color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the background color of the footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footer_bgcolor',
				'priority'    	=> 15,
			)
		) );

		$wp_customize->add_setting( 'qt_footer_bgimage', array(
			'default' 	 		=> get_template_directory_uri().'/assets/images/leafs_dark.png',
			'transport'			=> 'refresh',
	    	'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_footer_bgimage', array(
	            'label' 	 	=> esc_html__( 'Background pattern', 'the-landscaper-wp' ),
	            'description'	=> esc_html__( 'Change the background image of the footer', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_footer',
	            'settings' 		=> 'qt_footer_bgimage',
				'priority'   	=> 20,
			)
		) );

		$wp_customize->add_setting( 'qt_footerbottom_bgcolor', array(
			'default'			=> '#292929',
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_bgcolor', array(
				'label'       	=> esc_html__( 'Bottom footer background color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the background color of the bottom footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footerbottom_bgcolor',
				'priority'    	=> 25,
			)
		) );

		$wp_customize->add_setting( 'qt_footerbottom_textcolor', array(
		    'default'     		=> '#656565',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_textcolor', array(
				'label'       	=> esc_html__( 'Bottom footer text color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the text color of the bottom footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footerbottom_textcolor',
				'priority'    	=> 30,
			)
		) );

		$wp_customize->add_setting( 'qt_footerbottom_linkcolor', array(
		    'default'     		=> '#e4e4e4',
		    'transport'	  		=> 'postMessage',
		    'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_linkcolor', array(
				'label'       	=> esc_html__( 'Bottom footer link color', 'the-landscaper-wp' ),
				'description'	=> esc_html__( 'Change the link color of the bottom footer', 'the-landscaper-wp' ),
				'section'     	=> 'qt_section_footer',
				'settings'    	=> 'qt_footerbottom_linkcolor',
				'priority'    	=> 33,
			)
		) );

		$wp_customize->add_setting( 'qt_footerbottom_textleft', array(
	    	'default' 			=> 'Copyright 2017 The Landscaper by Qreativethemes',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_footerbottom_textleft', array(
		    'label' 			=> esc_html__( 'Bottom footer left text', 'the-landscaper-wp' ),
		    'description'		=> esc_html__( 'Add a text to the left side of the bottom footer', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_footer',
		    'settings' 			=> 'qt_footerbottom_textleft',
		    'type' 				=> 'text',
		    'priority' 			=> 35,
		) );

		$wp_customize->add_setting( 'qt_footerbottom_textmiddle', array(
			'default'			=> 'Middle Text',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_footerbottom_textmiddle', array(
		    'label' 			=> esc_html__( 'Bottom footer middle text', 'the-landscaper-wp' ),
		    'description'		=> esc_html__( 'Add a text to the middle of the bottom footer', 'the-landscaper-wp' ),
		    'section' 			=> 'qt_section_footer',
		    'settings' 			=> 'qt_footerbottom_textmiddle',
		    'type' 				=> 'text',
		    'priority' 			=> 40,
		) );

		$wp_customize->add_setting( 'qt_footerbottom_textright', array(
	    	'default' 			=> 'For emergency tree removal 123-777-456',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_footerbottom_textright', array(
	    	'label' 			=> esc_html__( 'Bottom footer right text', 'the-landscaper-wp' ),
	    	'description'		=> esc_html__( 'Add a text to the right side of the bottom footer', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_footer',
	    	'settings' 			=> 'qt_footerbottom_textright',
	    	'type' 				=> 'text',
	    	'priority' 			=> 45,
		) );


		// List the default Google fonts
		require get_template_directory() . '/inc/customizer-settings/google-font-settings.php';

		// Section Settings: Typography
		$wp_customize->add_setting( 'qt_theme_primary_font', array(
			'default' 			=> 'Roboto',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'esc_attr',
		) );
		$wp_customize->add_control( 'qt_theme_primary_font', array(
			'label'    			=> esc_html__( 'Primary font', 'the-landscaper-wp' ),
			'description'    	=> esc_html__( 'Font used for body text and navigation', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_typography',
			'settings' 			=> 'qt_theme_primary_font',
			'type'     			=> 'select',
			'choices' 			=> thelandscaper_list_google_fonts(),
			'priority' 			=> 5,
		) );

		$wp_customize->add_setting( 'qt_theme_primary_font_size', array(
			'default' 			=> '14',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_primary_font_size', array(
		    'label' 			=> esc_html__( 'Primary font size', 'the-landscaper-wp'),
		    'description'    	=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_primary_font_size',
		    'priority' 			=> 10,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_secondary_font', array(
			'default' 			=> 'Roboto Slab',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'esc_attr',
		) );
		$wp_customize->add_control( 'qt_theme_secondary_font', array(
			'label'    			=> esc_html__( 'Secondary font', 'the-landscaper-wp' ),
			'description'    	=> esc_html__( 'Font used for the headings and titles', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_typography',
			'settings' 			=> 'qt_theme_secondary_font',
			'type'     			=> 'select',
			'choices' 			=> thelandscaper_list_google_fonts(),
			'priority' 			=> 15,
		) );

		$wp_customize->add_setting( 'qt_theme_custom_heading_sizes', array(
			'default' 			=> 'no',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'esc_attr',
		) );
		$wp_customize->add_control( 'qt_theme_custom_heading_sizes', array(
			'label'    			=> esc_html__( 'Change heading sizes?', 'the-landscaper-wp' ),
			'description' 		=> esc_html__( 'Set custom sizes for headings', 'the-landscaper-wp' ),
			'section'  			=> 'qt_section_typography',
			'settings' 			=> 'qt_theme_custom_heading_sizes',
			'type'     			=> 'select',
			'choices' 			=> array(
				'yes' 				=> 'Yes',
				'no' 				=> 'No',
			),
			'priority' 			=> 20,
		) );

		$wp_customize->add_setting( 'qt_theme_widget_title_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_widget_title_size', array(
		    'label' 			=> esc_html__( 'Widget title size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_widget_title_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 25,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_one_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_one_size', array(
		    'label' 			=> esc_html__( 'Header 1 (H1) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_one_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 25,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_two_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_two_size', array(
		    'label' 			=> esc_html__( 'Header 2 (H2) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_two_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 30,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_three_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_three_size', array(
		    'label' 			=> esc_html__( 'Header 3 (H3) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_three_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 35,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_four_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_four_size', array(
		    'label' 			=> esc_html__( 'Header 4 (H4) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_four_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 40,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_five_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_five_size', array(
		    'label' 			=> esc_html__( 'Header 5 (H5) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_five_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 45,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );

		$wp_customize->add_setting( 'qt_theme_heading_six_size', array(
			'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'qt_theme_heading_six_size', array(
		    'label' 			=> esc_html__( 'Header 6 (H6) size', 'the-landscaper-wp' ),
		    'description' 		=> esc_html__( 'Please don\'t include px in your string', 'the-landscaper-wp' ),
	    	'type'		        => 'number',
		    'section' 			=> 'qt_section_typography',
		    'settings' 			=> 'qt_theme_heading_six_size',
		    'active_callback'   => array( $this, 'thelandscaper_show_custom_heading_sizes' ),
		    'priority' 			=> 50,
		    'input_attrs' 		=> array(
				'min' 		=> 0,
				'max'  		=> 100,
				'step' 		=> 2,
			),
		) );


		// Section Settings: Others
		$wp_customize->add_setting( 'qt_404_page_image', array( 
			'transport'			=> 'refresh',
			'sanitize_callback' => 'esc_url',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_404_page_image', array(
	            'label' 	 	=> esc_html__( '404 page image', 'the-landscaper-wp'),
	            'description' 	=> esc_html__( 'To reach the 404 page navigate to a page that don\'t exisint via the browser domain bar', 'the-landscaper-wp' ),
	            'section' 	 	=> 'qt_section_other',
	            'settings' 	 	=> 'qt_404_page_image',
				'priority'   	=> 5,
			)
		) );

		$wp_customize->add_setting( 'qt_404_page_text_title', array(
	    	'default' 			=> 'Oops! That page can\'t be found',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_404_page_text_title', array(
	    	'label' 			=> esc_html__( '404 page text heading', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_other',
	    	'settings' 			=> 'qt_404_page_text_title',
	    	'type' 				=> 'text',
	    	'priority' 			=> 10,
		) );

		$wp_customize->add_setting( 'qt_404_page_text', array(
	    	'default' 			=> 'Nothing was found here, try a search below',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_404_page_text', array(
	    	'label' 			=> esc_html__( '404 page text', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_other',
	    	'settings' 			=> 'qt_404_page_text',
	    	'type' 				=> 'text',
	    	'priority' 			=> 15,
		) );

		$wp_customize->add_setting( 'qt_404_page_search', array(
	    	'default'  				=> 'show',
	    	'transport'				=> 'refresh',
	    	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
		) );
		$wp_customize->add_control( 'qt_404_page_search', array(
			'label'    				=> esc_html__( '404 page search bar', 'the-landscaper-wp' ),
			'section'  				=> 'qt_section_other',
			'settings' 				=> 'qt_404_page_search',
			'type'     				=> 'select',
			'choices'  				=> array(
				'show'  			=> esc_html__( 'Show', 'the-landscaper-wp' ),
				'hide' 				=> esc_html__( 'Hide', 'the-landscaper-wp' ),
			),
			'priority' 				=> 20,
		) );

		// Section Settings: Custom CSS
		$wp_customize->add_setting( 'qt_custom_css', array(
			'default' 			=> '/* Add your custom CSS below */',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'wp_kses',
		) );
		$wp_customize->add_control( 'qt_custom_css', array(
	    	'label' 			=> esc_html__( 'Custom CSS', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_custom',
	    	'settings' 			=> 'qt_custom_css',
	    	'type' 				=> 'textarea',
	    	'priority' 			=> 5,
		) );

		$wp_customize->add_setting( 'qt_custom_head_js', array(
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_js',
		) );
		$wp_customize->add_control( 'qt_custom_head_js', array(
	    	'label' 			=> esc_html__( 'Custom header JS', 'the-landscaper-wp' ),
	    	'description' 		=> esc_html__( 'Please use the <script></script> tags', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_custom',
	    	'settings' 			=> 'qt_custom_head_js',
	    	'type' 				=> 'textarea',
	    	'priority' 			=> 10,
		) );

		$wp_customize->add_setting( 'qt_custom_foot_js', array(
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_js',
		) );
		$wp_customize->add_control( 'qt_custom_foot_js', array(
	    	'label' 			=> esc_html__( 'Custom footer JS', 'the-landscaper-wp' ),
	    	'description' 		=> esc_html__( 'Please use the <script></script> tags', 'the-landscaper-wp' ),
	    	'section' 			=> 'qt_section_custom',
	    	'settings' 			=> 'qt_custom_foot_js',
	    	'type' 				=> 'textarea',
	    	'priority' 			=> 15,
		) );

		$wp_customize->add_setting( 'qt_custom_google_api', array(
	    	'default' 			=> '',
	    	'transport'			=> 'refresh',
	    	'sanitize_callback' => 'thelandscaper_sanitize_text',
		) );
		$wp_customize->add_control( 'qt_custom_google_api', array(
	    	'label' 			=> esc_html__( 'Google Maps API key', 'the-landscaper-wp' ),
	    	'description' 		=> sprintf( esc_html__( 'Enter your Google Maps API key. Create one %s', 'the-landscaper-wp'  ), '<a href="'. esc_url( 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true' ) .'" target="_blank">here</a>' ),
	    	'section' 			=> 'qt_section_custom',
	    	'settings' 			=> 'qt_custom_google_api',
	    	'type' 				=> 'text',
	    	'priority' 			=> 20,
		) );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}


	/**
	 * Formats the primary styles for output.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function thelandscaper_get_primary_styles() {
		// Get all the Theme Mods

		// Top Margin Logo
		$qt_logo_margin_top			  			  = get_theme_mod( 'qt_logo_margin_top' );
		$qt_logo_width 							  = get_theme_mod( 'qt_logo_width' );

		/**
		 * Header Layout Default & Wide
		 */

		// Topbar
		$topbar_bg 								  = get_theme_mod( 'qt_topbar_bg', '#3a3a3a' );
		$topbar_textcolor 						  = get_theme_mod( 'qt_topbar_textcolor', '#7d7d7d' );
		$topbar_textcolor_adjust 				  = thelandscaper_adjust_color( $topbar_textcolor, -25);
		$topbar_textcolor_hover 				  = thelandscaper_adjust_color( $topbar_textcolor, 150);

		// Navigation
		$nav_bg 								  = get_theme_mod( 'qt_nav_bg', '#a2c046' );
		$nav_bg_full 							  = get_theme_mod( 'qt_nav_bg_full', '#ffffff' );
		$nav_bg_adjust 							  = thelandscaper_adjust_color( $nav_bg, 25 );
		$nav_textcolor 							  = get_theme_mod( 'qt_nav_textcolor', '#ffffff' );
		$nav_textcolor_hover 					  = get_theme_mod( 'qt_nav_textcolor_hover' );
		$nav_submenu_bgcolor 					  = get_theme_mod( 'qt_nav_submenu_bg', '#434343' );
		$nav_submenu_bgcolor_adjust 			  = thelandscaper_adjust_color( $nav_submenu_bgcolor, -9 );
		$nav_submenu_textcolor 					  = get_theme_mod( 'qt_nav_submenu_textcolor', '#999999' );
		$nav_submenu_textcolor_adjust 			  = thelandscaper_adjust_color( $nav_submenu_textcolor, 100 );

		/**
		 * Header Layout Transparent
		 */

		// Topbar
		$topbar_bg_transparent 					  = get_theme_mod( 'qt_topbar_bg_transparent', '#3a3a3a' );
		$topbar_textcolor_transparent 			  = get_theme_mod( 'qt_topbar_textcolor_transparent', '#7d7d7d' );
		$topbar_textcolor_adjust_transparent      = thelandscaper_adjust_color( $topbar_textcolor_transparent, 0 );
		$topbar_textcolor_hover_transparent 	  = thelandscaper_adjust_color( $topbar_textcolor_transparent, 50 );

		$gradient_bg_transparent 				  = get_theme_mod( 'qt_gradient_bg_transparent', '#000000' );
		$gradient_bg_transparent_opacity 		  = get_theme_mod( 'qt_gradient_bg_transparent_opacity', '0.5' );
		$gradient_bg_transparent_rgba 			  = thelandscaper_hex_to_rgba( $gradient_bg_transparent, $gradient_bg_transparent_opacity );

		// Navigation
		$nav_textcolor_transparent 				  = get_theme_mod( 'qt_nav_textcolor_transparent', '#ffffff' );
		$nav_textcolor_hover_transparent 		  = get_theme_mod( 'qt_nav_textcolor_hover_transparent' );
		$nav_submenu_bgcolor_transparent 		  = get_theme_mod( 'qt_nav_submenu_bg_transparent', '#434343' );
		$nav_submenu_bgcolor_adjust_transparent	  = thelandscaper_adjust_color( $nav_submenu_bgcolor_transparent, -9 );
		$nav_submenu_textcolor_transparent 		  = get_theme_mod( 'qt_nav_submenu_textcolor_transparent', '#999999' );
		$nav_submenu_topline_transparent 		  = get_theme_mod( 'qt_nav_submenu_topline_transparent', '#a2c046' );
	    $nav_submenu_textcolor_adjust_transparent = thelandscaper_adjust_color( $nav_submenu_textcolor_transparent, 100 );

	    $nav_stickynav_bg_transparent 			  = get_theme_mod( 'qt_nav_stickynav_bg_transparent', '#000000' );
	    $nav_stickynav_bg_transparent_opcity 	  = get_theme_mod( 'qt_nav_stickynav_bg_transparent_opacity', '0.5' );
	    $nav_stickynav_bg_rgba 					  = thelandscaper_hex_to_rgba( $nav_stickynav_bg_transparent, $nav_stickynav_bg_transparent_opcity );


		/**
		 * Header Layout Sidebar
		 */

		// Topbar
		$topbar_bg_sidebar 						  = get_theme_mod( 'qt_topbar_bg_sidebar', '#3a3a3a' );
		$topbar_textcolor_sidebar 			      = get_theme_mod( 'qt_topbar_textcolor_sidebar', '#7d7d7d' );
		$topbar_textcolor_adjust_sidebar          = thelandscaper_adjust_color( $topbar_textcolor_sidebar, -25 );
		$topbar_textcolor_hover_sidebar 	      = thelandscaper_adjust_color( $topbar_textcolor_sidebar, 150 );

		// Navigation
		$nav_bg_sidebar 					      = get_theme_mod( 'qt_nav_bg_sidebar', '#3a3a3a' );
		$nav_active_line 						  = get_theme_mod( 'qt_nav_active_line', '#a2c046' );
		$nav_bg_adjust_sidebar 				  	  = thelandscaper_adjust_color( $nav_bg_sidebar, 25 );
		$nav_textcolor_sidebar 				  	  = get_theme_mod( 'qt_nav_textcolor_sidebar', '#ffffff' );
		$nav_textcolor_hover_sidebar 			  = get_theme_mod( 'qt_nav_textcolor_hover_sidebar' );
		$nav_submenu_bgcolor_sidebar 		  	  = get_theme_mod( 'qt_nav_submenu_bg_sidebar', '#a2c046' );
		$nav_submenu_bgcolor_adjust_sidebar	  	  = thelandscaper_adjust_color( $nav_submenu_bgcolor_sidebar, -9 );
		$nav_submenu_textcolor_sidebar 		 	  = get_theme_mod( 'qt_nav_submenu_textcolor_sidebar', '#ffffff' );
		$nav_submenu_textcolor_adjust_sidebar  	  = thelandscaper_adjust_color( $nav_submenu_textcolor_sidebar, 100 );


		// Mobile Navigation
		$nav_mobile_bg 				  = get_theme_mod( 'qt_nav_mobile_bg' , '#a2c046' );
		$nav_mobile_bg_adjust 		  = thelandscaper_adjust_color( $nav_mobile_bg, 10 );
		$nav_mobile_textcolor 		  = get_theme_mod( 'qt_nav_mobile_textcolor', '#ffffff' );
		$nav_mobile_submenu_bg 		  = get_theme_mod( 'qt_nav_mobile_submenu_bg', '#9ab643' );
		$nav_mobile_submenu_textcolor = get_theme_mod( 'qt_nav_mobile_submenu_textcolor', '#ffffff' );


		// Slider
		$slider_small_heading_color 				= get_theme_mod( 'qt_slider_small_heading_color' );
		$slider_heading_color 						= get_theme_mod( 'qt_slider_heading_color' );
		$slider_content_color 						= get_theme_mod( 'qt_slider_content_color' );
		$slider_primary_button_background_color 	= get_theme_mod( 'qt_slider_primary_button_background_color' );
		$slider_primary_button_color 				= get_theme_mod( 'qt_slider_primary_button_color' );
		$slider_control_background_color 			= get_theme_mod( 'qt_slider_control_background_color' );
		$slider_control_color 						= get_theme_mod( 'qt_slider_control_color' );
		$slider_mobile_background_color 			= get_theme_mod( 'qt_slider_mobile_background_color' );


		// Page Header
		$maintitle_align 			  = get_theme_mod( 'qt_maintitle_align' , 'left' );
		$maintitle_bgcolor 			  = get_theme_mod( 'qt_maintitle_bgcolor', '#f2f2f2' );
		$maintitle_bgimage 			  = get_theme_mod( 'qt_maintitle_bgimage', get_template_directory_uri().'/assets/images/leafs.png' );
		$maintitle_color 			  = get_theme_mod( 'qt_maintitle_color', '#333333' );
		$subtitle_color  			  = get_theme_mod( 'qt_subtitle_color', '#999999' );

		// Breadcrumbs
		$breadcrumbs_align 			  = get_theme_mod( 'qt_breadcrumbs_align' , 'left' );
		$breadcrumbs_textcolor 		  = get_theme_mod( 'qt_breadcrumbs_textcolor', '#a5a5a5' );
		$breadcrumbs_text_hover		  = thelandscaper_adjust_color( $breadcrumbs_textcolor, -10 );
		$breadcrumbs_activecolor 	  = get_theme_mod( 'qt_breadcrumbs_activecolor', '#a2c046' );
		$breadcrumbs_bg_color 		  = get_theme_mod( 'qt_breadcrumbs_bg_color', '#ffffff' );

		// Theme Colors -- Primary 
		$theme_primary_color 		  = get_theme_mod( 'qt_theme_primary_color', '#a2c046' );
		$theme_primary_color_adjust   = thelandscaper_adjust_color( $theme_primary_color, -10);
		$theme_primary_color_adjust_light = thelandscaper_adjust_color( $theme_primary_color, 52); // For the small slider heading

		// Theme Colors -- Button Background
		$theme_btn_color 			  = get_theme_mod( 'qt_theme_primary_btncolor', '#a2c046' );
		$theme_btn_color_adjust 	  = thelandscaper_adjust_color( $theme_btn_color, -10 );

		// Theme Colors -- Button Text Color
		$theme_btn_textcolor		  = get_theme_mod( 'qt_theme_primary_btntext', '#ffffff' );

		// Theme Colors -- Text Color
		$theme_textcolor 			  = get_theme_mod( 'qt_theme_textcolor', '#a5a5a5' );

		// Theme Colors -- Widget Title Color
		$widget_title_color 		  = get_theme_mod( 'qt_theme_widgettitle', '#9fc612' );

		// Theme Colors -- First Span Widget Title Color
		$widget_title_span_color 	  = get_theme_mod( 'qt_theme_widgettitle_span', '#464646' );

		// Theme Colors -- Theme Border Style
		$widget_border_style 		  = get_theme_mod( 'qt_theme_widgettitle_border', 'dashed' );

		// Footer
		$footer_bg 					  = get_theme_mod( 'qt_footer_bgcolor' );
		$footer_bgimage 			  = get_theme_mod( 'qt_footer_bgimage', get_template_directory_uri().'/assets/images/leafs_dark.png' );
		$footer_textcolor 			  = get_theme_mod( 'qt_footer_textcolor', '#757575' );
		$footer_widget_title 		  = get_theme_mod( 'qt_footer_widgettitle', '#ffffff' );
		$footer_bottom_bg 			  = get_theme_mod( 'qt_footerbottom_bgcolor', '#292929' );
		$footer_bottom_textcolor 	  = get_theme_mod( 'qt_footerbottom_textcolor', '#777777' );
		$footer_bottom_linkcolor 	  = get_theme_mod( 'qt_footerbottom_linkcolor', '#e4e4e4' );
		$footer_bottom_linkcolor_adjust = thelandscaper_adjust_color( $footer_bottom_linkcolor, 50 );

		// Boxed Layout
		$boxed_bg 					  = get_theme_mod( 'qt_boxed_bg', '#ffffff' );

		// Font Settings
		$theme_primary_font 		  = get_theme_mod( 'qt_theme_primary_font', 'Roboto' );
		$theme_secondary_font 		  = get_theme_mod( 'qt_theme_secondary_font', 'Roboto Slab' );
		$theme_primary_font_size 	  = get_theme_mod( 'qt_theme_primary_font_size' );

		$theme_custom_heading_sizes   = get_theme_mod( 'qt_theme_custom_heading_sizes', 'no' );
		$theme_widget_title_size 	  = get_theme_mod( 'qt_theme_widget_title_size' );
		$theme_heading_one_size 	  = get_theme_mod( 'qt_theme_heading_one_size' );
		$theme_heading_two_size 	  = get_theme_mod( 'qt_theme_heading_two_size' );
		$theme_heading_three_size 	  = get_theme_mod( 'qt_theme_heading_three_size' );
		$theme_heading_four_size 	  = get_theme_mod( 'qt_theme_heading_four_size' );
		$theme_heading_five_size 	  = get_theme_mod( 'qt_theme_heading_fice_size' );
		$theme_heading_six_size 	  = get_theme_mod( 'qt_theme_heading_six_size' );

		/**  
		 * Build Up the Styles
		 *
		 **/
		$thelandscaper_style = "";


		// Primary font
		if ( $theme_primary_font ) {

			// Primary font type
			$thelandscaper_style .= "
				body,
				button,
				input,
				select,
				textarea,
				.btn,
				.topbar,
				.topbar a,
				.topbar .tagline,
				.topbar .widget-icon-box .title,
				.topbar .widget-icon-box .subtitle,
				.main-navigation li a,
				.page-header .sub-title,
				.panel-group .accordion-toggle,
				.block-posts .widget-title a,
				.testimonials .testimonial-quote {
					font-family: '{$theme_primary_font}';
				}
			";

			// Primary font size
			if ( $theme_primary_font_size != '' ) {
				
				$thelandscaper_style .= "
					body {
						font-size: {$theme_primary_font_size}px;
					}
				";
			}
		}

		// Secondary font
		if ( $theme_secondary_font ) {

			$thelandscaper_style .= "
				h1,
				h2,
				h3,
				h4,
				h5,
				h6,
				.jumbotron.carousel .carousel-text h1,
				.testimonials .testimonial-person .testimonial-author,
				.dropcap-wrap .dropcap-title,
				.counter .count-number, .counter .count-before, .counter .count-after {
					font-family: '{$theme_secondary_font}';
				}
			";
		}

		// Custom heading sizes
		if ( 'yes' === $theme_custom_heading_sizes ) {

			// Widget title size
			if ( $theme_widget_title_size != '' ) {
				
				$thelandscaper_style .= "
					.widget-title {
						font-size: {$theme_widget_title_size}px;
					}
				";
			}

			// Heading 1
			if ( $theme_heading_one_size != '' ) {
				
				$thelandscaper_style .= "
					.content h1 {
						font-size: {$theme_heading_one_size}px;
					}
				";
			}

			// Heading 2
			if ( $theme_heading_two_size != '' ) {
				
				$thelandscaper_style .= "
					.content h2 {
						font-size: {$theme_heading_two_size}px;
					}
				";
			}

			// Heading 3
			if ( $theme_heading_three_size != '' ) {
				
				$thelandscaper_style .= "
					.content h3 {
						font-size: {$theme_heading_three_size}px;
					}
				";
			}

			// Heading 4
			if ( $theme_heading_four_size != '' ) {
				
				$thelandscaper_style .= "
					.content h4 {
						font-size: {$theme_heading_four_size}px;
					}
				";
			}

			// Heading 5
			if ( $theme_heading_five_size != '' ) {
				
				$thelandscaper_style .= "
					.content h5 {
						font-size: {$theme_heading_five_size}px;
					}
				";
			}

			// Heading 6
			if ( $theme_heading_six_size != '' ) {
				
				$thelandscaper_style .= "
					.content h6 {
						font-size: {$theme_heading_six_size}px;
					}
				";
			}
		}

		$thelandscaper_style .= "
			.header .navigation .navbar-brand img { 
				margin-top: {$qt_logo_margin_top}px;
				width: {$qt_logo_width}px;
			}

			@media (max-width: 992px) {
				.main-navigation li a {
					color: {$nav_mobile_textcolor};
					border-color: {$nav_mobile_bg_adjust};
					background-color: {$nav_mobile_bg};
				}

				.main-navigation li .sub-menu li a {
					color: {$nav_mobile_submenu_textcolor};
					background-color: {$nav_mobile_submenu_bg};
				}
				.main-navigation > li.nav-toggle-dropdown .nav-toggle-mobile-submenu {
					background-color: {$nav_mobile_submenu_bg};
				}
				.header { 
					background-color: {$nav_bg_full};
				}
			}
		";


		// Header Layout Default & Wide CSS
		if ( 'default' === get_theme_mod( 'qt_nav_layout', 'default' ) || 
			 'default' === get_field( 'header_layout', get_the_ID() ) || 
			 'default' === get_field( 'home_header_layout', get_the_ID() ) || 
			 'wide' === get_theme_mod( 'qt_nav_layout', 'default' ) || 
			 'wide' === get_field( 'header_layout', get_the_ID() ) || 
			 'wide' === get_field( 'home_header_layout', get_the_ID() ) ) {

			// Topbar
			$thelandscaper_style .= "

				@media (max-width: 992px) { 
					.topbar { background-color: {$topbar_bg}; }
				}

				.topbar,
				.topbar a,
				.topbar .tagline,
				.topbar .widget-icon-box .title,
				.topbar .widget-icon-box .subtitle { 
					color: {$topbar_textcolor};
				}

				.topbar .fa,
				.topbar .widget-icon-box .fa,
				.topbar .widget-social-icons a {
					color: {$topbar_textcolor_adjust};
				}

				.topbar .widget-icon-box:hover .fa,
				.topbar .widget-social-icons a:hover .fa,
				.topbar .menu > li.menu-item-has-children:hover > a {
					color: {$topbar_textcolor_hover};
				}

				@media (min-width: 992px) {
					.header { 
						background-color: {$topbar_bg};
					}

					.main-navigation::before { 
						border-color: transparent transparent transparent {$nav_bg_full};
					}
					.navigation {
						background-color: {$nav_bg_full};
					}
					
					.main-navigation,
					.header.header-wide .main-navigation::after {
						background-color: {$nav_bg};
					}
					
					.main-navigation li a {
						color: {$nav_textcolor};
					}

					.main-navigation li:hover a,
					.main-navigation li.menu-item-has-children:hover::after {
						color: {$nav_textcolor_hover};
					}
					
					.main-navigation li .sub-menu li a {
						color: {$nav_submenu_textcolor};
						background-color: {$nav_submenu_bgcolor};
					}

					.main-navigation li .sub-menu li:hover > a {
						color: {$nav_submenu_textcolor_adjust};
						background-color: {$nav_submenu_bgcolor_adjust};
						border-bottom-color: {$nav_submenu_bgcolor_adjust};
					}

					.main-navigation>li:hover>a::after,
					.main-navigation>li:focus>a::after,
					.main-navigation>li.current-menu-item>a::after,
					.main-navigation>li.current-menu-item>a:hover::after,
					.main-navigation>li.current-menu-parent>a::after,
					.main-navigation>li.current-menu-parent>a:hover::after,
					.navigation ul>li>a::before {
						background-color: {$nav_bg_adjust};
					}
				}
			";
		}


		// Header Layout Transparent CSS
		if ( 'transparent' === get_theme_mod( 'qt_nav_layout', 'default' ) || 
			 'transparent' === get_field( 'header_layout', get_the_ID() ) || 
			 'transparent' === get_field( 'home_header_layout', get_the_ID() ) ) {

			// Topbar
			$thelandscaper_style .= "

				@media (max-width: 992px) {
					body.header-transparent .topbar {
						background-color: {$topbar_bg_transparent};
					}
				}

				@media (min-width: 992px) {
					body.header-transparent .header-transparent {
						background: linear-gradient(to bottom, {$gradient_bg_transparent_rgba} 0%, transparent 100%);
					}
				}

				body.header-transparent .topbar,
				body.header-transparent .topbar a,
				body.header-transparent .topbar .tagline,
				body.header-transparent .topbar .widget-icon-box .title,
				body.header-transparent .topbar .widget-icon-box .subtitle { 
					color: {$topbar_textcolor_transparent};
				}

				body.header-transparent .topbar .fa,
				body.header-transparent .topbar .widget-icon-box .fa,
				body.header-transparent .topbar .widget-social-icons a {
					color: {$topbar_textcolor_adjust_transparent};
				}

				body.header-transparent .topbar .widget-icon-box:hover .fa,
				body.header-transparent .topbar .widget-social-icons a:hover .fa,
				body.header-transparent .topbar .menu > li.menu-item-has-children:hover > a {
					color: {$topbar_textcolor_hover_transparent};
				}
		
				@media(min-width: 992px) {

					body.header-transparent.is-sticky-nav .navigation-wrapper {
						background: {$nav_stickynav_bg_rgba};
					}
					
					.header-transparent .main-navigation>li>a {
						color: {$nav_textcolor_transparent};
					}

					.header-transparent .main-navigation>li:hover>a,
					.header-transparent .main-navigation>li.menu-item-has-children:hover::after {
						color: {$nav_textcolor_hover_transparent};
					}

					.header-transparent .main-navigation>li>.sub-menu {
						border-top-color: {$nav_submenu_topline_transparent};
					}
					
					.header-transparent .main-navigation>li>.sub-menu li a {
						color: {$nav_submenu_textcolor_transparent};
						background-color: {$nav_submenu_bgcolor_transparent};
					}

					.header-transparent .main-navigation>li>.sub-menu li:hover > a {
						color: {$nav_submenu_textcolor_adjust_transparent};
						background-color: {$nav_submenu_bgcolor_adjust_transparent};
						border-bottom-color: {$nav_submenu_bgcolor_adjust_transparent};
					}
				}
			";
		}


		// Header Layout Sidebar CSS
		if ( 'sidebar' === get_theme_mod( 'qt_nav_layout', 'default' ) || 
			 'sidebar' === get_field( 'header_layout', get_the_ID() ) || 
			 'sidebar' === get_field( 'home_header_layout', get_the_ID() ) ) {

			// Topbar
			$thelandscaper_style .= "

				body.header-sidebar .header-sidebar {
					background-color: {$topbar_bg_sidebar};
				}

				body.header-sidebar .topbar,
				body.header-sidebar .topbar a,
				body.header-sidebar .topbar .tagline,
				body.header-sidebar .topbar .widget-icon-box .title,
				body.header-sidebar .topbar .widget-icon-box .subtitle {
					color: {$topbar_textcolor_sidebar};
				}

				body.header-sidebar .topbar .fa,
				body.header-sidebar .topbar .widget-icon-box .fa,
				body.header-sidebar .topbar .widget-social-icons a {
					color: {$topbar_textcolor_adjust_sidebar};
				}

				body.header-sidebar .topbar .widget-icon-box:hover .fa,
				body.header-sidebar .topbar .widget-social-icons a:hover .fa,
				body.header-sidebar .topbar .menu > li.menu-item-has-children:hover > a {
					color: {$topbar_textcolor_hover_sidebar};
				}
		
				@media (min-width: 992px) {
					
					.header-sidebar .main-navigation>li>a {
						color: {$nav_textcolor_sidebar};
						background-color: {$nav_bg_sidebar};
					}

					.header-sidebar .main-navigation>li:hover a {
						color: {$nav_textcolor_hover_sidebar};
					}

					.header-sidebar .main-navigation>li:hover>a::after,
					.header-sidebar .main-navigation>li:focus>a::after,
					.header-sidebar .main-navigation>li.current-menu-item>a::after,
					.header-sidebar .main-navigation>li.current-menu-item>a:hover::after,
					.header-sidebar .main-navigation>li.current-menu-parent>a::after,
					.header-sidebar .main-navigation>li.current-menu-parent>a:hover::after {
						background-color: {$nav_active_line};
					}
					
					.header-sidebar .main-navigation>li>.sub-menu li a {
						color: {$nav_submenu_textcolor_sidebar};
						background-color: {$nav_submenu_bgcolor_sidebar};
					}

					.header-sidebar .main-navigation>li>.sub-menu li:hover > a {
						color: {$nav_submenu_textcolor_adjust_sidebar};
						background-color: {$nav_submenu_bgcolor_adjust_sidebar};
						border-bottom-color: {$nav_submenu_bgcolor_adjust_sidebar};
					}
				}
			";
		}


		// Page Header
		$thelandscaper_style .= "
			.page-header {
				text-align: {$maintitle_align};
				background-color: {$maintitle_bgcolor};
				background-image: url('{$maintitle_bgimage}');
			}

			.page-header .main-title { color: {$maintitle_color}; }
			.page-header .sub-title { color: {$subtitle_color}; }
		";


		// Breadcrumbs
		$thelandscaper_style .= "
			.breadcrumbs {
				text-align: {$breadcrumbs_align};
				background-color: {$breadcrumbs_bg_color};
			}

			.breadcrumbs a { color: {$breadcrumbs_textcolor}; }
			.breadcrumbs a:hover { color: {$breadcrumbs_text_hover}; }
			.breadcrumbs span>span { color: {$breadcrumbs_activecolor}; }
		";


		// Theme Colors -- Primary 
		$thelandscaper_style .= "
			a,
			.dropcap,
			.post-item .title > a:hover,
			.testimonials .testimonial .author-location,
			.post .post-left-meta .box.date .day,
			.post .post-title a:hover,
			.w-footer .icon-box .fa,
			.content .icon-box .fa,
			.opening-times ul li.today,
			.wpcf7 span,
			.testimonials .testimonial-person .testimonial-location,
			.panel-group .accordion-toggle:hover,
			.panel-group .accordion-toggle::before { 
				color: {$theme_primary_color};
			}

			.jumbotron.carousel .carousel-topheading { color: {$theme_primary_color_adjust_light}; }
		";

		$thelandscaper_style .= "
			.w-footer .icon-box:hover .fa,
			.content .icon-box:hover .fa,
			a:hover,
			a:focus,
			a:active { color: {$theme_primary_color_adjust}; }
		";

		$thelandscaper_style .= "
			.counter.count-box .count-icon .fa,
			.carousel-indicators li.active,
			.qt-table thead td,
			.opening-times ul span.right.label,
			.social-icons a { background-color: {$theme_primary_color}; }
		";

		$thelandscaper_style .= "
			.client-logos img:hover,
			.cta-button:hover,
			.brochure-box:hover,
			.wpcf7-text:focus,
			.wpcf7-textarea:focus,
			.comment-form .comment-form-author input:focus,
			.comment-form .comment-form-email input:focus,
			.comment-form .comment-form-url input:focus,
			.comment-form .comment-form-comment textarea:focus { border-color: {$theme_primary_color}; }
		";

		$thelandscaper_style .= "
			.counter.count-box .count-icon .fa::after { 
				border-top-color: {$theme_primary_color};
			}

			.counter.count-box:hover .count-icon .fa { 
				background-color: {$theme_primary_color_adjust};
			}
			.counter.count-box:hover .count-icon .fa::after { 
				border-top-color: {$theme_primary_color_adjust};
			}
		";


		// Theme Colors -- Button Background
		$thelandscaper_style .= "
			.btn-primary,
			.btn-primary:active,
			.btn-primary:focus,
			.btn-primary:active:focus,
			.btn-primary:hover,
			.wpcf7-submit,
			span.wpcf7-list-item,
			button,
			.navbar-toggle,
			input[type='button'],
			input[type='reset'],
			input[type='submit'],
			.jumbotron .carousel-indicators li.active,
			.post-item .vertical-center span,
			.post-item .label-wrap .label,
			.testimonials .testimonial-control,
			.testimonials .testimonial-control:first-of-type::before,
			.testimonials .testimonial-control:last-of-type::before,
			.cta-button,
			.brochure-box,
			.project-navigation a,
			.pagination a.current,
			.pagination span.current,
			.sidebar .widget.widget_nav_menu .menu li.current-menu-item a,
			.sidebar .widget.widget_nav_menu .menu li a:hover,
			.content .widget.widget_nav_menu .menu li.current-menu-item a,
			.content .widget.widget_nav_menu .menu li a:hover,
			.panel-group .panel .panel-heading .accordion-toggle[aria-expanded=".'"true"'."] { 
				background-color: {$theme_btn_color};
				color: {$theme_btn_textcolor};
			}
		";


		// Button Background Hover
		$thelandscaper_style .= "
			.btn-primary:hover,
			.wpcf7-submit:hover,
			span.wpcf7-list-item:hover,
			button:hover,
			input[type='button']:hover,
			input[type='reset']:hover,
			input[type='submit']:hover,
			.post-item .vertical-center span:hover,
			.post-item .label-wrap .label:hover,
			.testimonials .testimonial-control:hover,
			.testimonials .testimonial-control:first-of-type:hover::before,
			.testimonials .testimonial-control:last-of-type:hover::before,
			.project-navigation a:hover,
			.pagination a:hover,
			.project-navigation a:focus { 
				background-color: {$theme_btn_color_adjust};
				color: {$theme_btn_textcolor};
			}
		";


		$thelandscaper_style .= "
			.post-item .label-wrap .label::after {
				border-top-color: {$theme_btn_color};
			}

			.pagination a:hover,
			span.wpcf7-list-item {
				border-color: {$theme_btn_color_adjust};
			}
		";


		$thelandscaper_style .= "
			.post-item .label-wrap .label:hover::after {
				border-top-color: {$theme_btn_color_adjust};
			}
		";


		// Theme Colors -- Text Color
		$thelandscaper_style .= "
			body, .content a.icon-box .subtitle {
				color: {$theme_textcolor};
			}
		";


		// Theme Colors -- Widget Title Color
		$thelandscaper_style .= "
			.widget-title {
				color: {$widget_title_color};
			}
		";


		// Theme Colors -- First Span Widget Title Color
		$thelandscaper_style .= "
			.content .widget-title span.light {
				color: {$widget_title_span_color};
			}
		";


		// Theme Colors -- Theme Borders
		$thelandscaper_style .= "
			.content .widget-title, .custom-title, 
			.project-navigation, 
			.post-meta-data {
				border-style: {$widget_border_style};
			}
		";


		// Slider
		if ( $slider_small_heading_color != '' ) {
			$thelandscaper_style .= "
				.jumbotron.carousel .carousel-topheading {
					color: {$slider_small_heading_color};
				}
			";
		}

		if ( $slider_heading_color != '' ) {
			$thelandscaper_style .= "
				.jumbotron.carousel .carousel-text h1 {
					color: {$slider_heading_color};
				}
			";
		}

		if ( $slider_content_color != '' ) {
			$thelandscaper_style .= "
				.jumbotron.carousel .carousel-text p {
					color: {$slider_content_color};
				}
			";
		}

		if ( $slider_primary_button_color != '' || $slider_primary_button_background_color != '' ) {
			$thelandscaper_style .= "
				.jumbotron.carousel .carousel-text .btn.btn-primary {
					color: {$slider_primary_button_color};
					background-color: {$slider_primary_button_background_color};
				}
			";
		}

		if ( $slider_control_color != '' || $slider_control_background_color != '' ) {
			$thelandscaper_style .= "
				.jumbotron .carousel-control {
					color: {$slider_control_color};
					background-color: {$slider_control_background_color};
				}
				.jumbotron .carousel-control:hover {
					background-color: {$slider_control_background_color};
				}
			";
		}

		if ( $slider_mobile_background_color != '' ) {
			$thelandscaper_style .= "
				@media(max-width: 992px) {
					.jumbotron .item {
						background-color: {$slider_mobile_background_color};
					}
				}
			";
		}


		// Essential Grid
		if ( class_exists( 'Essential_Grid' ) ) {

			if( 'enable' === get_theme_mod( 'qt_default_esg_style', 'enable' ) ) {

				// gallery homepage grid
				$thelandscaper_style .= "
					body .the-landscaper-home .eg-the-landscaper-home-element-2,
					body .the-landscaper-home .eg-the-landscaper-home-element-4,
					body .the-landscaper .esg-filterbutton,
					body .the-landscaper .esg-sortbutton,
					body .the-landscaper .esg-cartbutton {
						font-family: {$theme_primary_font};
					}
					body .the-landscaper-home .eg-the-landscaper-home-element-0 {
						font-family: {$theme_secondary_font};
					}
					body .the-landscaper-home .eg-the-landscaper-home-element-2 {
						background-color: {$theme_primary_color};
					}
					body .the-landscaper-home .eg-the-landscaper-home-element-2:hover {
						background-color: {$theme_primary_color_adjust};
					}
					body .the-landscaper-home .eg-the-landscaper-home-element-4 {
						color: {$theme_primary_color};
					}
					body .the-landscaper-home .esg-navigationbutton {
						background-color: {$theme_primary_color};
					}
					body .the-landscaper-home .esg-navigationbutton:hover {
						background-color: {$theme_primary_color_adjust};
					}
					body .the-landscaper-home .esg-navigationbutton.esg-left::before {
						border-color: {$theme_primary_color} transparent transparent transparent;
					}
					body .the-landscaper-home .esg-navigationbutton.esg-right:before {
						border-color: transparent transparent {$theme_primary_color}; transparent;
					}
					body .the-landscaper-home .esg-navigationbutton:hover.esg-left::before {
						border-color: {$theme_primary_color_adjust} transparent transparent transparent;
					}
					body .the-landscaper-home .esg-navigationbutton:hover.esg-right:before {
						border-color: transparent transparent {$theme_primary_color_adjust} transparent;
					}
				";

				// gallery pages grid
				$thelandscaper_style .= "				
					body .the-landscaper .eg-the-landscaper-element-30 {
						background-color: {$theme_primary_color};
					}
					body .the-landscaper .eg-the-landscaper-element-30:hover {
						background-color: {$theme_primary_color_adjust};
					}
				";

				// gallery lightbox grid
				$thelandscaper_style .= "
					body .the-landscaper .eg-the-landscaper-lightbox-element-31 {
						background-color: {$theme_primary_color};
					}
					body .the-landscaper .eg-the-landscaper-lightbox-element-31:hover {
						background-color: {$theme_primary_color_adjust};
					}
				";

				// overall styles grid
				$thelandscaper_style .= "
					body .the-landscaper .esg-filterbutton.selected,
					body .the-landscaper .esg-filterbutton:hover {
						border-color: {$theme_primary_color};
						background-color: {$theme_primary_color};
					}
					body .the-landscaper .eg-the-landscaper-element-24 {
						font-family: {$theme_secondary_font};
					}
				";
			}
		}


		// WooCommerce
		if ( thelandscaper_woocommerce_active() ) {

			$thelandscaper_style .= "
				.woocommerce-page div.product p.price,
				.woocommerce div.product .star-rating span::before,
				.woocommerce ul.products li.product .woocommerce-loop-category__title:hover,
				.woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
				.woocommerce ul.products li.product.product h3:hover,
				body.woocommerce-page .woocommerce-error:before,
				body.woocommerce-page .woocommerce-info:before,
				body.woocommerce-page .woocommerce-message:before {
					color: {$theme_primary_color};
				}
			
				.woocommerce div.product div.images img:hover,
				.woocommerce ul.products li.product a:hover img { 
					outline-color: {$theme_primary_color};
				}

				.woocommerce nav.woocommerce-pagination ul li span.current {
					border-color: {$theme_btn_color};
				}

				.woocommerce .widget_product_categories .product-categories li a { 
					border-color: {$theme_primary_color_adjust};
				}

				.woocommerce-MyAccount-navigation ul li.is-active a,
				.woocommerce-MyAccount-navigation ul li a:hover {
					background-color: {$theme_primary_color};
				}
			
				.woocommerce a.button,
				.woocommerce input.button,
				.woocommerce input.button.alt,
				.woocommerce button.button,
				.woocommerce #respond input#submit,
				.woocommerce span.onsale,
				.woocommerce ul.products li.product .onsale,
				.woocommerce nav.woocommerce-pagination ul li span.current,
				.woocommerce-page div.product form.cart .button.single_add_to_cart_button,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce .widget_product_categories .product-categories li a { 
					background-color: {$theme_btn_color};
					color: {$theme_btn_textcolor};
				}
			
				.woocommerce a.button:hover,
				.woocommerce input.button:hover,
				.woocommerce input.button.alt:hover,
				.woocommerce button.button:hover,
				.woocommerce span.onsale:hover,
				.woocommerce ul.products li.product .onsale:hover, 
				.woocommerce-page div.product form.cart .button.single_add_to_cart_button:hover,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
				.woocommerce nav.woocommerce-pagination ul li a:hover,
				.woocommerce nav.woocommerce-pagination ul li a:focus,
				.woocommerce div.product .woocommerce-tabs ul.tabs li:hover,
				body.woocommerce-page .woocommerce-error a.button:hover,
				body.woocommerce-page .woocommerce-info a.button:hover,
				body.woocommerce-page .woocommerce-message a.button:hover,
				.woocommerce .widget_product_categories .product-categories li a:hover { 
					background-color: {$theme_btn_color_adjust};
					color: {$theme_btn_textcolor};
				}
			
				.woocommerce nav.woocommerce-pagination ul li a:hover,
				.woocommerce nav.woocommerce-pagination ul li a:focus,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce div.product .woocommerce-tabs ul.tabs li:hover,
				.woocommerce .widget_product_categories .product-categories li a { 
					border-color: {$theme_btn_color_adjust};
				}

				.woocommerce-page .product .summary.entry-summary p.price,
				.pagination, .woocommerce-pagination { 
					border-style: {$widget_border_style};
				}
			";
		}


		// Footer
		$thelandscaper_style .= "
			.main-footer { background-color: {$footer_bg }; background-image: url('{$footer_bgimage}'); }
			.main-footer, .main-footer p, .main-footer .widget_nav_menu ul>li>a { color: {$footer_textcolor}; }
			.footer .widget-title { color: {$footer_widget_title}; }
			.bottom-footer { background-color: {$footer_bottom_bg}; }
			.bottom-footer p { color: {$footer_bottom_textcolor}; }
			.bottom-footer a { color: {$footer_bottom_linkcolor}; }
			.bottom-footer a:hover { color: {$footer_bottom_linkcolor_adjust}; }
		";


		// Boxed Layout
		$thelandscaper_style .= "
			.layout-boxed { background-color: {$boxed_bg}; };
		";

		return str_replace( array( "\r", "\n", "\t" ), '', $thelandscaper_style );
	}

	/**
	 * Callback for 'wp_head' that outputs the CSS for this feature.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function thelandscaper_head_callback() {

		$thelandscaper_style = $this->thelandscaper_get_primary_styles();
		$thelandscaper_style = '<style id="customizer-css" type="text/css">'. trim( $thelandscaper_style ) .'</style>' . PHP_EOL;

		// Output the customizer styles 
		// Already sanitzed from the customizer settings callback
		echo $thelandscaper_style;

		// Get the custom CSS field
		$custom_css = get_theme_mod( 'qt_custom_css', '' );

		if ( strlen( $custom_css ) ) {
			$custom_css = '<style id="custom-css" type="text/css">'. trim( $custom_css ) .'</style>' . PHP_EOL;
			echo wp_kses( $custom_css, array( 'style' => array( 'type' => array(), 'id' => array() ) ) );
		}

		// Add wp inline style
		wp_add_inline_style( 'custom-css', 'thelandscaper_customizer_css', 30 );
	}

	/**
	 * Callback for 'wp_head' that outputs the JavaScript for this feature.
	 *
	 * @since  1.3
	 * @return void
	 */
	public function thelandscaper_head_js() {

		$header_js = get_theme_mod( 'qt_custom_head_js', '' );

		if ( $header_js !== '' ) { echo $header_js; }
	}

	/**
	 * Callback for 'wp_foot' that outputs the JavaScript for this feature.
	 *
	 * @since  1.3
	 * @return void
	 */
	public function thelandscaper_foot_js() {

		$footer_js = get_theme_mod( 'qt_custom_foot_js', '' );

		if ( $footer_js !== '' ) { echo $footer_js; }
	}

	/**
	 * Deletes the cached style CSS that's output into the header.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function thelandscaper_cache_delete() {
		wp_cache_delete( get_stylesheet() . '_custom_colors' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function thelandscaper_instance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* Also keep in mind that this function isn't necessary unless your settings 
	* are using 'transport'=>'postMessage' instead of the default 'transport'
	* => 'refresh'
	* 
	* Used by hook: 'customize_preview_init'
	* 
	* @see add_action('customize_preview_init',$func)
	* @since Version 1.0
	*/
	public function thelandscaper_live_preview() {
		wp_enqueue_script( 'thelandscaper-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '', true );
	}

	/**
	 * Active Callbacks for customizer settings
	 */

	// Returns if blog share buttons are set to display
	public function thelandscaper_hide_social_input_fields() {

		if ( 'hide' === get_theme_mod( 'qt_blog_share', 'hide' ) ) {
			return false;
		}
		else {
			return true;
		}
	}

	// Returns if header layout isset to default or wide
	public function thelandscaper_show_settings_header_default() {

		if ( 'default' === get_theme_mod( 'qt_nav_layout', 'default' ) || 'wide' === get_theme_mod( 'qt_nav_layout', 'default' )  ) {
			return true;
		}
		else {
			return false;
		}
	}

	// Returns if header layout isset to sidebar
	public function thelandscaper_show_settings_header_sidebar() {

		if ( 'sidebar' === get_theme_mod( 'qt_nav_layout', 'default' )  ) {
			return true;
		}
		else {
			return false;
		}
	}

	// Returns if header layout isset to sidebar
	public function thelandscaper_show_settings_header_transparent() {

		if ( 'transparent' === get_theme_mod( 'qt_nav_layout', 'default' )  ) {
			return true;
		}
		else {
			return false;
		}
	}

	// Return the sticky nav option for default, wide and transparent header layout
	public function thelandscaper_show_setting_sticky_nav() {

		if ( 'default' === get_theme_mod( 'qt_nav_layout', 'default' ) || 'wide' === get_theme_mod( 'qt_nav_layout', 'default') || 'transparent' === get_theme_mod( 'qt_nav_layout', 'default' )  ) {
			return true;
		}
		else {
			return false;
		}
	}

	// Return the background color option for sticky nav on transparent header layout if nav isset to sticky
	public function thelandscaper_show_setting_stickynav_background() {

		if ( 'transparent' === get_theme_mod( 'qt_nav_layout', 'default' ) && 'sticky' === get_theme_mod( 'qt_nav_position', 'static' ) ) {
			return true;
		}
		else {
			return false;
		}
	}

	// Return options if gallery navigation isset to show
	public function thelandscaper_show_setting_gallery_nav() {

		if ( 'hide' === get_theme_mod( 'qt_gallery_nav', 'hide' ) ) {
			return false;
		}
		else {
			return true;
		}
	}

	// Return option if custom heading sizes isset to yes
	public function thelandscaper_show_custom_heading_sizes() {

		if ( 'yes' === get_theme_mod( 'qt_theme_custom_heading_sizes', 'yes' ) ) {
			return true;
		}
		else {
			return false;
		}
	}
}


/**
 * Adds sanitization callback function: select
 */
if( ! function_exists( 'thelandscaper_sanitize_select' ) ) {
	function thelandscaper_sanitize_select( $input, $setting ) {
		// Ensure input is a slug
		$input = sanitize_key( $input );
		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;
		// If the input is a valid key, return it;
		// otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Adds sanitization callback function: text
 */
if( ! function_exists( 'thelandscaper_sanitize_text' ) ) {
	function thelandscaper_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
}

/**
 * Adds sanitization callback function: textarea
 */
if( ! function_exists( 'thelandscaper_sanitize_textarea' ) ) {
	function thelandscaper_sanitize_textarea( $input ) {
	    return esc_textarea( $input );
	}
}

/**
 * Adds sanitization callback function: js code
 */
if( ! function_exists( 'thelandscaper_sanitize_js' ) ) {
	function thelandscaper_sanitize_js ( $input ) {
		return $input;
	}
}

/**
 * Adds sanitization callback function: gallery slug
 */
if( ! function_exists( 'thelandscaper_sanitize_gallery_slug' ) ) {
	function thelandscaper_sanitize_gallery_slug( $slug ) {
		$slug = trim( $slug );
		return sanitize_title( $slug, 'gallery' );
	}
}

TheLandscaper_Customizer::thelandscaper_instance();