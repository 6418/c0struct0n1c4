<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// 404 Page customizer settings
$error_logo = get_theme_mod( 'qt_404_page_image', false );
$error_text_title = get_theme_mod( 'qt_404_page_text_title', 'Oops! That page can\'t be found' );
$error_text = get_theme_mod( 'qt_404_page_text', 'Nothing was found here, try a search below' );
$error_search = get_theme_mod( 'qt_404_page_search', 'show' );
?>

<div class="content">
	<main class="container">
		<div class="row">
			<div class="col-xs-12">
				
				<div class="text-404">
					<div class="404-image">
						<?php if ( ! empty( $error_logo ) ) : ?>
							<img src="<?php echo esc_url( $error_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $error_text_title ) ) : ?>
						<h1><?php echo wp_kses_post( $error_text_title); ?></h1>
					<?php endif; ?>

					<?php if ( ! empty( $error_text ) ) : ?>
						<p><?php echo wp_kses_post( $error_text ); ?></p>
					<?php endif; ?>
					
					<?php if ( 'show' === $error_search ) : ?>
						<?php get_search_form(); ?>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</main>
</div>

<?php get_footer(); ?>