<?php
/**
 * Single Post Template ( Blog Posts )
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// Get the sidebar
$sidebar = get_field( 'display_sidebar' );
if ( ! $sidebar ) {
	$sidebar = 'Right';
}
?>

<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12<?php echo 'Left' === $sidebar ? ' col-md-9 col-md-push-3' : ''; echo 'Right' === $sidebar ? ' col-md-9' : ''; ?>">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article <?php post_class( 'post-inner' ); ?>>
						
						<?php if( has_post_thumbnail() ) : ?>
							<a href="<?php esc_url( the_permalink() ); ?>">
								<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>	
							</a>
						<?php endif; ?>
						
						<?php if ( 'show' === get_theme_mod( 'qt_blog_metadata', 'show' ) ) : ?>
							<div class="post-meta-data">
								<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>" class="date updated"><?php echo esc_attr( get_the_date( get_option( 'date_format' ) ) ); ?></time>
								<span class="round-divider"></span>
								<span class="comments">
									<a href="<?php esc_url( comments_link() ); ?>"><?php comments_number(); ?></a>
								</span>
								<span class="round-divider"></span>
								<span class="vcard author post-author"><?php esc_html_e( 'By', 'the-landscaper-wp' ); ?> <?php the_author(); ?></span>
								<?php if( has_category() ) : ?>
									<span class="round-divider"></span>
									<span class="category"><?php the_category( ', ' ); ?></span>
								<?php endif; ?>
								<?php if( has_tag() ) : ?>
									<span class="round-divider"></span>
									<span class="tags"><?php the_tags( ' ' ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<h1 class="post-title entry-title"><?php the_title(); ?></h1>
						
						<div class="post-content">
							<?php the_content(); ?>
						</div>

						<div class="clearfix"></div>

						<?php
							// Check if share buttons options isset
							if ( 'blog' == get_theme_mod( 'qt_blog_share', 'show' ) || 'show' == get_theme_mod( 'qt_blog_share', 'show' ) ) :
								get_template_part( 'parts/share-buttons' );
							endif; 
						?>

						<!-- Multi Page in One Post -->
						<?php
							$args = array(
								'before'      => '<div class="multi-page clearfix">' . /* translators: after that comes pagination like 1, 2, 3 ... 10 */ _x( 'Pages:' , 'frontend', 'the-landscaper-wp' ) . ' &nbsp; ',
								'after'       => '</div>',
								'link_before' => '<span class="btn btn-primary">',
								'link_after'  => '</span>',
								'echo'        => 1
							);
							wp_link_pages( $args );
						?>

						<?php if ( 'hide' !== get_theme_mod( 'qt_blog_commments', 'show' ) ) : ?>
							<?php comments_template(); ?>
						<?php endif; ?>
					</article>

				<?php endwhile; else : ?>

					<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp'); ?></h3>

				<?php endif; ?>
			</main>

			<?php if ( 'Hide' !== $sidebar ) : ?>
				<div class="col-xs-12 col-md-3 <?php echo 'Left' === $sidebar ? 'col-md-pull-9' : ''; ?>">
					<aside class="sidebar widget-area">
						<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
							<?php dynamic_sidebar( 'sidebar' ); ?>
						<?php endif; ?>
					</aside>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>