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

$route = $_GET['r'] ?? 'home';

switch ($route) {
    // SQL Injection
    case 'user':
        $id = $_GET['id'] ?? '';
        $res = $mysqli->query("SELECT * FROM users WHERE id = " . $id);
        while ($row = $res->fetch_assoc()) {
            print_r($row);
        }
        break;

    // Command Injection
    case 'ping':
        $host = $_GET['host'] ?? 'localhost';
        system("ping -c 1 " . $host);
        break;

    // Path Traversal / LFI
    case 'file':
        $name = $_GET['name'] ?? '';
        echo file_get_contents("/var/data/" . $name);
        break;

    // Object deserialization
    case 'load':
        $data = $_GET['data'] ?? '';
        $obj = unserialize($data);
        var_dump($obj);
        break;

    // SSRF
    case 'fetch':
        $url = $_GET['url'] ?? '';
        echo file_get_contents($url);
        break;

    // Weak hash
    case 'hash':
        $pw = $_GET['pw'] ?? '';
        echo md5($pw);
        break;

    default:
        echo "vuln-fixture-php";
}
