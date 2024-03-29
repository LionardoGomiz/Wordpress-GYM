<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GymAndClub
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gymandclub' ); ?></a>

	<header id="masthead" class="site-header container-fluid">
        <div class="row">
		<div class="site-branding col-md-4">
			<?php
            if (has_custom_logo())
            {
                the_custom_logo();
            }
            else{ ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php
            }
            ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation col-md-8">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gymandclub' ); ?></button>
			<?php
			wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				));
			?>
		</nav><!-- #site-navigation -->
        </div><!--.row-->
	</header><!-- #masthead -->

    <div id="content" class="site-content container">
        <div class="row">
