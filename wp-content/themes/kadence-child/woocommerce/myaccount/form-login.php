<?php
/**
 * Template for customized login/register form (based on WooCommerce template)
 *
 * Copy this file to yourtheme/woocommerce/myaccount/form-login.php to override.
 *
 * @version 9.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form');
?>

<div class="entry-header">
    <h1 class="wishlist-title"><?php esc_html_e('My Wishlist', 'your-textdomain'); ?></h1>
</div>   

<div class="custom-login-wrapper">
    <div class="custom-login-content">
        <h2>Sign In or Create An Account</h2>
        <ul>
            <li>Faster Checkouts</li>
            <li>Track Your Orders</li>
            <li>Access Your Wishlist</li>
			<li>Exclusive Discounts</li>
			<li>New Product Alerts</li>
        </ul>

        <div class="auth-toggle-buttons">
            <button class="auth-tab active" data-tab="login">Sign In</button>
            <button class="auth-tab" data-tab="register">Create An Account</button>
        </div>

        <div id="auth-login" class="auth-section">
            <form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>
                <?php do_action('woocommerce_login_form_start'); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e('Username or Email Address', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="password" name="password" id="password" autocomplete="current-password" required />
                </p>

                <?php do_action('woocommerce_login_form'); ?>

                <p class="form-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                    </label>
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
                </p>

                <p class="woocommerce-LostPassword lost_password">
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                </p>

                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </div>

        <div id="auth-register" class="auth-section" style="display:none;">
            <form method="post" class="woocommerce-form woocommerce-form-register register">
                <?php do_action('woocommerce_register_form_start'); ?>

                <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                    </p>
                <?php endif; ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="email" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required />
                </p>

                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="password" name="password" id="reg_password" autocomplete="new-password" required />
                    </p>
                <?php else : ?>
                    <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>
                <?php endif; ?>

                <?php do_action('woocommerce_register_form'); ?>
                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <p class="woocommerce-form-row form-row">
                    <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                </p>
                <?php do_action('woocommerce_register_form_end'); ?>
            </form>
        </div>

        <div class="order-help-section">
            <h3>Need help with your recent order?</h3>
            <p>You can track your order or create a return without signing in using the links below.</p>
            <div class="order-buttons">
                <a class="track-order" href="#">TRACK MY ORDER</a>
                <a class="return-order" href="#">CREATE A RETURN</a>
            </div>
        </div>
    </div>

    <div class="custom-login-image">
        <img src="http://devcmsfoam.co.uk/wp-content/uploads/2025/07/width_452-1.jpg" alt="Login Image" />
    </div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
