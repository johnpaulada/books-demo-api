<?php

// Get uri
$uri    = $_SERVER['REQUEST_URI'];
$params = $_GET;

function is_method($method) {
  return $_SERVER['REQUEST_METHOD'] === $method;
}

function matches($regex, $uri) {
  return preg_match($regex, $uri) === 1;
}

// Route: /books
if (matches('/^\/books$/', $uri)) {

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
