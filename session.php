<?php
// Always configure session BEFORE starting it

if (session_status() === PHP_SESSION_NONE) {
    // Secure session settings
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);

    session_start();
}
?>