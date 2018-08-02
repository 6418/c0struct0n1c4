<?php
/**
 * Social sharing buttons template part
 *
 * @package The Landscaper
 */

$share_tooltip    = get_theme_mod( 'qt_blog_tooltip', 'Share' );
$share_twitter    = get_theme_mod( 'qt_blog_twitter', 'Twitter' );
$share_facebook   = get_theme_mod( 'qt_blog_facebook', 'Facebook' );
$share_googleplus = get_theme_mod( 'qt_blog_googleplus', 'Google+' );
$share_linkedin   = get_theme_mod( 'qt_blog_linkedin', 'LinkedIn' );
?>

<div class="social-sharing-buttons clearfix">
	<span data-toggle="tooltip" data-original-title="<?php echo esc_attr( $share_tooltip ); ?>">
		<i class="fa fa-share-alt"></i>
	</span>
	<?php if ( $share_twitter ) : ?>
		<a class="twitter" href="http://twitter.com/intent/tweet/?text=<?php echo esc_html( get_the_title() ); ?>&url=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_twitter ); ?></a>
	<?php endif; ?>
	<?php if ( $share_facebook ) : ?>
		<a class="facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_facebook ); ?></a>
	<?php endif; ?>
	<?php if ( $share_googleplus ) : ?>
		<a class="gplus" href="http://plus.google.com/share?url=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_googleplus ); ?></a>
	<?php endif; ?>
	<?php if ( $share_linkedin ) : ?>
		<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_the_permalink() ); ?>&title=<?php echo esc_html( get_the_title() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_linkedin ); ?></a>
	<?php endif; ?>
</div>