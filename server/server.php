<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Add the following lines to set CORS headers
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (you can restrict this in a production environment)
header("Access-Control-Allow-Methods: POST"); // Allow POST requests
header("Access-Control-Allow-Methods: GET"); // Allow POST requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow Content-Type header


$response = [
  "success" => true,
  "message" => "Servidor Online."
];
    


// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

// Close the database connection
$conn = null;

?>