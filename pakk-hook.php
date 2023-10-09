<?php
/*
Plugin Name:  pakk-hook
Plugin URI:   https://timer.sk
Description:  A plugin to hook pakk to WordPress
Version:      1.0
Author:       hunwalk
Author URI:   https://timer.sk
License:      MIT
License URI:  https://opensource.org/licenses/MIT
Text Domain:  pakk
*/

// check if we have composer
if (file_exists(ABSPATH . 'vendor/autoload.php')) {

    /**
     * Composer autoloader.
     */
    require ABSPATH . 'vendor/autoload.php';

    /**
     * Application autoloader.
     */
    require ABSPATH . 'vendor/teamtimer/pakk-core/src/App.php';

    /**
     * Hook the app if we have /src
     */
    if (file_exists(ABSPATH . '/src')) {
        add_action('init', function () {

            // register the application
            $app = new \TeamTimer\Pakk\App();
            $app->init();
        });
    }

}

// check if we have Installer.php, if not, we've probably installed everything
if (file_exists(ABSPATH . '/wp-content/plugins/pakk-hook/Installer.php')) {
    include_once ABSPATH . '/wp-content/plugins/pakk-hook/Installer.php';

    $installer = new Installer();

    add_action('wp_ajax_wp-pakk-install', function () use ($installer) {
        $installer->install();
    });

    add_action('wp_ajax_wp-pakk-delete', function () use ($installer){
        $installer->delete();
    });
}


/**
 * Install hook.
 */
add_action('admin_init', function () {
    //check if we have /src
    if (!file_exists(ABSPATH . '/src')) {
        $allowedActions = ['wp-pakk-install', 'wp-pakk-delete'];
        if (!isset($_GET['action']) || !in_array($_GET['action'], $allowedActions)) {
            installScreen();
        }
    }

});

/**
 * @return void
 */
function installScreen(){
    include __DIR__ . '/pakk-install.php';
    exit;
}
