<?php
require_once __DIR__ . '/session.php';
function isGuest(): bool {
    return !isset($_SESSION['user_id']);
}

function isAuthenticated(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isAuthenticated() && ($_SESSION['user_role'] ?? '') === 'admin';
}

function isUser(): bool {
    return isAuthenticated() && ($_SESSION['user_role'] ?? '') === 'client';
}
function guestOnly(): void {
    if (isAuthenticated()) {
        header('Location: index.php');
        exit;
    }
}
function authOnly(): void {
    if (!isAuthenticated()) {
        header('Location: index.php?page=login');
        exit;
    }
}
function adminOnly(): void {
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}
