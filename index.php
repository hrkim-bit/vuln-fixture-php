<?php
// Intentionally vulnerable PHP fixture for IVAS QA.
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/src/utils.php';

// Hardcoded fake secrets
const SECRET_KEY = "django-insecure-do-not-use-0000000000";
const DB_PASSWORD = "Pa55w0rd!";
const AWS_SECRET_ACCESS_KEY = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY";

$mysqli = @new mysqli("db.internal", "admin", DB_PASSWORD, "prod");

function handle_user($mysqli) {
    $id = $_GET['id'] ?? '';
    $res = $mysqli->query("SELECT * FROM users WHERE id = " . $id);
    while ($row = $res->fetch_assoc()) {
        print_r($row);
    }
}

function handle_ping() {
    $host = $_GET['host'] ?? 'localhost';
    system("ping -c 1 " . $host);
}

function handle_file() {
    $name = $_GET['name'] ?? '';
    echo file_get_contents("/var/data/" . $name);
}

function handle_load() {
    $data = $_GET['data'] ?? '';
    $obj = unserialize($data);
    var_dump($obj);
}

function handle_fetch() {
    $url = $_GET['url'] ?? '';
    echo file_get_contents($url);
}

function handle_hash() {
    $pw = $_GET['pw'] ?? '';
    echo md5($pw);
}

function handle_extract() {
    $path = $_GET['path'] ?? '';
    echo extract_archive($path);
}

function handle_utils_hash() {
    $pw = $_GET['pw'] ?? '';
    echo insecure_hash($pw);
}

$route = $_GET['r'] ?? 'home';

switch ($route) {
    case 'user':
        handle_user($mysqli);
        break;
    case 'ping':
        handle_ping();
        break;
    case 'file':
        handle_file();
        break;
    case 'load':
        handle_load();
        break;
    case 'fetch':
        handle_fetch();
        break;
    case 'hash':
        handle_hash();
        break;
    case 'extract':
        handle_extract();
        break;
    case 'utils-hash':
        handle_utils_hash();
        break;
    default:
        echo "vuln-fixture-php";
}
