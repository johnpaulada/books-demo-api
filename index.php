<?php

// Get uri
$uri    = $_SERVER['REQUEST_URI'];
$params = $_GET;

// Route: /books
if (preg_match('/^\/books/', $uri) === 1) {
  // ... check for different HTTP methods
}

?>
