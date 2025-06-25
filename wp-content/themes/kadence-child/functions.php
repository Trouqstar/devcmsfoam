<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ctc-style.css', array( 'kadence-global','kadence-header','kadence-content','kadence-woocommerce','kadence-footer','kadence-rankmath' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

// Start of my edits

function mytheme_enqueue_google_fonts() {
    wp_enqueue_style( 'mytheme-google-fonts', 
        'https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600&display=swap', 
        array(), 
        null
    );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_google_fonts' );

function mytheme_preload_fonts() {
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600&display=swap"></noscript>';
}
add_action( 'wp_head', 'mytheme_preload_fonts', 1 );

// End of Font

//Removal Of title headers
// Nuclear option for title removal
add_action('wp_head', function() {
    if (is_page()) {
        echo '<style>
            .entry-hero-container, 
            .page-header { 
                display:none!important; 
            }
        </style>';
    }
}, 999);

// Cycling Banner

add_action('wp_body_open', 'add_custom_cycling_banner');
function add_custom_cycling_banner() {
    ?>
    <div class="custom-cycling-banner twc-style">
        <div class="banner-container">
            <div class="banner-message active">Free UK Standard delivery on orders over £60</div>
            <div class="banner-message">We aim to deliver in 3 working days</div>
            <div class="banner-message">Free returns within 30 days</div>
            <div class="banner-message">Shop now and enjoy exclusive discounts</div>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'add_banner_scripts');
function add_banner_scripts() {
    ?>
    <style>
        .custom-cycling-banner.twc-style {
            background: #ebe4dd;
            border-bottom: 1px solid #e5e5e5;
            position: sticky;
            top: 0;
            z-index: 999;
            height: 40px; /* Fixed height prevents layout shift */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banner-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #ebe4dd;
        }
        .banner-message {
            position: absolute;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            font: 12px/1.4 'Helvetica Neue', Arial, sans-serif;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0;
            transition: opacity 0.5s ease;
            top: 0;
            left: 0;
        }
        .banner-message.active {
            opacity: 1;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.banner-message');
        let current = 0;
        
        function cycleMessages() {
            // Fade out current message
            messages[current].classList.remove('active');
            
            setTimeout(function() {
                // Move to next message
                current = (current + 1) % messages.length;
                // Fade in next message
                messages[current].classList.add('active');
            }, 500); // Matches CSS transition time
        }
        
        if (messages.length > 1) {
            // Start cycling after first message's display time
            setTimeout(function() {
                setInterval(cycleMessages, 3000);
            }, 3000);
        }
    });
    </script>
    <?php
}
//End of Cycling Banner

// Custom Site Width

// Completely remove width restrictions and products-content
add_action('wp_head', function() {
    echo '<style>
        .container, .content-container, .site-container, 
        .header-inner-container, .footer-inner-container {
            max-width: none !important;
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .twc-inspired-sundries {
            padding-top: 100px !important;
            padding-left: 10px !important;
        }
            
    </style>';
});



// Custom Menu "By Application"
// 1. Register the menu location (controls admin display name)
add_action('after_setup_theme', 'twc_register_menus');
function twc_register_menus() {
    register_nav_menus([
        'twc-primary-nav' => __('Primary Navigation', 'your-child-theme'),
        'twc-utility-nav'  => __('Utility Navigation', 'your-child-theme'),
    ]);
}

// Display primary navigation
add_action('kadence_before_header', 'twc_display_primary_nav');
function twc_display_primary_nav() {
    if (has_nav_menu('twc-primary-nav')) {
        echo '<div class="twc-primary-nav-wrapper">';
        wp_nav_menu([
            'theme_location' => 'twc-primary-nav',
            'menu_class'     => 'twc-primary-nav',
            'container'      => false,
            'depth'         => 3, // Allow for sub-submenus
            'walker'        => new TWC_Nav_Walker() // Correct custom walker
        ]);
        echo '</div>';
    }
}

// Display utility navigation (account, search, etc)
add_action('kadence_header', 'twc_display_utility_nav');
function twc_display_utility_nav() {
    if (has_nav_menu('twc-utility-nav')) {
        wp_nav_menu([
            'theme_location' => 'twc-utility-nav',
            'menu_class'     => 'twc-utility-nav',
            'container'      => false,
            'depth'         => 1
        ]);
    }
}



// Remove Customizer edit shortcuts
add_action('wp_head', 'twc_remove_customizer_ui');
function twc_remove_customizer_ui() {
    echo '<style>
        .customize-partial-edit-shortcut {
            display: none !important;
        }
        /* Smooth transition for dropdowns */
        .twc-primary-nav .sub-menu {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
    </style>';
}

// Enqueue CSS properly
add_action('wp_enqueue_scripts', 'twc_enqueue_menu_styles', 30);
function twc_enqueue_menu_styles() {
    wp_enqueue_style(
        'twc-menu-style',
        get_stylesheet_directory_uri() . '/twc-menu.css',
        array(),
        filemtime(get_stylesheet_directory() . '/twc-menu.css')
    );

    $inline_css = "
        .twc-primary-nav,
        .twc-primary-nav ul,
        .twc-primary-nav li,
        .twc-utility-nav,
        .twc-utility-nav ul,
        .twc-utility-nav li {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    ";
    wp_add_inline_style('twc-menu-style', $inline_css);
}

// SubMenu Render JS

function twc_enqueue_scripts() {
    // Enqueue the JS script
    wp_enqueue_script(
        'twc-dynamic-menu',
        get_stylesheet_directory_uri() . '/js/twc-dynamic-menu.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/twc-dynamic-menu.js'),
        true
    );

    // Enqueue the enhancement script that adds linked textboxes
    wp_enqueue_script(
        'twc-enhance-submenus',
        get_stylesheet_directory_uri() . '/js/twc-enhance-submenus.js',
        array('twc-dynamic-menu'),
        filemtime(get_stylesheet_directory() . '/js/twc-enhance-submenus.js'),
        true
    );

    // Get menu items for 'twc-primary-nav'
    $locations = get_nav_menu_locations();
    $menu_data = [];

    if (isset($locations['twc-primary-nav'])) {
        $menu_id = $locations['twc-primary-nav'];
        $menu_items = wp_get_nav_menu_items($menu_id);

        if (!empty($menu_items) && is_array($menu_items)) {
            foreach ($menu_items as $item) {
                $image_url = get_the_post_thumbnail_url($item->object_id, 'full') ?: '';
                $image_text = '';

                // Get image alt text if image exists
                if ($image_url) {
                    $thumbnail_id = get_post_thumbnail_id($item->object_id);
                    $image_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                }

                $menu_data[] = [
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'menu_item_parent' => $item->menu_item_parent,
                    'image' => $image_url,
                    'image_text' => $image_text // Add alt text to data
                ];
            }
        }
    }

    // Localize the data
    wp_localize_script('twc-dynamic-menu', 'twcMenuData', $menu_data);
}
add_action('wp_enqueue_scripts', 'twc_enqueue_scripts');

//Search Toggle

function twc_enqueue_header_scripts() {
    wp_enqueue_script(
        'twc-search-toggle',
        get_stylesheet_directory_uri() . '/js/search-toggle.js',
        array(), // Dependencies (e.g. jQuery if needed)
        null,    // Version
        true     // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'twc_enqueue_header_scripts');

// Start of Favourites
/**
 * Wishlist functionality for WooCommerce
 */

// Enqueue wishlist scripts and styles
function enqueue_wishlist_scripts() {
    wp_enqueue_script(
        'wishlist-js',
        get_stylesheet_directory_uri() . '/js/wishlist.js',
        array(),
        '1.0',
        true
    );

    wp_enqueue_style(
        'wishlist-css',
        get_stylesheet_directory_uri() . '/css/wishlist.css'
    );

    wp_localize_script('wishlist-js', 'wishlistVars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('twc_wishlist_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_wishlist_scripts');


// Add wishlist button to product loops and single product pages
function add_wishlist_button() {
    global $product;

    if (!$product || ! $product->get_id()) return;

    echo get_wishlist_button_html($product->get_id());
}
add_action('woocommerce_after_shop_loop_item', 'add_wishlist_button', 15);
add_action('woocommerce_single_product_summary', 'add_wishlist_button', 35);


// Generate HTML for wishlist button
function get_wishlist_button_html($product_id) {
    ob_start();
    ?>
    <button class="add-to-wishlist" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php esc_attr_e('Add to wishlist', 'your-textdomain'); ?>">
        <span class="heart-icon">♡</span>
    </button>
    <?php
    return ob_get_clean();
}


// Render individual product in wishlist view
function render_wishlist_product_html($product) {
    if (!$product || ! $product instanceof WC_Product) return;

    get_template_part('template-parts/wishlist-product', null, ['product' => $product]);
}


// Display wishlist products on the "favourites" page
function display_wishlist_products() {
    $wishlist = isset($_COOKIE['twc_wishlist']) ?
        json_decode(stripslashes($_COOKIE['twc_wishlist']), true) : [];

    if (empty($wishlist)) {
        get_template_part('template-parts/wishlist-product-empty');
        return;
    }

    $args = array(
        'post_type'      => 'product',
        'post__in'       => array_map('intval', $wishlist),
        'posts_per_page' => -1,
        'orderby'        => 'post__in'
    );

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());
            render_wishlist_product_html($product);
        }
        wp_reset_postdata();
    } else {
        echo '<p class="wishlist-empty">' . esc_html__('No saved items found.', 'your-textdomain') . '</p>';
    }
}


// Handle wishlist toggle via AJAX
add_action('wp_ajax_twc_wishlist_toggle', 'twc_handle_wishlist_toggle');
add_action('wp_ajax_nopriv_twc_wishlist_toggle', 'twc_handle_wishlist_toggle');

function twc_handle_wishlist_toggle() {
    nocache_headers();

    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'twc_wishlist_nonce')) {
        wp_send_json_error(['message' => 'Security check failed']);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!$product_id || get_post_type($product_id) !== 'product') {
        wp_send_json_error(['message' => 'Invalid product ID']);
    }

    // In a real-world app, you'd update a DB or user meta here.
    wp_send_json_success(['message' => 'Wishlist updated']);
}


// Prevent caching on the favourites page
add_action('template_redirect', function() {
    if (is_page('favourites')) {
        nocache_headers();
        header("Cache-Control: no-store, no-cache, must-revalidate");
    }
});

//Deregister Comments


//End of Line