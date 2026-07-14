<?php
require_once __DIR__ . '/config.php';

function machine_fingerprint(): string {
    $parts = [
        php_uname('s'), php_uname('n'), php_uname('r'),
        php_uname('v'), php_uname('m'),
        gethostname() ?: '', php_uname() ?: ''
    ];
    return hash('sha256', implode('|', $parts));
}

function key_is_valid_for_fingerprint(string $key, string $fingerprint): array {
    $parts = explode('|', $key);
    $sig = trim($parts[0]);
    $expiry_ts = isset($parts[1]) ? (int)$parts[1] : null;

    if ($expiry_ts) {
        $expected = hash_hmac('sha256', $fingerprint . '|' . $expiry_ts, ACTIVATION_SECRET);
        if (hash_equals($expected, $sig)) {
            if ($expiry_ts !== 0 && time() > $expiry_ts)
                return ['ok' => false, 'reason' => 'Key has expired.'];
            return ['ok' => true, 'expiry_ts' => $expiry_ts];
        } else return ['ok' => false, 'reason' => 'Signature mismatch.'];
    }

    $expected = hash_hmac('sha256', $fingerprint, ACTIVATION_SECRET);
    return hash_equals($expected, $sig)
        ? ['ok' => true, 'expiry_ts' => null]
        : ['ok' => false, 'reason' => 'Signature mismatch.'];
}

function is_activated(): bool {
    if (!file_exists(ACTIVATED_FILE)) return false;
    $data = json_decode(@file_get_contents(ACTIVATED_FILE), true);
    if (!is_array($data) || !isset($data['fingerprint'])) return false;
    return $data['fingerprint'] === machine_fingerprint() && $data['activated'] === true;
}

function set_activated($extra = []) {
    $data = array_merge([
        'activated' => true,
        'fingerprint' => machine_fingerprint(),
        'activated_at' => date(DATE_ATOM)
    ], $extra);
    file_put_contents(ACTIVATED_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

$activation_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'activate') {
    $key = trim($_POST['activation_key'] ?? '');
    if ($key === '') {
        $activation_error = 'Please enter an activation key.';
    } else {
        $check = key_is_valid_for_fingerprint($key, machine_fingerprint());
        if ($check['ok']) {
            set_activated(['key_expiry_ts' => $check['expiry_ts'] ?? null]);
            header("Location: ui.php");
            exit;
        } else {
            $activation_error = 'Activation failed: ' . $check['reason'];
        }
    }
}

if (is_activated()) {
    header("Location: ui.php");
    exit;
}

$fingerprint = machine_fingerprint();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Activation | AdvancedDorkSearch</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style>
body { background: #f5f5f5; }
.container { max-width: 700px; margin-top: 60px; }
pre.fprint { background:#fafafa; padding:10px; border-radius:6px; }
</style>
</head>
<body>
<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading"><strong>Activate Your Tool</strong></div>
        <div class="panel-body">
            <p>This tool requires activation tied to your machine fingerprint.</p>
            <?php if ($activation_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($activation_error) ?></div>
            <?php endif; ?>
            <p><strong>Machine Fingerprint:</strong></p>
            <pre class="fprint"><?= htmlspecialchars($fingerprint) ?></pre>
            <form method="post" class="form-inline">
                <input type="hidden" name="action" value="activate">
                <div class="form-group" style="width:55%;">
                    <input type="text" name="activation_key" class="form-control" placeholder="Enter activation key" style="width:100%;" required>
                </div>
                <button type="submit" class="btn btn-success">Activate</button>
                <a href="generate_key.php" class="btn btn-success" style="background-color: #007bff; border-color: #007bff; color: white;">
    Generate Activation Key
</a>


            </form>
        </div>
    </div>
</div>
</body>
</html>
