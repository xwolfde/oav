<?php
/**
 * Plugin Name:         Online Application and Voting
 * Plugin URI:          https://github.com/xwolfde/oav
 * GitHub Plugin URI:   https://github.com/xwolfde/oav
 * Description:         Applicate forms for decissions by groups and allow votings for given applicates.
 * Version:             1.0.0
 * Author:              xwolf
 * Author URI:          https://xwolf.de
 * License:             GNU General Public License v2
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:         /languages
 * Text Domain:         oav
 */

add_action('plugins_loaded', array('OAV', 'instance'));
register_activation_hook(__FILE__, array('OAV', 'activation'));
register_deactivation_hook(__FILE__, array('OAV', 'deactivation'));

class OAV {
    const version = '1.0.0';
    const option_name = '_oav';
    const textdomain = 'oav';
    const php_version = '7.0'; // Minimal erforderliche PHP-Version
    const wp_version = '4.8'; // Minimal erforderliche WordPress-Version

    protected static $instance = null;

    
    public static function instance() {

        if (null == self::$instance) {
            self::$instance = new self;
            self::$instance->init();
        }

        return self::$instance;
    }

    private function init() {
        // Sprachdateien werden eingebunden.
        self::load_textdomain();
        
        include_once('includes/posttype/posttype.php');
        include_once('includes/taxonomy/taxonomy.php');
        include_once('includes/metabox/metabox.php');
        // include_once('includes/shortcodes/shortcode.php');
        // include_once('includes/widgets/widget.php');
        // include_once('includes/settings.php');
        // include_once('includes/help.php');
        
        
        add_action( 'wp_enqueue_scripts',  array($this, 'register_scripts'));
   
    }
        
    // Einbindung der Sprachdateien.
    private static function load_textdomain() {    
        load_plugin_textdomain(self::textdomain, false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
    }
    
    public static function activation() {
        // Sprachdateien werden eingebunden.
        self::load_textdomain();
        self::system_requirements();
    }

    public static function deactivation() {
        delete_option(self::option_name);
    }
    
    /*
     * Überprüft die minimal erforderliche PHP- u. WP-Version.
     * @return void
     */    
    private static function system_requirements() {
        $error = '';

        if (version_compare(PHP_VERSION, self::php_version, '<')) {
            $error = sprintf(__('Ihre PHP-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die PHP-Version %s.', 'fau-oembed'), PHP_VERSION, self::php_version);
        }

        if (version_compare($GLOBALS['wp_version'], self::wp_version, '<')) {
            $error = sprintf(__('Ihre Wordpress-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die Wordpress-Version %s.', 'fau-oembed'), $GLOBALS['wp_version'], self::wp_version);
        }

        if (!empty($error)) {
            deactivate_plugins(plugin_basename(__FILE__), false, true);
            wp_die($error);
        }
    }

    private function default_options() {       
        $options = array( );
        return $options;
    }

    private function get_options() {
        $defaults = $this->default_options();
        $options = (array) get_option(self::option_name);        
        $options = wp_parse_args($options, $defaults);
        $options = array_intersect_key($options, $defaults);
        
        foreach($defaults as $key => $val) {
            if(is_array($val)) {
                $options[$key] = wp_parse_args($options[$key], $defaults[$key]);
                $options[$key] = array_intersect_key($options[$key], $defaults[$key]);
            }
        }
        
        return $options;
    }
    function register_scripts() {    
        global $post;

        wp_register_style( 'css-plain', plugins_url( 'oav/assets/css/style.css', dirname(__FILE__) ) );
        wp_register_style( 'css-bootstrap', plugins_url( 'oav/assets/css/style-bs.css', dirname(__FILE__) ) );
        wp_register_script( 'myjs', plugins_url('oav/assets/js/scripts.min.js', dirname(__FILE__)), array('jquery'),'' , true);
    }
}