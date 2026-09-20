<?php
require_once __DIR__ . '/header.php';

// Handle logout
logoutAdmin();
redirect(BASE_URL . '/admin/login.php');
