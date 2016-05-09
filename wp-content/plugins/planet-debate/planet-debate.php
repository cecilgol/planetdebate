<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://planetdebate.com
 * @since             1.0.0
 * @package           Planet_Debate
 *
 * @wordpress-plugin
 * Plugin Name:       Planet Debate Plugin
 * Plugin URI:        http://planetdebate.com
 * Description:       This package contains all the functions for the Planet Debate Theme
 * Version:           1.0.0
 * Author:            cecilgol
 * Author URI:        http://cecilgol.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       planet-debate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-planet-debate-activator.php
 */
function activate_Planet_Debate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-planet-debate-activator.php';
	Planet_Debate_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-planet-debate-deactivator.php
 */
function deactivate_Planet_Debate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-planet-debate-deactivator.php';
	Planet_Debate_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Planet_Debate' );
register_deactivation_hook( __FILE__, 'deactivate_Planet_Debate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-planet-debate.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Planet_Debate() {

	$plugin = new Planet_Debate();
	$plugin->run();

}
run_Planet_Debate();
