<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "200.98.129.120:3306";
$username = 'marcosvir_lucasJ';
$password = 'H6sJ{Ez7+M0a';
$database = 'marcosvir_lucasj_todoApp';

// Add the following lines to set CORS headers
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (you can restrict this in a production environment)
header("Access-Control-Allow-Methods: POST"); // Allow POST requests
header("Access-Control-Allow-Methods: GET"); // Allow POST requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow Content-Type header

try {
  $conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}


$inputFile = file_get_contents('php://input');
if ($data = json_decode($inputFile, true)) {

  if (json_last_error() === JSON_ERROR_NONE) {
    $stmt = $conn->prepare('SELECT idUser, username, email, password, profileImage FROM User Where email = :email');

    $stmt->bindParam(':email', $data['email']);

    $stmt->execute();

    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);;


    if ($res == []) {
      $response = [
        "success" => false,
        "message" => "Email or password incorrect! - email",
      ];
    } else {
      $auth = password_verify($data["password"], $res[0]["password"]);

      if ($auth) {
        $user = [
          "idUser" => $res[0]["idUser"],
          "username" => $res[0]["username"],
          "email" => $res[0]["email"],
          "profileImage" => $res[0]["profileImage"],
        ];

        $response = [
          "success" => true,
          "message" => "You are logged",
          "user" => $user
        ];
      } else {
        $response = [
          "success" => false,
          "message" => "Email or password incorrect! - pass",
        ];
      }
    }
  } else {
    $response = [
      "success" => false,
      "message" => "Invalid JSON format."
    ];
  }
} else {
  // No data provided
  $response = [
    "success" => false,
    "message" => "Input JSON file not found."
  ];
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

// Close the database connection
$conn = null;
