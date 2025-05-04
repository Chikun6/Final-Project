<?php
header("Access-Control-Allow-Origin: *"); // For development only
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Replace with your Gemini API key
$API_KEY = "AIzaSyBdMp3ia7sqT1XFIR3aUwLli5zUETO3mek";

// Read input JSON from frontend
$input = json_decode(file_get_contents("php://input"), true);
$user_message = $input['message'] ?? '';

if (!$user_message) {
    echo json_encode(["error" => "No message provided."]);
    exit;
}

// Prepare Gemini API request
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=$API_KEY";

$payload = json_encode([
    "contents" => [
    [
        "role" => "user",
        "parts" => [
            ["text" => $user_message]
        ]
    ]
]

]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
curl_close($ch);

// Return Gemini's response to frontend
echo $response;
