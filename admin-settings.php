<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Callback della pagina delle impostazioni
function qrmemo_settings_page() {
    // Ottieni i tipi di post pubblici, escludendo 'attachment'
    $post_types = get_post_types(['public' => true], 'objects');
    
    // Rimuovi il tipo di post 'attachment' (Media)
    unset($post_types['attachment']);

    $selected_post_types = get_option('qrmemo_post_types', []);
?>
    <div class="wrap">
        <h1><?php esc_html_e('QRMemo Settings', 'qrmemo'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('qrmemo_settings_group');
            do_settings_sections('qrmemo');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Enable QR Code for the following post types', 'qrmemo'); ?>:</th>
                    <td>
                        <ul>
                            <?php foreach ($post_types as $post_type) : ?>
                                <li>
                                    <label>
                                        <input type="checkbox" name="qrmemo_post_types[]" value="<?php echo esc_attr($post_type->name); ?>"
                                            <?php echo in_array($post_type->name, $selected_post_types) ? 'checked' : ''; ?> />
                                        <?php echo esc_html($post_type->label); ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <p>
            <?php esc_html_e('To add a QR Code via shortcode, use the following syntax', 'qrmemo'); ?>:
            </p>
                <p style="margin-left: 20px;">
                    [qrmemo text="<i><?php esc_html_e('text to encode', 'qrmemo'); ?></i>" size="<i><?php esc_html_e('size in pixel', 'qrmemo'); ?></i>" margin="<i><?php esc_html_e('margin in pixel', 'qrmemo'); ?></i>" align="<i><?php esc_html_e('left|center|right', 'qrmemo'); ?></i>"]
                </p>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Registra e definisci le impostazioni
function qrmemo_register_settings() {
    register_setting('qrmemo_settings_group', 'qrmemo_post_types');

    add_settings_section(
        'qrmemo_settings_section',
        __('Main Settings', 'qrmemo'),
        'qrmemo_settings_section_callback',
        'qrmemo'
    );
}
add_action('admin_init', 'qrmemo_register_settings');

// Callback della sezione delle impostazioni
function qrmemo_settings_section_callback() {
    echo '<p>' . esc_html_e('Configure the settings for QRMemo', 'qrmemo') . '</p>';
}