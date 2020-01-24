<?php
/*
Plugin Name: Cody Framework
Plugin URI: https://codyshop.ru
Description: Framework for create option page for themes
Author: Yan Alexandrov
Version: 1.1.0
*/

/*
 * Include this in head function.php
 * require_once_once 'admin.php';
 */

if (!defined('ABSPATH')) exit;

add_action('customize_register', 'cody_framework_include');
function cody_framework_include($wp_customize) {
    global $cody_l18n;
    $cody_l18n = wp_get_theme()->get('TextDomain');

    require_once 'controls/cody-input.php';
    require_once 'controls/cody-textarea.php';
    require_once 'controls/cody-wpeditor.php';
    require_once 'controls/cody-date-picker.php';
    require_once 'controls/cody-separator.php';
    require_once 'controls/cody-select-category.php';
    require_once 'controls/cody-google-font.php';
    require_once 'controls/cody-menu.php';
    require_once 'controls/cody-multi-input.php';
    require_once 'controls/cody-switch.php';
    require_once 'controls/cody-post.php';
    require_once 'controls/cody-notice.php';
    require_once 'controls/cody-tags.php';
    require_once 'controls/cody-user.php';
    require_once 'controls/cody-range-slider.php';
    require_once 'controls/cody-post-type.php';
    require_once 'controls/cody-taxonomy.php';
    require_once 'controls/cody-color.php';
    require_once 'controls/cody-color-scheme.php';
    require_once 'controls/cody-slider.php';

    require_once 'controls/cody-select.php';
    require_once 'controls/cody-radio-simple.php';
    require_once 'controls/cody-radio-text.php';
    require_once 'controls/cody-radio-image.php';

    require_once 'controls/cody-icons.php';
    require_once 'controls/cody-single-image.php';
    require_once 'controls/cody-multi-image.php';

    require_once 'controls/cody-google-map.php';

    require_once 'controls/cody-work-schedule.php';
}

add_action('customize_controls_enqueue_scripts', 'cody_framework_add_files');
function cody_framework_add_files() {
    wp_enqueue_script('cf-script', get_template_directory_uri() . '/libs/cody-framework/inc/js.js', '', '', true);
    wp_enqueue_style('cf-style', get_template_directory_uri() . '/libs/cody-framework/inc/css.css', '');
}


add_filter('cf_add_style', 'cf_add_style_in_head', 10, 1);
function cf_add_style_in_head($arr) {
    $string = '';
    $arr = apply_filters('cf_add_styles', $arr);
    foreach ($arr as $ar) {
        if (isset($ar['gradient'])) {
            if ($ar['gradient']['orientation'] == 'horizontal') {
                $string .= $ar['selectors'] . '{ ';
                $string .= 'background: ' . $ar['gradient']['color1'] . ';';
                $string .= 'background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, ' . $ar['gradient']['color1'] . '), color-stop(100%, ' . $ar['gradient']['color2'] . '))' . $ar['gradient']['image'];
                $string .= 'background: -moz-linear-gradient(right, ' . $ar['gradient']['color1'] . '), ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= 'background: -webkit-linear-gradient(left, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= 'background: linear-gradient(to right, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= '}';
            } elseif ($ar['gradient']['orientation'] == 'vertical') {
                $string .= $ar['selectors'] . '{ ';
                $string .= 'background: ' . $ar['gradient']['color1'] . ';';
                $string .= 'background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, ' . $ar['gradient']['color1'] . '), color-stop(100%, ' . $ar['gradient']['color2'] . '))' . $ar['gradient']['image'];
                $string .= 'background: -moz-linear-gradient(top, ' . $ar['gradient']['color1'] . '), ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= 'background: -webkit-linear-gradient(top, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= 'background: linear-gradient(to bottom, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
                $string .= '}';
            }
        } else {
            $string .= $ar['selectors'] . '{ ' . $ar['style'] . ': ' . $ar['val'] . $ar['measure'] . '; }
';
        }
    }
    return $string;
}


/*
 * param @arr - array of css ids and classes
 * param @val - value of css ids and classes
 */
add_action('wp_head', 'cf_add_head_styles', 99999);
function cf_add_head_styles() {
    if (has_filter('cf_add_styles')) {
        $arr = '';
        echo "<style>\n";
        echo apply_filters('cf_add_style', $arr);
        echo "</style>\n";
    }
}

function cf_get_font($option) {
    if ($option) {
        $selectDirectory = get_template_directory_uri() . '/libs/cody-framework/controls/cache/google-web-fonts.txt';
        $content = json_decode(file_get_contents($selectDirectory));
        $font_id = get_theme_mod($option);
        $font = $content->items[$font_id];
        return $font;
    }
}

function cf_get_font_family($option) {
    if ($option) {
        $font = cf_get_font($option);
        return $font->family;
    }
}

function cf_get_font_url($option) {
    if ($option) {
        $font = cf_get_font($option);
        return $font->files;
    }
}
