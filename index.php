<?php

// Get uri
$uri = $_SERVER['REQUEST_URI'];

// DB connection arguments
$serverName = "localhost";
$username   = "root";
$password   = "";
$dbName     = "books";

// Start DB connection
$dbCon = mysqli_connect($serverName, $username, $password);

// Create Database
$dbQuery = "CREATE DATABASE IF NOT EXISTS " . $dbName;
mysqli_query($dbCon, $dbQuery);

// Select Database
mysqli_select_db($dbCon, $dbName);

// Create Table
$tableQuery = "CREATE TABLE IF NOT EXISTS books (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  author VARCHAR(50) NOT NULL
)";
mysqli_query($dbCon, $tableQuery);

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
      $params = $_GET;
      // TODO: ... get all books
    }

    // POST /books
    if (is_method('POST')) {
      $params = $_POST;



      $book = [
        'name'   => $params['name'],
        'author' => $params['author']
      ];

      // Set response code 201 CREATED
      http_response_code(201);

      // Return book in JSON form
      echo json_encode($book);
    }
}

?>
