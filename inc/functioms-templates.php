<?php

function print_messengers() {
    $html = '<div class="messengers__grid">';
    if ($url = get_option('telegram')) {
        $html .= '<a href="' . $url . '" class="messenger-item ic ic-telegram"></a>';
    }
    if ($url = get_option('whatsapp')) {
        $html .= '<a href="' . $url . '" class="messenger-item ic ic-whatsapp"></a>';
    }
    if ($url = get_option('viber')) {
        $html .= '<a href="' . $url . '" class="messenger-item ic ic-viber"></a>';
    }
    $html .= '</div>';
    echo $html;
}

function print_socials() {
    $html = '<div class="social__grid">';
    if ($url = get_option('vk')) {
        $html .= '<a href="' . $url . '" class="social-item ic ic-vk"></a>';
    }
    if ($url = get_option('facebook')) {
        $html .= '<a href="' . $url . '" class="social-item ic ic-facebook"></a>';
    }
    if ($url = get_option('instagram')) {
        $html .= '<a href="' . $url . '" class="social-item ic ic-instagram"></a>';
    }
    $html .= '</div>';
    echo $html;
}
