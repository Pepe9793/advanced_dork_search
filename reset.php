<?php
require_once __DIR__ . '/config.php';

function is_activated(): bool {
    if (!file_exists(ACTIVATED_FILE)) return false;
    $data = json_decode(@file_get_contents(ACTIVATED_FILE), true);
    return is_array($data) && ($data['activated'] ?? false) === true;
}

// redirect based on activation
if (is_activated()) {
    header("Location: ui.php");
} else {
    header("Location: activation.php");
}
exit;
?>
