<?php

// Get uri
$uri = $_SERVER['REQUEST_URI'];

// Add CORS
header("Access-Control-Allow-Origin: *");

// DB connection arguments
$serverName = "localhost";
$username   = "root";
$password   = "";
$dbName     = "books";

$dbCon = connectToBooksDB($serverName, $username, $password, $dbName);

// Route: /books
if (matches('/^\/books$/', $uri)) {

    // GET /books
    if (is_method('GET')) {
      $params = $_GET;

      $booksQuery = "SELECT * FROM books";
      $results = mysqli_query($dbCon, $booksQuery);
      $books = [];

      // Set response code to 200 OK
      http_response_code(200);

      // Check if there are books
      if (mysqli_num_rows($results) > 0) {
        while($row = mysqli_fetch_assoc($results)) {
          array_push($books, $row);
        }

        echo json_encode($books);
      }
      else {
        echo json_decode(['msg' => "No results."]);
      }
    }

    // POST /books
    if (is_method('POST')) {
      $params = $_POST;

      if (!isset($params['name']) || !isset($params['author'])) {
        // Set response code to 400 BAD REQUEST
        http_response_code(400);

        // Return error
        echo json_encode(['error' => "Book must have a name and an author."]);
        exit;
      }

      $book = [
        'name'   => $params['name'],
        'author' => $params['author']
      ];

      $bookQuery = 'INSERT INTO books (name, author)
                    VALUES ("' . $book['name'] . '", "' . $book['author'] . '")';

      if (mysqli_query($dbCon, $bookQuery)) {
        // Set response code 201 CREATED
        http_response_code(201);

        // Return book in JSON form
        echo json_encode($book);
      }
      else {
        // Set response code to 500 INTERNAL SERVER ERROR
        http_response_code(500);

        // Return error
        echo json_encode(['error' => "The book probably exists already."]);
      }
    }
}
else if (matches('/^\/books\/\w+$/', $uri)) {
  // Get book ID
  $bookId = intval(str_replace('/books/', '', $uri));

  $booksQuery = "SELECT * FROM books WHERE id=" . $bookId;
  $results = mysqli_query($dbCon, $booksQuery);
  $book = [];

  // Set response code to 200 OK
  http_response_code(200);

  // Check if a book was found
  if (mysqli_num_rows($results) > 0) {
    $book = mysqli_fetch_assoc($results);
    echo json_encode($book);
  }
  else {
    echo json_encode(['msg' => "No such book."]);
  }
}

function is_method($method)
{
  return $_SERVER['REQUEST_METHOD'] === $method;
}

function matches($regex, $uri)
{
  return preg_match($regex, $uri) === 1;
}

function connectToBooksDB($sn, $un, $pw, $db)
{
  // Start DB connection
  $dbCon = mysqli_connect($sn, $un, $pw);

  // Create Database
  $dbQuery = "CREATE DATABASE IF NOT EXISTS " . $db;
  mysqli_query($dbCon, $dbQuery);

  // Select Database
  mysqli_select_db($dbCon, $db);

  // Create Table
  $tableQuery = "CREATE TABLE IF NOT EXISTS books (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    author VARCHAR(50) NOT NULL
  )";
  mysqli_query($dbCon, $tableQuery);

  return $dbCon;
}

?>
