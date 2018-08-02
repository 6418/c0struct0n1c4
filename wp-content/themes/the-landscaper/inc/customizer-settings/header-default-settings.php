<?php

/* Topbar settings for default header layout */
$wp_customize->add_setting( 'qt_topbar_bg', array( 
	'default' 				=> '#3a3a3a',
    'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_topbar_bg', array(
	'label'       			=> esc_html__( 'Topbar background color', 'the-landscaper-wp' ),
	'description' 			=> esc_html__( 'Change the background color of the topbar', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_header',
	'settings'    			=> 'qt_topbar_bg',
	'priority'    			=> 15,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_topbar_textcolor', array(
    'default'     			=> '#7d7d7d',
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color'
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_topbar_textcolor', array(
	'label' 				=> esc_html__( 'Topbar text color', 'the-landscaper-wp' ),
	'description' 			=> esc_html__( 'Change the text color of the topbar', 'the-landscaper-wp' ),
	'section' 				=> 'qt_section_header',
	'settings' 				=> 'qt_topbar_textcolor',
	'priority' 				=> 20,
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

/* Navigation settings for default header layout */
$wp_customize->add_setting( 'qt_nav_position', array(
	'default'  				=> 'static',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'thelandscaper_sanitize_select',
) );
$wp_customize->add_control( 'qt_nav_position', array(
	'label'    				=> esc_html__( 'Sticky navigation', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Enable the sticky navigation', 'the-landscaper-wp' ),
	'section'  				=> 'qt_section_navigation',
	'settings' 				=> 'qt_nav_position',
	'type'     				=> 'select',
	'choices'  				=> array(
		'static'  			=> esc_html__( 'Static', 'the-landscaper-wp' ),
		'sticky' 			=> esc_html__( 'Sticky', 'the-landscaper-wp' ),
	),
	'active_callback' 		=> array( $this, 'thelandscaper_show_setting_sticky_nav' ),
) );

$wp_customize->add_setting( 'qt_nav_bg', array(
	'default' 				=> '#a2c046',
	'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_bg', array(
	'label'         		=> esc_html__( 'Background color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the navigation background color', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_bg',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_nav_bg_full', array(
	'default' 				=> '#ffffff',
	'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_bg_full', array(
	'label'           		=> esc_html__( 'Left side background color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the left side navigation background color', 'the-landscaper-wp' ),
	'section'     	  		=> 'qt_section_navigation',
	'settings'    	  		=> 'qt_nav_bg_full',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_nav_textcolor', array(
    'default'    			=> '#ffffff',
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_textcolor', array(
	'label'      			=> esc_html__( 'Link color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the color of the parent links', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_textcolor',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_nav_textcolor_hover', array(
    'transport'				=> 'refresh',
    'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_textcolor_hover', array(
	'label'      			=> esc_html__( 'Link hover color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the hover color of the parent links', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_textcolor_hover',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_nav_submenu_bg', array(
	'default' 				=> '#434343',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_submenu_bg', array(
	'label'       			=> esc_html__( 'Submenu background color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the background color of the submenu\'s', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_submenu_bg',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );

$wp_customize->add_setting( 'qt_nav_submenu_textcolor', array(
	'default'     			=> '#999999',
	'transport'				=> 'refresh',
	'sanitize_callback' 	=> 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qt_nav_submenu_textcolor', array(
	'label'       			=> esc_html__( 'Submenu link color', 'the-landscaper-wp' ),
	'description'			=> esc_html__( 'Change the link color of the submenu\'s', 'the-landscaper-wp' ),
	'section'     			=> 'qt_section_navigation',
	'settings'    			=> 'qt_nav_submenu_textcolor',
	'active_callback' 		=> array( $this, 'thelandscaper_show_settings_header_default' ),
) ) );