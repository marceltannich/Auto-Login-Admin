<?php
/**
 * Plugin Name:       Auto Login Admin and Disable Backend Login
 * Plugin URI:        https://github.com/marceltannich/auto-login-admin
 * Description: 	     Automatically logs in the first administrator and disables the backend login screen when debugging locally.
 * Version:           1.0
 * Author:            Marcel Tannich
 * Author URI:        https://tannich.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mt-auto-login-admin
 */
 
 // Prevent direct access to the plugin file
defined('ABSPATH') || die('No script kiddies please!');

// Check if the current environment is localhost
function is_local_environment() {
    $whitelisted_hosts = ['127.0.0.1', '::1', 'localhost']; // Add any other local IPs or hostnames as needed
    $current_host = $_SERVER['REMOTE_ADDR'] ?? '';
    return in_array($current_host, $whitelisted_hosts);
}

// Function to "deactivate" by disabling plugin logic and displaying a message
function deactivate_mu_plugin() {
    // Show a notice to administrators when not on localhost
    add_action('admin_notices', function() {
        if (current_user_can('administrator')) {
            echo '<div class="notice notice-error"><p>The Auto-Login Admin plugin is disabled because it is not running in a local environment. Please remove the plugin from the mu-plugins folder for security reasons.</p></div>';
        }
    });

    // Optionally, log this for security audits
    error_log('Auto-Login Admin plugin was disabled because it was detected running in a production environment.', 0);
}

// Only run the plugin logic if we're in a local environment
if (is_local_environment()) {

    // Hook into 'init' action to perform the login logic early
    add_action('init', 'auto_login_first_admin');

    // Function to log in the first administrator found in the database
    function auto_login_first_admin() {
        // Check if the user is already logged in
        if (is_user_logged_in()) {
            return;
        }

        // Get all administrators
        $admins = get_users([
            'role'    => 'administrator',
            'number'  => 1,  // Get only the first admin
        ]);

        if (!empty($admins)) {
            $admin_user = $admins[0];

            // Log in the admin user automatically
            wp_set_current_user($admin_user->ID);
            wp_set_auth_cookie($admin_user->ID);
            do_action('wp_login', $admin_user->user_login, $admin_user);
            
            // Redirect to dashboard after login
            wp_redirect(admin_url());
            exit;
        }
    }

    // Disable the default WordPress login form by redirecting any login page request
    add_action('login_init', 'disable_login_page');
    function disable_login_page() {
        // Redirect all requests to wp-login.php to the homepage (or elsewhere)
        wp_redirect(home_url());
        exit;
    }

    // Disable logout functionality (so the user can't log out)
    add_action('wp_logout', 'prevent_logout');
    function prevent_logout() {
        wp_redirect(admin_url());
        exit;
    }

} else {
    // If the environment is not local, disable the plugin logic and show an admin notice
    deactivate_mu_plugin();
}
