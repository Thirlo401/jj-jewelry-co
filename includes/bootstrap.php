<?php
/**
 * Bootstrap - Load essentials WITHOUT outputting HTML
 * Use this for pages that need to redirect (no HTML output before redirect)
 * Then include header.php when ready to render
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/helpers.php';
