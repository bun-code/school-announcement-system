<?php

// config/admin.php
// ─────────────────────────────────────────────────────────────
// Central admin configuration.
// Update 'allowed_emails' to match the emails you seeded.
// Must also match ALLOWED_ADMINS in AdminLogin.php
// ─────────────────────────────────────────────────────────────

return [

    // Only these emails can access /admin/* protected routes.
    // Add your actual admin email(s) here.
    // Leave empty [] to allow ALL authenticated users (not recommended for production).
    'allowed_emails' => [
        env('ADMIN_EMAIL_1', 'admin1@taboc.edu.ph'),
        env('ADMIN_EMAIL_2', 'admin2@taboc.edu.ph'),
    ],

];