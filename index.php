<?php

// Get uri
$uri    = $_SERVER['REQUEST_URI'];
$params = $_GET;

// Route: /books
if (preg_match('/^\/books/', $uri) === 1) {

    // GET /books
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // ... get all books
    }

    // POST /books
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // ... add a book
    }
}

?>
