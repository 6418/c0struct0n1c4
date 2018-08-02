<?php
/**
 * Frontpage Slider Template Part
 *
 * @package The Landscaper
 */

// Carousel touch support option
$carousel_touch = get_field( 'enable_touch_support' );
if ( $carousel_touch ) { 
    $carousel_touch = 'carousel-touch';
}

$carousel_pause_hover = get_field( 'pause_hover' );
if ( $carousel_pause_hover ) { 
    $carousel_pause_hover = 'carousel-pause-hover';
}

// Carousel slider animation
$carousel_animation = get_field( 'slide_animation' );
?>

<div class="jumbotron carousel slide <?php echo esc_attr( $carousel_touch ); ?> <?php echo esc_attr( $carousel_animation ); ?> <?php echo esc_attr( $carousel_pause_hover ); ?>" id="jumbotron-fullwidth" data-ride="carousel" <?php printf( 'data-interval="%s"', get_field( 'auto_cycle' ) ? get_field( 'slide_interval' ) : 'false' ); ?>>
    <div class="carousel-inner">

        <?php 
        // If only one slide is uploaded hide the controls
        $thelandscaper_count_slides = count( get_field( 'slide' ) );
        if ( $thelandscaper_count_slides > 1 ) : ?>
            <a class="carousel-control left" href="#jumbotron-fullwidth" role="button" data-slide="prev"><i class="fa fa-caret-left"></i></a>
            <a class="carousel-control right" href="#jumbotron-fullwidth" role="button" data-slide="next"><i class="fa fa-caret-right"></i></a>
        <?php endif; ?>
        
        <?php 
            $i = -1;
            while ( have_rows( 'slide' ) ) : 
                the_row();
                $i++;

                // Get the url for the img src
                $thelandscaper_slide_image = wp_get_attachment_image_src( get_sub_field( 'slidebg_image' ), 'thelandscaper-home-slider-m' );

                // Get the srcset code
                $thelandscaper_slide_image_srcset = thelandscaper_srcset_sizes( get_sub_field( 'slidebg_image' ), array( 'thelandscaper-home-slider-s', 'thelandscaper-home-slider-m', 'thelandscaper-home-slider-l' ) );

                // Get the caption option field
                $slide_caption = get_field( 'slide_captions' );

                // Get the link url field
                $link_slide = get_sub_field( 'link_slide' );

                // Get the link target field
                $link_target = get_sub_field( 'link_target' );
            ?>

            <div class="item <?php echo 0 === $i ? 'active' : ''; ?>">
                <?php if ( ! empty( $link_slide ) && $slide_caption === false ) : ?>
                    <a href="<?php echo esc_url( $link_slide ); ?>"<?php echo ( 'yes' === $link_target ) ? ' target="_blank"' : ''; ?>>
                <?php endif; ?>
                <img src="<?php echo esc_url( $thelandscaper_slide_image[0] ); ?>" width="<?php echo esc_attr( $thelandscaper_slide_image[1] ); ?>" height="<?php echo esc_attr( $thelandscaper_slide_image[2] ); ?>" srcset="<?php echo esc_html( $thelandscaper_slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( strip_tags( get_sub_field( 'slide_heading' ) ) ); ?>">
               <?php if ( ! empty( $link_slide ) && $slide_caption === false ) : ?>
                    </a>
                <?php endif; ?>
                <?php if ( get_field( 'slide_captions' ) && ( get_sub_field( 'slide_top_heading' ) || get_sub_field( 'slide_heading' ) || get_sub_field( 'slide_text' ) ) ) : ?>
                    <div class="container">
                        <div class="carousel-text <?php echo esc_attr( get_field( 'caption_align' ) ); ?>">
                            <?php if( get_sub_field( 'slide_top_heading' ) ) : ?>
                                <div class="carousel-topheading"><?php the_sub_field( 'slide_top_heading' ); ?></div>
                            <?php endif; ?>
                            <?php if( get_sub_field( 'slide_heading' ) ) : ?>
                                <div class="carousel-heading"><h1><?php the_sub_field( 'slide_heading' ); ?></h1></div>
                                <?php endif; ?>
                            <?php if( get_sub_field( 'slide_text' ) ) : ?>
                                <div class="carousel-content"><?php the_sub_field( 'slide_text' ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        
        <?php endwhile; ?>

        <?php if( get_field( 'slide_indicators' ) === true ) : ?>
            <div class="container">
                <div class="col-xs-12">
                    <ol class="carousel-indicators">
                        <?php
                        $i = -1;
                        while ( have_rows( 'slide' ) ) : 
                            the_row();
                            $i++;
                        ?>
                            <li data-target="#jumbotron-fullwidth" data-slide-to="<?php echo esc_attr( $i ); ?>"<?php echo 0 === $i ? ' class="active"': ''; ?>></li>
                        <?php endwhile; ?>
                    </ol>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>