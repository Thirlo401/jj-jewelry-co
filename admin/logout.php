<?php
// Bootstrap - load essentials before any output
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

// Handle logout and redirect
logoutAdmin();
redirect(BASE_URL . '/admin/login.php');
