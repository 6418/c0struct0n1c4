<?php
/**
 * Default Header Layout
 *
 * @package The Landscaper 
 */
?>

<header class="header header-transparent">

	<?php if ( 'hide' !== get_theme_mod( 'qt_topbar', 'show' ) && 'hide' !== get_field( 'topbar' ) ) : ?>
		<div class="topbar<?php echo 'hide_mobile' === get_theme_mod( 'qt_topbar', 'show' ) ? ' hidden-xs' : '';?>">
			<div class="container">
				<span class="tagline"><?php bloginfo( 'description' ); ?></span>
				<?php if ( is_active_sidebar( 'topbar-widgets' ) ) : ?>
					<div class="widgets">
						<?php dynamic_sidebar( 'topbar-widgets' ); ?>
					</div>
				<?php endif; ?>
				<div class="clear"></div>
		    </div>
		</div>
	<?php endif; ?>


	<div class="navigation-wrapper">
		<div class="container">

			<div class="navigation" aria-label="Main Menu">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="navbar-toggle-text"><?php esc_html_e( 'MENU', 'the-landscaper-wp' ); ?></span>
						<span class="navbar-toggle-icon">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</span>
					</button>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="navbar-brand">
						<?php
							$logo = esc_url( get_theme_mod( 'qt_logo', false ) );
							$logo_retina = esc_url( get_theme_mod( 'qt_logo_retina', false ) );
							$logo_transparent = esc_url( get_theme_mod( 'qt_logo_transparent', false ) );
							$logo_retina__transparent = esc_url( get_theme_mod( 'qt_logo_retina_transparent', false ) );
							
							if ( ! empty( $logo ) && ! empty( $logo_transparent ) ) : ?>
								<img src="<?php echo esc_url( $logo ); ?>" srcset="<?php echo esc_html( $logo ); ?><?php echo empty ( $logo_retina ) ? '' : ', ' . $logo_retina . ' 2x'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="hidden-md hidden-lg" />
								<img src="<?php echo esc_url( $logo_transparent ); ?>" srcset="<?php echo esc_html( $logo_transparent ); ?><?php echo empty ( $logo_retina_transparent ) ? '' : ', ' . $logo_retina_transparent . ' 2x'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="hidden-xs hidden-sm" />
							<?php else : ?>
								<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
							<?php 
							endif;
						?>
					</a>
				</div>

				<nav id="navbar" class="collapse navbar-collapse">
					<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary') ) : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary') ); ?>
					<?php else: ?>
						<?php
							if ( has_nav_menu( 'primary' ) ) :
								wp_nav_menu( array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'main-navigation',
									'walker'         => new Aria_Walker_Nav_Menu(),
									'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
								) );
							endif;
						?>
					<?php endif; ?>
				</nav>

			</div>
		</div>
	</div>

	<div class="sticky-offset"></div>
	
</header>