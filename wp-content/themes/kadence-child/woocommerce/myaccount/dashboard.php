<?php
defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
?>

<div class="custom-dashboard">
    <h2 class="dashboard-heading">My Account</h2>
    <p class="dashboard-welcome">Hello <?php echo esc_html( $current_user->display_name ); ?></p>

    <div class="dashboard-grid">
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-orders.svg" alt="">
            <strong>My orders</strong>
            <span>View current and past orders</span>
        </a>
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-user.svg" alt="">
            <strong>Personal details</strong>
            <span>Manage your name, contact address and phone number</span>
        </a>
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-address.svg" alt="">
            <strong>Address book</strong>
            <span>Manage your delivery addresses</span>
        </a>
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'payment-methods' ) ); ?>" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-card.svg" alt="">
            <strong>Payment details</strong>
            <span>Manage your payment methods</span>
        </a>
        <a href="#" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-preferences.svg" alt="">
            <strong>My preferences</strong>
            <span>Manage how we contact you</span>
        </a>
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="dashboard-tile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-password.svg" alt="">
            <strong>Manage password</strong>
            <span>Update your password</span>
        </a>
    </div>

    <p class="dashboard-logout">
        <a href="<?php echo esc_url( wc_logout_url() ); ?>">Sign out &gt;</a>
    </p>
</div>
