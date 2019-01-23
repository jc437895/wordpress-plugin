<?php
/*
Plugin Name: Qichang Copyright Plugin
Plugin URI: https://github.com/jc437895/wordpress-plugin
Description: This plugin displays a line of copyright information at the bottom of all the articles
Version: 1.0
Author: Qichang Yin
Author URI: https://github.com/jc437895/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

/* The function to call when registering the activation plug-in */
register_activation_hook( __FILE__, 'display_copyright_install');
/* The function to call when registering the deactivated plug-in */
register_deactivation_hook( __FILE__, 'display_copyright_remove' );
function display_copyright_install() {
    /* Add a record to the wp_options table of the database, with the second parameter as the default */
    add_option("display_copyright_text", "<p> Notice: All articles of this site are original, if reproduced please indicate the source!</p>", ' ', 'yes');
}
function display_copyright_remove() {
    /* Delete the corresponding record in the wp_options table */
    delete_option('display_copyright_text');
}
if( is_admin() ) {
    /*  Add menus using the admin_menu hook */
    add_action('admin_menu', 'display_copyright_menu');
}
function display_copyright_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* Page name, menu name, access level, menu alias, callback function when clicking the menu (to display the Settings page) */
    add_options_page('Copyright Settings page', 'Copyright Settings menu', 'administrator','display_copyright', 'display_copyright_html_page');
}
function display_copyright_html_page() {
?>
    <div>
        <h2>Copyright Settings</h2>
        <form method=“post” action=“options.php”>
            <?php /* The following line of code holds the form's contents to the database */ ?>
            <?php wp_nonce_field('update-options'); ?>
            <p>
                <textarea
                    name=“display_copyright_text”
                    id=“display_copyright_text”
                    cols=“40”
                    rows=“6”><?php echo get_option('display_copyright_text'); ?></textarea>
            </p>
            <p>
                <input type=“hidden” name=“action” value=“update” />
                <input type=“hidden” name=“page_options” value=“display_copyright_text” />
                <input type=“submit” value=“save_settings” class=“button-primary” />
            </p>
        </form>
    </div>
<?php
}
add_filter( 'the_content',  'display_copyright');
/* This function adds a section of copyright information at the end of the log body, and only on the single page */
function display_copyright( $content ) {
    if( is_single() )
        $content = $content . get_option('display_copyright_text');
    return $content;
}
?>
