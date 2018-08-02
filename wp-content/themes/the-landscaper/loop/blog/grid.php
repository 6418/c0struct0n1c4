<?php
/**
 * The Landscaper Blog Grid Loop
 */

// Get blog columns option
$grid_columns = get_field( 'blog_columns', (int) get_option( 'page_for_posts' ) );
?>

<div class="blog-grid" data-columns="<?php echo esc_attr( $grid_columns ); ?>">
	
	<?php $counter = 0; ?>
		<div class="row">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php $counter++; ?>
	
				<article <?php post_class( 'post-inner' ); ?>>
					<div class="post-item news">
						
						<?php if( has_post_thumbnail() ) : ?>
							<a href="<?php esc_url( the_permalink() ); ?>" class="post-item-image">
								<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>
								<?php if ( 'show' === get_theme_mod( 'qt_blog_metadata', 'show' ) ) : ?>
									<div class="label-wrap">
										<span class="label date updated"><?php the_time( get_option( 'date_format' ) ); ?></span>
										<span class="label comments"><?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'the-cleaner-qt' ), number_format_i18n( get_comments_number() ) ); ?></span>
										<?php if( is_sticky() ) : ?>
											<span class="label sticky"><?php esc_html_e( 'Sticky', 'the-landscaper-wp' ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</a>
						<?php endif; ?>
						
						<?php if ( 'show' === get_theme_mod( 'qt_blog_metadata', 'show' ) ) : ?>
							<div class="post-meta-data">
								<span class="vcard author post-author"><?php the_author(); ?></span>
								<?php if( has_category() ) : ?>
									<span class="round-divider"></span>
									<span class="category"><?php the_category( ', ' ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<div class="post-item-content">
							<h2 class="title">
								<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
							</h2>
							
							<?php
								// get the custom excerpt length function
								echo thelandscaper_blog_grid_display_excerpt();
							?>
							<div class="clearfix"></div>
						</div>
						
					</div>
				</article>

				<?php if ( $counter % $grid_columns == 0 ) : ?>
					</div>
					<div class="row">
				<?php endif; ?>

			<?php endwhile; else : ?>

				<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp' ); ?></h3>

		<?php endif; ?>

	</div>
</div>