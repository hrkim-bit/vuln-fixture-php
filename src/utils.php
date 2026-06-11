<?php
// Intentionally vulnerable helpers for IVAS QA.

const HARDCODED_TOKEN = "ghp_CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC2222";

// Command Injection
function extract_archive($userInput) {
    return shell_exec("tar xzf " . $userInput);
}

// Weak hash
function insecure_hash($password) {
    return md5($password);
}
