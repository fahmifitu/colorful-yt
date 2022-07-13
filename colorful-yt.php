<?php

/**
 * Colorful YOOtheme
 *
 * @package           Colorful YOOtheme
 * @author            Fahmi Elfituri
 *
 * @wordpress-plugin
 * Plugin Name:       Colorful YOOtheme
 * Description:       Smartly colored elements for your Wordpress website.
 * Version:           0.5.0
 * Author:            Fahmi Elfituri
 */

define('COLORFUL_YT_PATH', dirname(__FILE__));

use YOOtheme\Application;

add_action('after_setup_theme', function () {
    // Check if YOOtheme Pro is loaded
    if (!class_exists(Application::class, false)) {
        return;
    }
    $app = Application::getInstance();
    $app->load(__DIR__ . '/bootstrap.php');
});
