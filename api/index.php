<?php

// Ensure database file exists in /tmp for serverless environment
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (!file_exists($targetDb) && file_exists($sourceDb)) {
    copy($sourceDb, $targetDb);
} elseif (!file_exists($targetDb)) {
    touch($targetDb);
}

// Point SQLite environment to /tmp/database.sqlite so Laravel can read & write
putenv('DB_DATABASE=' . $targetDb);
$_ENV['DB_DATABASE'] = $targetDb;
$_SERVER['DB_DATABASE'] = $targetDb;

require __DIR__ . '/../public/index.php';
