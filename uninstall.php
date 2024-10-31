<?php
// Verifica che la disinstallazione sia avviata correttamente da WordPress
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Rimuovi tutte le opzioni salvate dal plugin
delete_option('qrmemo_post_types');