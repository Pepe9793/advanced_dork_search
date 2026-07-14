<?php
// config.php
// -----------------------------
// Edit these values BEFORE using the app.

// A secret string used to sign activation keys.
// Choose a strong random secret (store offline/secure).
// Example: use a long random string.
define('ACTIVATION_SECRET', 'ReplaceThisWithAStrongRandomSecret_ChangeMeNow!');

// Where activation state is stored (file will be created after activation)
define('ACTIVATED_FILE', __DIR__ . '/activated.json');

// Optional: require activation keys to include an expiry timestamp (in days).
// Set to 0 to never expire keys, or >0 to make keys valid for that many days after activation.
define('KEY_EXPIRY_DAYS', 0);

// Optional: require keys only for first activation (true) or require re-check every launch (false).
// For local convenience keep true.
define('ONE_TIME_ACTIVATION', true);

// End of config.
