<?php
/**
 * Custom header for White Company style
 */
namespace Kadence;

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- Google Material Symbols (Icons) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-25..200" rel="stylesheet" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="wrapper" class="site">

    <!-- Main Header -->
    <header id="masthead" class="site-header">
        <div class="header-navbar twc-header">
            <!-- Logo - Centered -->
            <div class="header-logo twc-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>">
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation (Dynamic) -->
            <?php if (has_nav_menu('twc-primary-nav')) : ?>
                <?php
                // Get the menu object by location
                $locations = get_nav_menu_locations();
                $menu_id = isset($locations['twc-primary-nav']) ? $locations['twc-primary-nav'] : 0;
                $menu_items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];
                ?>
                <nav class="twc-primary-nav-wrapper" id="twc-dynamic-nav" data-menu='<?php echo json_encode($menu_items); ?>'></nav>
            <?php endif; ?>

            <!-- Utility Navigation -->
            <?php if (has_nav_menu('twc-utility-nav')) : ?>
            <nav class="twc-utility-nav-wrapper">
                <?php wp_nav_menu([
                    'theme_location' => 'twc-utility-nav',
                    'menu_class' => 'twc-utility-nav',
                    'container' => false,
                    'depth' => 1,
                    'fallback_cb' => false
                ]); ?>
            </nav>
            <?php endif; ?>

            <!-- Icon Buttons (Search, Wishlist, Account, Cart) -->
            <div class="twc-header-icons">
                <a href="/search"><span class="material-symbols-outlined">search</span></a>
                <a href="/wishlist"><span class="material-symbols-outlined">favorite</span></a>
                <a href="/account"><span class="material-symbols-outlined">person</span></a>
                <a href="/cart"><span class="material-symbols-outlined">shopping_bag</span></a>
                <a href="/live-chat"><span class="material-symbols-outlined">robot_2</span></a>
                <a href="/faq"><span class="material-symbols-outlined">help_center</span></a>
                <a href="/settings"><span class="material-symbols-outlined">settings_b_roll</span></a>
            </div>

        </div> <!-- /.header-navbar -->
    </header>
