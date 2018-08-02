<?php
/**
 * Pagination Template Part
 *
 * @package The Landscaper
 */

// Get the gallery field images
$images = get_field( 'gallery_field' );

// Get the extra textfield position
$extra_textarea_position = get_field( 'extra_textarea_position' );

// Check if textfield position isset
if ( ! $extra_textarea_position ) { 
	$extra_textarea_position = 'below';
}

// Get the extra textfield area
$extra_textarea = get_field( 'extra_textarea' );

// Get the amount of columns
$columns = get_field( 'gallery_columns' );

// Get the gallery gap option
$gallery_gap = get_field( 'gallery_images_gap' );

// Check if gallery gap is empty
if ( ! $gallery_gap ) { 
	$gallery_gap = '15';
}
?>
	
<?php if ( 'above' === $extra_textarea_position && ! empty( $extra_textarea ) ) : ?>
	<div class="gallery-extra">
		<?php echo wp_kses_post( $extra_textarea ); ?>
		<div class="clearfix"></div>
	</div>
<?php endif; ?>

<?php if( $images ) : ?>
	<div class="gallery-field-wrapper">
		<div class="gallery-field gallery-columns-<?php echo esc_attr( $columns ); ?> gallery-gap-<?php echo esc_attr( $gallery_gap ); ?> clearfix">
			<?php foreach ( $images as $image ) :

				$slide_image_srcset = thelandscaper_srcset_sizes( $image['ID'], array( 'thelandscaper-project-images-s', 'thelandscaper-project-images-m', 'thelandscaper-project-images-l' ) ); ?>

				<div class="gallery-item">
					<a href="<?php echo esc_url( $image['url'] ); ?>" class="image">
						<?php if( $columns === '1' ) : ?> 
							<img src="<?php echo esc_url( $image['sizes']['thelandscaper-project-images'] ); ?>" srcset="<?php echo esc_html( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( get_sub_field( 'slide_heading' ) ); ?>">
						<?php else : ?>
							<img src="<?php echo esc_url( $image['sizes']['thelandscaper-project-images'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
						<?php endif; ?>
						<div class="overlay"></div>
					</a>
				</div>
				
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

<?php if ( 'below' === $extra_textarea_position && ! empty( $extra_textarea ) ) : ?>
	<div class="gallery-extra">
		<?php echo wp_kses_post( $extra_textarea ); ?>
		<div class="clearfix"></div>
	</div>
<?php endif; ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
	<div class="gallery-content">
		<?php the_content(); ?>
		<div class="clearfix"></div>
	</div>
<?php endwhile; endif; ?>

<div class="clearfix"></div>