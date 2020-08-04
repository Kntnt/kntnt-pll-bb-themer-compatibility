<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Polylang and Beaver Builder Theme Builder compatibility plugin
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Makes Polylang compatible with Beaver Builder Theme Builder (a.k.a. Beaver Theamer).
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\PLL_BB_Themer_Compatibility;

defined( 'ABSPATH' ) && new Plugin;

final class Plugin {

    public function __construct() {
        add_action( 'init', [ $this, 'run' ] );
    }

    public function run() {
        if ( function_exists( 'pll_current_language' ) ) {
            add_filter( 'fl_theme_builder_current_page_layouts', [ $this, 'fl_theme_builder_current_page_layouts' ] );
        };
    }

    public function fl_theme_builder_current_page_layouts( $layouts ) {
        $lang = pll_current_language();
        foreach ( $layouts as $layout => $posts ) {
            $layouts[ $layout ] = array_filter( $posts, function ( $post ) use ( $lang ) {
                return pll_get_post_language( $post['id'] ) == $lang;
            } );
        }
        return $layouts;
    }

}
