<?php
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/database.php';
$pdo = getDB();
require __DIR__ . '/routes.php';
