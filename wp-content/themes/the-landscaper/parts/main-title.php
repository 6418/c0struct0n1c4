<?php
/**
 * Main Title Template Part
 *
 * @package The Landscaper
 */

$header_attr = '';
$headtag = 'h1';

// Get the page ID
$get_id = thelandscaper_get_correct_page_id();

// Page title settings
$title_style_array = array(
	'color'	=> get_field( 'page_title_color', $get_id ),
);
$title_attr = thelandscaper_header_array( $title_style_array );

// Sub title settings
$subtitle_style_array = array(
	'color'	=> get_field( 'sub_title_color', $get_id ),
);
$subtitle_attr = thelandscaper_header_array( $subtitle_style_array );

// Page header settings
$header_attr = array();

if ( get_field( 'header_bgimage', $get_id ) ) {
	$header_attr = array(
		'background-image'      => get_field( 'header_bgimage', $get_id ),
		'background-position'   => get_field( 'header_bg_horizontal', $get_id ) . ' ' . get_field( 'header_bg_vertical', $get_id ),
		'background-size'       => get_field( 'header_bgsize', $get_id ),
		'background-attachment' => get_field( 'header_bgattachment', $get_id ),
	);
}

if ( 'header-custom' === get_field( 'page_title_area', $get_id ) ) {
	$header_attr['padding-top'] = get_field( 'page_area_padding_top', $get_id ) . 'px';
	$header_attr['padding-bottom'] = get_field( 'page_area_padding_bottom', $get_id ) . 'px';
}

$header_attr['text-align'] = get_field( 'header_text_align', $get_id );
$header_attr['background-color'] = get_field( 'header_bgcolor', $get_id );

$style_attr = thelandscaper_header_array( $header_attr );

// If main title isset in page setting to large, or in theme customizer add 'header-large' class
if ( 'large' === get_theme_mod( 'qt_maintitle_layout', 'small' ) ) {

	$title_layout = ' header-large';
	
	if ( 'header-small' === get_field( 'page_title_area', $get_id ) ) {
		$title_layout = '';
	}

} elseif ( 'small' === get_theme_mod( 'qt_maintitle_layout', 'small' ) ) {

	$title_layout = '';
	
	if ( 'header-large' === get_field( 'page_title_area', $get_id ) ) { 
		$title_layout = ' header-large';
	}
} ?>

<?php if ( 'hide' !== get_theme_mod( 'qt_maintitle_layout' ) && 'header-hide' !== get_field( 'page_title_area', $get_id ) ) { ?>
	<div class="page-header<?php echo esc_attr( $title_layout ); ?>" <?php echo wp_kses_post( $style_attr ); ?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">

					<?php
						$subtitle = '';

						if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
							
							$title = get_the_title( $get_id );
							$subtitle = get_field( 'subtitle', $get_id );

							if ( is_single() ) {
								$headtag = 'h2';
							}

						} elseif ( thelandscaper_woocommerce_active() && is_woocommerce() ) {
							
							ob_start();
						 	woocommerce_page_title();
						 	$title = ob_get_clean();
						 	$subtitle = get_field( 'subtitle', (int) get_option( 'woocommerce_shop_page_id' ) );

						} elseif ( is_category() || is_tag() || is_author() || is_year() || is_month() || is_day() || is_tax() ) {
							
							$title = get_the_archive_title();

						} elseif ( 'portfolio' == get_post_type() ) {
							
							// Page Title for gallery post
							if ( 'custom_title' === get_theme_mod( 'qt_gallery_title', 'custom_title' ) ) {
								$title = get_theme_mod( 'qt_gallery_maintitle', 'Gallery' );
								$headtag = 'h2';
							} else {
								$title = get_the_title();
								$headtag = 'h1';
							}

							// Subtitle for gallery post
							if ( get_field( 'subtitle', $get_id ) != '' ) {
								$subtitle = get_field( 'subtitle', $get_id );
							} else {
								$subtitle = get_theme_mod( 'qt_gallery_subtitle', 'A selection of our best work' );
							}

						} elseif ( is_search() ) {
							
							$title = esc_html__( 'Search Results For', 'the-landscaper-wp' ) . ' &quot;' . get_search_query() . '&quot;';

						} elseif ( is_404() ) {
							
							$title = esc_html__( 'Error 404', 'the-landscaper-wp' );

						} else {
							
							$title = get_the_title();
							$subtitle = get_field( 'subtitle' );
						}
					?>

					<?php if ( 'hide' !== get_field( 'display_page_title', $get_id ) ) { ?>
						<<?php echo esc_html( $headtag ); ?> class="main-title"<?php echo wp_kses_post( $title_attr ); ?>><?php echo wp_kses_post( $title ); ?></<?php echo esc_html( $headtag ); ?>>
					<?php } ?>

					<?php if ( $subtitle ) { ?>
						<h3 class="sub-title"<?php echo wp_kses_post( $subtitle_attr ); ?>><?php echo wp_kses_post( $subtitle ); ?></h3>
					<?php } ?>

				</div>

			</div>
		</div>
	</div>
<?php } ?>

<?php if ( 'hide' !== get_theme_mod( 'qt_breadcrumbs', 'show' ) && 'hide' !== get_field( 'display_breadcrumbs', $get_id ) ) {
	get_template_part( 'parts/breadcrumbs' );
} ?>

<?php if ( 'header-hide' === get_field( 'page_title_area', $get_id ) && 'hide' === get_field( 'display_breadcrumbs', $get_id ) ) { ?>
	<div class="content-spacer"></div>
<?php } ?>