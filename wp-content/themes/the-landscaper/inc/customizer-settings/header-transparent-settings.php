<?php

/* Topbar settings for transparent header layout */
$wp_customize->add_setting( 'qt_topbar_bg_transparent', array(
	'default' 				=> '#3a3a3a',
    'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_topbar_bg_transparent', array(
	'label'       			=> esc_html__( 'Mobile background color', 'the-landscaper-wp' ),
	'description' 			=> esc_html__( 'Change the background color of the header', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_header',
	'settings'    			=> 'qt_topbar_bg_transparent',
	'priority'    			=> 74,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_gradient_bg_transparent', array(
	'default' 				=> '#3a3a3a',
    'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_gradient_bg_transparent', array(
	'label'       			=> esc_html__( 'Background color', 'the-landscaper-wp' ),
	'description' 			=> esc_html__( 'Change the background color of the header', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_header',
	'settings'    			=> 'qt_gradient_bg_transparent',
	'priority'    			=> 75,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_gradient_bg_transparent_opacity', array(
	'default' 				=> '0.5',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
) );
$wp_customize->add_control( 'qt_gradient_bg_transparent_opacity', array(
    'label' 				=> esc_html__( 'Header background opacity', 'the-landscaper-wp' ),
    'description' 			=> esc_html__( 'Define a value between 0 and 1, e.g. 0.5', 'the-landscaper-wp' ),
	'type'		       	 	=> 'number',
    'section' 				=> 'qt_section_header',
    'settings' 				=> 'qt_gradient_bg_transparent_opacity',
    'priority' 				=> 76,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) );

$wp_customize->add_setting( 'qt_topbar_textcolor_transparent', array(
    'default'     			=> '#7d7d7d',
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color'
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_topbar_textcolor_transparent', array(
	'label' 				=> esc_html__( 'Topbar text color', 'the-landscaper-wp' ),
	'description' 			=> esc_html__( 'Change the text color of topbar', 'the-landscaper-wp' ),
	'section' 				=> 'qt_section_header',
	'settings' 				=> 'qt_topbar_textcolor_transparent',
	'priority' 				=> 77,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );


/* Navigation settings for transparent header layout */
$wp_customize->add_setting( 'qt_nav_stickynav_bg_transparent', array(
    'default'    			=> '#000000',
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_stickynav_bg_transparent', array(
	'label'      			=> esc_html__( 'Sticky background color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the background color of the sticky navigation', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_stickynav_bg_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_setting_stickynav_background' ),
) ) );

$wp_customize->add_setting( 'qt_nav_stickynav_bg_transparent_opacity', 
	array(
	'default' 				=> '0.5',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'thelandscaper_sanitize_text',
) );
$wp_customize->add_control( 'qt_nav_stickynav_bg_transparent_opacity', array(
    'label' 				=> esc_html__( 'Sticky background opacity', 'the-landscaper-wp' ),
    'description' 			=> esc_html__( 'Add a value between 0 and 1, e.g. 0.5', 'the-landscaper-wp' ),
	'type'		       	 	=> 'number',
    'section' 				=> 'qt_section_navigation',
    'settings' 				=> 'qt_nav_stickynav_bg_transparent_opacity',
	'active_callback' 		=> array( $this, 'thelandscaper_show_setting_stickynav_background' ),
) );

$wp_customize->add_setting( 'qt_nav_textcolor_transparent', array(
    'default'    			=> '#ffffff',
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_textcolor_transparent', array(
	'label'      			=> esc_html__( 'Link color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the color of the parent links', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_textcolor_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_nav_textcolor_hover_transparent', array(
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_textcolor_hover_transparent', array(
	'label'      			=> esc_html__( 'Link hover color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the hover color of the parent links', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_textcolor_hover_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_nav_submenu_bg_transparent', array(
	'default' 				=> '#434343',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_submenu_bg_transparent', array(
	'label'       			=> esc_html__( 'Submenu background color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the background color of the submenu\'s', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_submenu_bg_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_nav_submenu_textcolor_transparent', array(
	'default'     			=> '#999999',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_submenu_textcolor_transparent', array(
	'label'       			=> esc_html__( 'Submenu link color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the link color of the submenu\'s', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_submenu_textcolor_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );

$wp_customize->add_setting( 'qt_nav_submenu_topline_transparent', array(
	'default'     			=> '#a2c046',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_submenu_topline_transparent', array(
	'label'       			=> esc_html__( 'Submenu top border color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the top border color of the submenu\'s', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_submenu_topline_transparent',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_transparent' ),
) ) );