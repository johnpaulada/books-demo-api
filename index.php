<?php

// Get uri
$uri    = $_SERVER['REQUEST_URI'];
$params = $_GET;

function is_method($method) {
  return $_SERVER['REQUEST_METHOD'] === $method;
}

// Route: /books
if (preg_match('/^\/books/', $uri) === 1) {

    // GET /books
    if (is_method('GET')) {
      // TODO: ... get all books
    }

    // POST /books
    if (is_method('POST')) {
      // TODO: ... add a book
    }
}

?>
