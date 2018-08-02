<?php
/**
 * Single Post Template for the gallery/portfolio post type
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );
?>

<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12">
				
				<article <?php post_class( 'post-inner' ); ?>>

					<?php if ( 'custom_title' === get_theme_mod( 'qt_gallery_title', 'custom_title' ) ) : ?>
						<h1 class="widget-title"><?php the_title(); ?></h1>
					<?php endif; ?>

					<?php if( get_field( 'gallery_layout' ) === 'split' ) : ?>
						<?php get_template_part( 'parts/project-split' ); ?>
					<?php else : ?>
						<?php get_template_part( 'parts/project-fullwidth' ); ?>
					<?php endif; ?>

					<?php
						// Check if share buttons options isset
						if ( 'galleries' == get_theme_mod( 'qt_blog_share', 'blog' ) || 'show' == get_theme_mod( 'qt_blog_share', 'blog' ) ) :
							get_template_part( 'parts/share-buttons' );
						endif; 
					?>
				</article>

			</main>
		</div>
	</div>

	<?php if ( 'hide' !== get_theme_mod( 'qt_gallery_nav', 'show' ) ) : ?>
		<nav class="project-navigation">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php previous_post_link( '%link', '<i class="fa fa-caret-left"></i> ' . get_theme_mod( 'qt_gallery_prevtext', 'Previous' ) ); ?>

						<?php if( get_theme_mod( 'qt_gallery_summarytext' ) ) : ?>
							<a href="<?php echo esc_url( get_theme_mod( 'qt_gallery_summarylink' ) ); ?>" class="summary"><?php echo wp_kses_post( get_theme_mod( 'qt_gallery_summarytext' ) ); ?></a>
						<?php endif; ?>
						
						<?php next_post_link( '%link', get_theme_mod( 'qt_gallery_nexttext', 'Next' ) . ' <i class="fa fa-caret-right"></i>' );?>
					</div>
				</div>
			</div>
		</nav>
	<?php endif; ?>

</div>

<?php get_footer(); ?>