<?php
/*
Plugin Name: QRMemo
Plugin URI: 
Description: Adds a QR code at the end of each page and post with the current page URL. Also supports generating QR codes via shortcode.
Version: 1.0
Author: mrpro64
Author URI: https://paolobertinetti.it/web
License: GPL2
Text Domain: qrmemo
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Carica l'autoloader di Composer
require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

// Carica il textdomain per le traduzioni
function qrmemo_load_textdomain() {
    load_plugin_textdomain('qrmemo', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'qrmemo_load_textdomain');

// Genera il QR code come immagine PNG codificata in base64
function qrmemo_generate_qrcode($url) {
    // Crea l'oggetto QR Code
    $qrCode = QrCode::create($url)
        ->setEncoding(new Encoding('UTF-8'))
        ->setSize(100)
        ->setMargin(5);

    // Scrittore PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Converte il QR Code in base64
    return 'data:image/png;base64,' . base64_encode($result->getString());
}

// Aggiungi il QR code al contenuto
function qrmemo_add_qrcode_to_content($content) {
    $post_types = get_option('qrmemo_post_types', []);

    // Controlla se il tipo di post è abilitato
    if (in_array(get_post_type(), $post_types)) {
        $url = get_permalink();
        $qrcode_base64 = qrmemo_generate_qrcode($url);
        $qrcode_img = '<div class="qrcode" style="text-align: center; margin-top: 20px;">
                       <img src="' . $qrcode_base64 . '" alt="' . esc_attr__('QR Code', 'qrmemo') . '" />
                       </div>';
        $content .= $qrcode_img;
    }

    return $content;
}
add_filter('the_content', 'qrmemo_add_qrcode_to_content');

// Definisci lo shortcode per generare il QR code
function qrmemo_shortcode($atts) {
    // Estrai gli attributi dello shortcode
    $atts = shortcode_atts(
        array(
            'text' => '',
            'size' => 100,
            'margin' => 5,
            'align' => 'center', // Allineamento: left, center, right
        ),
        $atts,
        'qrmemo'
    );

    if (empty($atts['text'])) {
        return ''; // Se il testo è vuoto, non generare nulla
    }

    // Determina lo stile di allineamento
    $alignment = 'text-align: ' . esc_attr($atts['align']) . ';';

    // Genera il QR code usando il testo fornito
    $qrCode = QrCode::create($atts['text'])
        ->setEncoding(new Encoding('UTF-8'))
        ->setSize($atts['size'])
        ->setMargin($atts['margin']);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Converte il QR code in base64
    $qrcode_base64 = 'data:image/png;base64,' . base64_encode($result->getString());

    // Ritorna l'immagine del QR code con allineamento
    return '<div class="qrcode" style="' . $alignment . ' margin-top: 20px;">
                <img src="' . $qrcode_base64 . '" alt="' . esc_attr__('QR Code', 'qrmemo') . '" />
            </div>';
}

// Registra lo shortcode
add_shortcode('qrmemo', 'qrmemo_shortcode');

// Aggiungi il menu di amministrazione per le impostazioni
function qrmemo_add_admin_menu() {
    add_options_page(
        __('QRMemo Settings', 'qrmemo'),
        __('QRMemo', 'qrmemo'),
        'manage_options',
        'qrmemo',
        'qrmemo_settings_page'
    );
}
add_action('admin_menu', 'qrmemo_add_admin_menu');

// Includi la pagina delle impostazioni
require_once(plugin_dir_path(__FILE__) . 'admin-settings.php');