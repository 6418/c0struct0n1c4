<?php
/**
 * The Landscaper Blog List Loop
 */
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<article <?php post_class( 'post-inner' ); ?>>
		<?php if ( 'show' === get_theme_mod( 'qt_blog_bigdate', 'show' ) ) : ?>
			<div class="post-left-meta">
				<?php if( is_sticky() ) : ?>
					<div class="box stickylabel">
						<span><i class="fa fa-bookmark"></i>Sticky</span>
					</div>
				<?php endif; ?>
				<div class="box date">
					<span class="day"><?php the_time( 'd' ); ?></span>
					<span class="month"><?php the_time( 'M' ); ?></span>
					<span class="year"><?php the_time( 'Y' ); ?></span>
				</div>
			</div>
		<?php endif; ?>
		<div class="post-content <?php echo 'show' === get_theme_mod( 'qt_blog_bigdate', 'show' ) ? '' : 'no-big-date';?>">
			<?php if( has_post_thumbnail() ) : ?>
				<a href="<?php esc_url( the_permalink() ); ?>">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>	
				</a>
			<?php endif; ?>
			<?php if ( 'show' === get_theme_mod( 'qt_blog_metadata', 'show' ) ) : ?>
				<div class="post-meta-data">
					<?php if ( 'show' != get_theme_mod( 'qt_blog_bigdate', 'show' ) ) : ?>
						<span class="date updated"><?php the_time( get_option( 'date_format' ) ); ?></span>
						<span class="round-divider"></span>
					<?php endif; ?>
					<?php if ( 'show' === get_theme_mod( 'qt_blog_commments', 'show' ) ) : ?>
						<span class="comments">
							<a href="<?php esc_url( comments_link() ); ?>"><?php echo esc_attr( get_comments_number() ); ?> <?php echo esc_html_e( 'Comments', 'the-landscaper-wp' ); ?></a>
						</span>
						<span class="round-divider"></span>
					<?php endif; ?>
					<span class="vcard author post-author"><span class="fn"><?php esc_html_e( 'By', 'the-landscaper-wp'); ?> <?php the_author(); ?></span></span>
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
			
			<h2 class="post-title entry-title">
				<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>

			<?php
				// get the custom excerpt length function
				echo thelandscaper_blog_grid_display_excerpt();
			?>
			
			<div class="clearfix"></div>
		</div>
	</article>
	
<?php endwhile; else : ?>

	<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp' ); ?></h3>

<?php endif; ?>