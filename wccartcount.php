<?php

/*
 Plugin Name: CartCount for WooCommerce
 Plugin URI: https://roteserver.de/wccartcount
 Description: Adds 2 shortcodes to easily get the current WooCommerce cartcount
 Version: 1.1
 Author: humorhenker
 Author URI: https://roteserver.de
 License:     GPL2

 CartCount for WooCommerce is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.
  
 CartCount for WooCommerce is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with CartCount for WooCommerce. If not, see <http://www.gnu.org/licenses/>.
 */
defined('ABSPATH') or die('No script kiddies please!');

add_action( 'admin_menu', 'wccartcount_settings_page' , 1);
add_action( 'admin_init', 'wccartcount_settings_init' );

function wccartcount_settings_page() {
    add_options_page( 'CartCount settings', 'CartCount settings', 'manage_options', 'wccartcount-settings-page', 'wccartcount_options_page' );
}

function wccartcount_settings_init(  ) {
    register_setting( 'wccartcount', 'wccartcount_settings' );
    add_settings_section(
        'wccartcount_section',
        __( 'WC CartCount Settings:', 'wordpress' ),
        'wccartcount_settings_section_callback',
        'wccartcount'
    );

    add_settings_field(
        'wccartcount_fullcount',
        __( 'Fullcount', 'wordpress' ),
        'wccartcount_fullcount_render',
        'wccartcount',
        'wccartcount_section'
    );

    add_settings_field(
        'wccartcount_countextraargs',
        __( 'Count &ltp&gt element extra args', 'wordpress' ),
        'wccartcount_countextargs_render',
        'wccartcount',
        'wccartcount_section'
    );

    add_settings_field(
        'wccartcount_countleftextargs_render',
        __( 'Countleft &ltp&gt element extra args', 'wordpress' ),
        'wccartcount_text_field_2_render',
        'wccartcount',
        'wccartcount_section'
    );

}

function wccartcount_fullcount_render(  ) {
    $options = get_option( 'wccartcount_settings' );
    ?>
    <input type='text' name='wccartcount_settings[wccartcount_fullcount]' value='<?php echo $options['wccartcount_fullcount']; ?>'>
    <?php
}

function wccartcount_countextargs_render(  ) {
    $options = get_option( 'wccartcount_settings' );
    ?>
    <input type='text' name='wccartcount_settings[wccartcount_countextraargs]' value='<?php echo $options['wccartcount_countextraargs']; ?>'>
    <?php
}

function wccartcount_countleftextargs_render(  ) {
    $options = get_option( 'wccartcount_settings' );
    ?>
    <input type='text' name='wccartcount_settings[wccartcount_countleftextraargs]' value='<?php echo $options['wccartcount_countleftextraargs']; ?>'>
    <?php
}

function wccartcount_settings_section_callback(  ) {
    echo __( 'All WC CartCount settings can be edited here. Fullcount is the number of items needed in cart to reach one complete shiping package.', 'wordpress' );
}

function wccartcount_options_page(  ) {
    ?>
    <form action='options.php' method='post'>

        <h2>Cartcount for WooCommerce Admin Page</h2>

        <?php
        settings_fields( 'wccartcount' );
        do_settings_sections( 'wccartcount' );
        submit_button();
        ?>

    </form>
    <?php
}

add_shortcode('wc_cart_count', 'wc_cart_count');
add_shortcode('wc_cart_count_left', 'wc_cart_count_left');

function wc_cart_count() {
    if (is_object(WC()->cart)) return WC()->cart->get_cart_contents_count();
    else return false;
}

function wc_cart_count_left() {
    $fullcount = get_option('wccartcount_settings')['wccartcount_fullcount'];
    if ($fullcount == "") $fullcount = 12;
    if (is_object(WC()->cart)) {
        $var = WC()->cart->get_cart_contents_count() % $fullcount;
        if ($var == 0) return 0;
        else return $fullcount - $var;
    }
    else return false;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'cartcount_cart_count_fragments', 10, 1 );

function cartcount_cart_count_fragments( $fragments ) {
    $fragments['p.cartcount'] = '<p class="cartcount" ' . get_option('wccartcount_settings')['wccartcount_countextraargs'] . '>' . WC()->cart->get_cart_contents_count() . '</p>';
    $fullcount = get_option('wccartcount_settings')['wccartcount_fullcount'];
    if ($fullcount == "") $fullcount = 12;
    $var = WC()->cart->get_cart_contents_count() % $fullcount;
    if ($var == 0) $cartitemsleft = 0;
    else $cartitemsleft = $fullcount - $var;
	$fragments['p.cartcountleft'] = '<p class="cartcountleft" ' . get_option('wccartcount_settings')['wccartcount_countleftextraargs'] . '>' . $cartitemsleft . '</p>';
    return $fragments;
}